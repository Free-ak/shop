<?php
header('Content-type: text/html; charset=utf-8');

include "auth.php";
error_reporting(E_ALL);
/*
	if (!in_array($_SESSION['level'], array(10))) { // доступ разрешен только группе пользователей
		header("Location: login.php"); // остальных просим залогиниться
		exit;
	};
	*/

/*
   Скрипт - просмотр товаров в категории
   */
include "database.php";
include "func.php";
include "styles.php";
include "scripts.php";
$con = connect();
$title = 'Товары';
$table = 'products';
?>

<script>

	// вернуть сумму и количество единиц в корзине пользователя
	function get_cart_info() {
		$.ajax({
			url: 'ajax/ajax_get_cart_info.php',
			type: 'POST',
			async: true,
			dataType: "JSON",
			data: {
				user_id: '<?php echo $_SESSION['id']; ?>'
			},
			beforeSend: function () {
			},
			complete: function () {
			},
			success: function (response) {
				$('#cart_info').html('Корзина (' + response.amount + ')');
			},
			error: function (objAJAXRequest, strError) {
				alert('Произошла ошибка! Тип ошибки: ' + strError);
			}
		});
	};

	// сразу после загрузки страницы выполнить
	$(function () {
		get_cart_info();
	});

	// добавлям товар в корзину пользователю
	// добавляем товар в корзину пользователю
function to_cart(id) {
    var user_id = '<?php echo isset($_SESSION["id"]) ? $_SESSION["id"] : ""; ?>';
    if (user_id === '') {
        // Если пользователь не авторизован, показываем сообщение об ошибке и предлагаем авторизоваться
        alert('Пожалуйста, авторизуйтесь, чтобы добавить товар в корзину.');
        // Можно также перенаправить пользователя на страницу авторизации
        // window.location.href = 'login.php';
        return;
    }

    $.ajax({
        url: 'ajax/ajax_add_to_cart.php',
        type: 'POST',
        async: true,
        data: {
            id: id,
            user_id: user_id
        },
        beforeSend: function () {
            // Действия перед отправкой запроса, если необходимо
        },
        complete: function () {
            // Действия после завершения запроса, если необходимо
        },
        success: function (response) {
            if (response == 'ok') {
                get_cart_info();
                alert('Добавлено в корзину!');
            } else {
                alert('Ошибка: ' + response);
                console.log(response);
            }
        },
        error: function (objAJAXRequest, strError) {
            alert('Произошла ошибка! Тип ошибки: ' + strError + '. Сообщение: ' + objAJAXRequest.responseText);
        }
    });
}


</script>
<html>

<head>
	<meta charset="utf-8">
	<title>
		<?php echo $title; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
		function btn_reset_click() {
			$('input').val('');
		};
	</script>

	<style>
		input {
			width: 100%;
		}
	</style>

</head>

<body>
	<table id="main_table">
		<!-- баннер -->
		<tr>
			<td colspan=2 style="text-align:center">
				<?php
				include('top.php');
				?>
			</td>
		</tr>

		<tr>
			<!-- меню -->
			<td width="300px" style="vertical-align:top;">
				<?php
				include('menu.php');
				include('showcase.php');
				?>
			</td>

			<!-- контент -->
			<td width="900px">
				<form id="search_form" method="GET">
					<select name="carbrand" id="carbrand">
						<option value='0'>Выбор марки автомобиля</option>";
						<?php
						$query = "SELECT id, name FROM car_brand where id <> 0";
						$result = mysqli_query($con, $query);
						// Проверка наличия данных
						if (mysqli_num_rows($result) > 0) {
							// Отображение опций для каждой модели автомобиля
							while ($row = mysqli_fetch_assoc($result)) {
								echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
							}
						} else {
							echo '<option value="">Данные не найдены</option>';
						}
						?>
					</select>
					<select name="carmodel" id="carmodel">
						<option value="">Выберите модель автомобиля</option>
						<?php
						// Если марка автомобиля уже выбрана, загружаем модели для этой марки
						if (isset($_GET['carbrand']) && !empty($_GET['carbrand'])) {
							$carbrand_id = $_GET['carbrand'];
							// Запрос для выбора моделей автомобилей по выбранной марке
							$query = "SELECT id, name FROM car_model WHERE car_brand = $carbrand_id";
							$result = mysqli_query($con, $query);
							// Проверка наличия данных
							if (mysqli_num_rows($result) > 0) {
								// Отображение опций для каждой модели автомобиля
								while ($row = mysqli_fetch_assoc($result)) {
									echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
								}
							} else {
								echo '<option value="">Модели не найдены</option>';
							}
						}
						?>
					</select>
					<select name="type_of_light_product" id="type_of_light_product">
						<option value="">Выберите тип оптики</option>
						<option value="Передние фары">Передние фары</option>
						<option value="Задние фонари">Задние фонари</option>
						<option value="Противотуманные фары">Противотуманные фары</option>
						<option value="Дневные ходовые огни">Дневные ходовые огни</option>
					</select>

					<select name="country" id="country">
						<option value="">Выберите страну производителя</option>
						<?php
						// Если марка автомобиля уже выбрана, загружаем модели для этой марки
						
						// Запрос для выбора страны производителя
						$query = "SELECT id, descr FROM manufacturer_country where id <> 0";
						$result = mysqli_query($con, $query);
						// Проверка наличия данных
						if (mysqli_num_rows($result) > 0) {
							// Отображение 
							while ($row = mysqli_fetch_assoc($result)) {
								echo "<option value=\"{$row['id']}\">{$row['descr']}</option>";
							}
						} else {
							echo '<option value="">Страна не найдена</option>';
						}

						?>
					</select>
				</form>

				<script>
					// Скрипт для выбора марки автомобиля
					const carbrandSelect = document.getElementById('carbrand');
					carbrandSelect.addEventListener('change', function () {
						const selectedCarbrand = carbrandSelect.value;
						let url = window.location.href;
						let searchParams = new URLSearchParams(window.location.search);
						searchParams.set('carbrand', selectedCarbrand);
						url = url.split('?')[0] + '?' + searchParams.toString();
						window.location.href = url;
					});
					const carbrandParam = (new URLSearchParams(window.location.search)).get('carbrand');
					if (carbrandParam) {
						carbrandSelect.value = carbrandParam;
					}

					// Скрипт для выбора модели автомобиля
					const carmodelSelect = document.getElementById('carmodel');
					carmodelSelect.addEventListener('change', function () {
						const selectedCarmodel = carmodelSelect.value;
						let url = window.location.href;
						let searchParams = new URLSearchParams(window.location.search);
						searchParams.set('carmodel', selectedCarmodel);
						url = url.split('?')[0] + '?' + searchParams.toString();
						window.location.href = url;
					});
					const carmodelParam = (new URLSearchParams(window.location.search)).get('carmodel');
					if (carmodelParam) {
						carmodelSelect.value = carmodelParam;
					}

					// Скрипт для выбора страны
					const countrySelect = document.getElementById('country');
					countrySelect.addEventListener('change', function () {
						const selectedCountry = countrySelect.value;
						let url = window.location.href;
						let searchParams = new URLSearchParams(window.location.search);
						searchParams.set('country', selectedCountry);
						url = url.split('?')[0] + '?' + searchParams.toString();
						window.location.href = url;
					});
					const countryParam = (new URLSearchParams(window.location.search)).get('country');
					if (countryParam) {
						countrySelect.value = countryParam;
					}

					// Скрипт для выбора типа оптики
					const type_of_light_productSelect = document.getElementById('type_of_light_product');
					type_of_light_productSelect.addEventListener('change', function () {
						const selectedType_of_light_product = type_of_light_productSelect.value;
						let url = window.location.href;
						let searchParams = new URLSearchParams(window.location.search);
						searchParams.set('type_of_light_product', selectedType_of_light_product);
						url = url.split('?')[0] + '?' + searchParams.toString();
						window.location.href = url;
					});
					const type_of_light_productParam = (new URLSearchParams(window.location.search)).get('type_of_light_product');
					if (type_of_light_productParam) {
						type_of_light_productSelect.value = type_of_light_productParam;
					}
				</script>

				<h1>
					<?php echo $title; ?>
				</h1>
				<div id="products-container">
					<!-- Сюда будут добавлены товары -->

				</div>
				<?php
				$carbrand = empty($_GET['carbrand']) ? '' : abs(intval($_GET['carbrand']));
				if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['carbrand'])) {
					if (!empty($carbrand)) {
						// Если выбрана марка автомобиля
						$query = "SELECT name FROM car_brand WHERE id=$carbrand";
						$res = mysqli_query($con, $query) or die(mysqli_error($con));
						if ($row = mysqli_fetch_array($res)) {
							// Если удалось извлечь имя марки автомобиля
							$carbrand_name = $row['name'];
							// Запрос для проверки наличия оптики для марки автомобиля
							$query = "SELECT * FROM `$table`
									  LEFT JOIN `car_brand` ON `$table`.carbrand = `car_brand`.id
									  WHERE `car_brand`.name = '$carbrand_name' AND `car_brand`.id <> 0";
							$res2 = mysqli_query($con, $query) or die(mysqli_error($con));
							if ($row2 = mysqli_fetch_array($res2)) {
								// Если удалось извлечь информацию о модели автомобиля
								echo "<h2>Марка: $carbrand_name</h2>";
							} else {
								// Если альтернативная оптика отсутствует
								echo "<h2>Извините, альтернативная оптика для автомобиля марки: $carbrand_name отсутствует.</h2>";
							}
						} else {
							// Если не удалось найти информацию о марке автомобиля
							echo "<h2>Извините, информация о выбранной марке автомобиля отсутствует.</h2>";
						}
					}
				}
				$filter_carbrand = $carbrand == 0 ? '' : "AND `$table`.`carbrand`='$carbrand'"; // если категория не выбрана, показать все товары
				$carmodel = empty($_GET['carmodel']) ? '' : abs(intval($_GET['carmodel']));
				if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['carmodel'])) {
					if (!empty($carmodel)) {
						// Если выбрана модель автомобиля
						$query = "SELECT name FROM car_model WHERE id=$carmodel";
						$res = mysqli_query($con, $query) or die(mysqli_error($con));
						if ($row = mysqli_fetch_array($res)) {
							// Если удалось извлечь имя модели автомобиля
							$carmodel_name = $row['name'];
							// Запрос для проверки наличия оптики для модели автомобиля
							$query = "SELECT * FROM `$table`
                      LEFT JOIN `car_model` ON `$table`.carmodel = `car_model`.id
                      WHERE `car_model`.name = '$carmodel_name' AND `car_model`.id <> 0";
							$res2 = mysqli_query($con, $query) or die(mysqli_error($con));
							if ($row2 = mysqli_fetch_array($res2)) {
								// Если удалось извлечь информацию о модели автомобиля
								echo "<h2>Модель: $carmodel_name</h2>";
							} else {
								// Если альтернативная оптика отсутствует
								echo "<h2>Извините, альтернативная оптика для автомобиля модели: $carmodel_name отсутствует.</h2>";
							}
						} else {
							// Если не удалось найти информацию о модели автомобиля
							echo "<h2>Извините, информация о выбранной модели автомобиля отсутствует.</h2>";
						}
					}
				}

				$filter_carmodel = $carmodel == 0 ? '' : "AND `$table`.`carmodel`='$carmodel'"; // если модель не выбрана, показать все товары
				
				$country = empty($_GET['country']) ? '' : abs(intval($_GET['country']));
				if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['country'])) {
					if (!empty($country)) {
						// Если выбрана страна
						$query = "SELECT descr FROM manufacturer_country WHERE id=$country";
						$res = mysqli_query($con, $query) or die(mysqli_error($con));
						if ($row = mysqli_fetch_array($res)) {
							// Если удалось извлечь название страны
							$country_name = $row['descr'];
							// Запрос для проверки наличия оптики для выбранной страны
							$query = "SELECT * FROM `$table`
                      WHERE `country` = '$country_name'";
							$res2 = mysqli_query($con, $query) or die(mysqli_error($con));
							if ($row2 = mysqli_fetch_array($res2)) {
								// Если удалось извлечь информацию о товарах из этой страны
								echo "<h2>Страна производства: $country_name</h2>";
							}
							// else {
							// 	// Если альтернативная оптика отсутствует
							// 	echo "<h2>Извините, альтернативная оптика из страны: $country_name отсутствует.</h2>";
							// }
						} else {
							// Если не удалось найти информацию о стране
							echo "<h2>Извините, информация о выбранной стране отсутствует.</h2>";
						}
					}
				}
				$filter_country = $country == 0 ? '' : "AND `$table`.`country`='$country'"; // если страна не выбрана, показать все товары
				
				$type_of_light_product = isset($_GET['type_of_light_product']) ? $_GET['type_of_light_product'] : '';

				$query = "
    SELECT t.*, AVG(r.estimation) AS avg_estimation
    FROM (
        SELECT
            `$table`.`id`,
            `$table`.`name`,
            `$table`.`descr`,
            `car_model`.`name` AS `category`,
            `$table`.`price`,
            `$table`.`type_of_light_product`,
            `$table`.`carbrand`,
            `$table`.`carmodel`,
            `$table`.`amount` - IFNULL(ROUND(SUM(`items`.`amount`)),0) AS 'amount',
            `discounts`.`value` AS `discount_value`,
            TIMESTAMPDIFF(DAY, `$table`.`date_add`, NOW()) AS `delta`
        FROM
            `$table`
        LEFT JOIN
            `items` ON `items`.`product_id` = `$table`.`id`
        LEFT JOIN
            `car_model` ON `car_model`.`id` = `$table`.`carmodel`
        LEFT JOIN
            `discounts` ON `discounts`.`id` = `$table`.`discount_id` AND NOW() BETWEEN `discounts`.`start` AND `discounts`.`stop`
        WHERE 1
            $filter_carbrand
            $filter_carmodel
            $filter_country
            AND `$table`.`type_of_light_product` IN (
                SELECT `id` FROM `type_of_light_product` WHERE `descr` LIKE '%$type_of_light_product%'
            )
        GROUP BY `$table`.`id`
        ORDER BY `$table`.`name`
        LIMIT 50
    ) AS t
    LEFT JOIN
        `reviews` AS r ON r.product_id = t.id
    WHERE t.amount > 0
    GROUP BY t.id
";
				$res = mysqli_query($con, $query) or die(mysqli_error($con));
				// собираем данные в массив
				$a = array();
				while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$a[] = $row;
				}
				;
				if (empty($a))
					echo "<h2>Извините, информация  отсутствует.</h2>";

				//var_dump($a);
				// вывод в таблицу
				$in_row = 3; // сколько столбцов товаров
				// количество строк
				$row_count = ceil(count($a) / $in_row);
				echo '<table border=0 style="width:100px">';
				for ($i = 1; $i <= $row_count; $i++) {
					echo "<tr>";
					for ($j = 1; $j <= $in_row; $j++) {
						$ind = ($i - 1) * $in_row + $j - 1;
						if (isset($a[$ind])) {
							$row = $a[$ind];
							$fname = 'upload/' . $row['id'] . '.jpg';
							if (!file_exists($fname)) { // если нет файла, показать "НЕТ ФОТО"
								$fname = 'upload/0.jpg';
							}
							;

							if ($row['delta'] < 30) { // товар добавлен меньше 30 дней назад, т.е. это новинка
								$new = "<div><img src='images/new.png' style='width:100px'></div>";
							} else {
								$new = '';
							}
							;

							if ($row['discount_value']) { // цена со скидкой
								$price_new = number_format(round($row['price'] * (1 - $row['discount_value'] / 100), 2), 2, '.', '');
								$price_str = "
						<font style='color: #888; font-size:x-small; text-decoration:line-through'>$row[price]$valuta</font>
						<img src='images/discount.png' height='24px' title='Скидка'>
						<font style='color: #000;'>$price_new$valuta</font>
					";
								$price_str = trim($price_str);
							} else {
								$price_str = "<font style='color: #000;'>$row[price]$valuta</font>";
							}
							;

							// // обрезать описание, если оно очень длинное
							// if (mb_strlen($row['descr'], 'UTF-8') > 50) {
							// 	$descr = mb_substr($row['descr'], 0, 50, 'UTF-8') . '...';
							// } else {
							// 	$descr = $row['descr'];
							// }
							// ;
							$avg_estimation = isset($row['avg_estimation']) ? round($row['avg_estimation'], 2) : "Пока нет отзывов для этого товара.";
							echo "
				<td style='width:400px; height:400px'>
					$new
					Наименование: <b><a href='card.php?product_id=$row[id]'>$row[name]</a></b><br>
					Цена: $price_str<br>
					Оценка по отзывам: $avg_estimation<br>
					Осталось: $row[amount] шт.<br>
					<img src=\"$fname\" width=\"250px\" height=\"250px\" style='cursor:pointer;' onclick='to_cart($row[id]);'><br>
					<button onclick='to_cart($row[id]);'>В корзину</button>
				</td>
				";
						}
						;
					}
					;
					echo "</tr>";
				}
				;
				echo '</table>';


				?>

			</td>
		</tr>

		<!-- подвал -->
		<tr>
			<td colspan=2>
				<?php
				include('footer.php');
				?>
			</td>
		</tr>

	</table>

</body>

</html>