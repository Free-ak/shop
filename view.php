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
	function to_cart(id) {
		var user_id = '<?php echo $_SESSION["id"]; ?>';
		$.ajax({
			url: 'ajax/ajax_add_to_cart.php',
			type: 'POST',
			async: true,
			data: {
				id: id,
				user_id: user_id
			},
			beforeSend: function () {
			},
			complete: function () {
			},
			success: function (response) {
				if (response == 'ok') {
					get_cart_info();
					alert('Добавлено в корзину!');
				}
				else alert(response);
			},
			error: function (objAJAXRequest, strError) {
				alert('Произошла ошибка! Тип ошибки: ' + strError);
			}
		});

	};
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
						<option value="">Выберите марку автомобиля</option>
						<!-- Ваши варианты марок автомобилей будут здесь -->
						<option value="1">Chevrolet</option>
					</select>
					<select name="carmodel" id="carmodel">
						<option value="">Выберите модель автомобиля</option>
						<!-- Здесь будут отображаться модели автомобилей -->
					</select>
				</form>
				<script>
					// Находим поле выбора марки автомобиля
					const carbrandSelect = document.getElementById('carbrand');
					// Назначаем обработчик события на изменение значения поля выбора марки автомобиля
					carbrandSelect.addEventListener('change', function () {
						// Получаем выбранное значение марки автомобиля
						const selectedCarbrand = carbrandSelect.value;
						// Получаем текущий URL
						let url = window.location.href;
						// Создаем объект URLSearchParams для работы с параметрами URL
						let searchParams = new URLSearchParams(window.location.search);
						// Устанавливаем новое значение параметра carbrand
						searchParams.set('carbrand', selectedCarbrand);
						// Обновляем параметры в URL
						url = url.split('?')[0] + '?' + searchParams.toString();
						// Перенаправляем на новый URL
						window.location.href = url;
					})

					// Получаем значение параметра carbrand из URL
					const urlParams = new URLSearchParams(window.location.search);
					const carbrandParam = urlParams.get('carbrand');

					// Если параметр carbrand присутствует в URL, устанавливаем его в качестве выбранного значения в поле выбора марки автомобиля
					if (carbrandParam) {
						carbrandSelect.value = carbrandParam;
					}
					;
				</script>
				<h1>
					<?php echo $title; ?>
				</h1>
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
				$filter_cat = $carbrand == 0 ? '' : "AND `$table`.`carbrand`='$carbrand'"; // если категория не выбрана, показать все товары
				$query = "
	SELECT t.*
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
			`$table`.`amount`- IFNULL(ROUND(SUM(`items`.`amount`)),0) AS 'amount',
			`discounts`.`value` AS `discount_value`,
      	TIMESTAMPDIFF(DAY, `$table`.`date_add`, NOW()) AS `delta`
		FROM
			`$table`
		LEFT JOIN
			`items` ON `items`.`product_id`=`products`.`id`
		LEFT JOIN
			`car_model` ON `car_model`.`id`=`$table`.`type_of_light_product`
		LEFT JOIN
			`discounts` ON `discounts`.`id`=`$table`.`discount_id` AND NOW() BETWEEN `discounts`.`start` AND `discounts`.`stop`
		WHERE 1
			$filter_cat
		GROUP BY `$table`.`id`
		ORDER BY `$table`.`name`
		LIMIT 50) AS t
	WHERE amount>0;
	";
				$res = mysqli_query($con, $query) or die(mysqli_error($con));
				// собираем данные в массив
				$a = array();
				while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					$a[] = $row;
				}
				;

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

							// обрезать описание, если оно очень длинное
							if (mb_strlen($row['descr'], 'UTF-8') > 50) {
								$descr = mb_substr($row['descr'], 0, 50, 'UTF-8') . '...';
							} else {
								$descr = $row['descr'];
							}
							;
							echo "
				<td style='width:400px; height:400px'>
					$new
					Наименование: <b><a href='card.php?product_id=$row[id]'>$row[name]</a></b><br>
					Описание: $descr<br>
					Цена: $price_str<br>
					Оценка по отзывам: В разработке<br>
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