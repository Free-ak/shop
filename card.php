<?php
	header('Content-type: text/html; charset=utf-8');
	include "auth.php";
	error_reporting(E_ALL);

	/*
	Скрипт карточки товара
	*/
	include "database.php";
	include "func.php";
	include "scripts.php";
	$con=connect();
	$table='products';
?>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
<script>
	function btn_reset_click() {
		$('input').val('');
	};
</script>

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
			beforeSend: function() {
			},
			complete: function() {
			},
			success: function(response)	{
				$('#cart_info').html('Корзина ('+response.amount+')');
			},
			error: function(objAJAXRequest, strError) {
				alert('Произошла ошибка! Тип ошибки: ' +strError);
			}
		});
	};

	// сразу после загрузки страницы выполнить
	$(function() {
		get_cart_info();
	});

	// добавлям товар в корзину пользователю
	function to_cart(id) {
		var user_id='<?php echo $_SESSION["id"];?>';
		$.ajax({
			url: 'ajax/ajax_add_to_cart.php',
			type: 'POST',
			async: true,
			data: {
				id: id,
				user_id: user_id
			},
			beforeSend: function() {
			},
			complete: function() {
			},
			success: function(response)	{
				if (response=='ok') {
					get_cart_info();
					alert('Добавлено в корзину!');
				}
				else alert(response);
			},
			error: function(objAJAXRequest, strError) {
				alert('Произошла ошибка! Тип ошибки: ' +strError);
			}
		});

	};

</script>

<style>
	input{
		width:100%;
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
		<td width="280px" class="menu2">
			<?php
				include('menu.php');
			?>
		</td>

		<!-- контент -->
		<td width="900px" class="content">

<?php
	$product_id=empty($_GET['product_id']) ? 0 : abs(intval($_GET['product_id']));
	$product_id = empty($_GET['product_id']) ? 0 : abs(intval($_GET['product_id']));

$query="
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
		WHERE 
			`$table`.`id` = $product_id
			AND `$table`.`type_of_light_product` IN (
				SELECT `id` FROM `type_of_light_product` WHERE `descr` LIKE '%$type_of_light_product%'
			)
		GROUP BY `$table`.`id`
		ORDER BY `$table`.`name`
		LIMIT 50
	) AS t
	LEFT JOIN
		`reviews` AS r ON r.product_id = t.id
";
	$res=mysqli_query($con, $query) or die(mysqli_error($con));

	$row=mysqli_fetch_array($res, MYSQLI_ASSOC);

	$fname='upload/'.$row['id'].'.jpg';
	if (!file_exists($fname)) { // если нет файла, показать "НЕТ ФОТО"
		$fname='upload/0.jpg';
	};

	if ($row['delta']<30) { // товар добавлен меньше 30 дней назад, т.е. это новинка
		$new="<div><img src='images/new.png' style='width:100px'></div>";
	}
	else {
		$new='';
	};

	if ($row['discount_value']) { // цена со скидкой
		$price_new=number_format (round($row['price']*(1-$row['discount_value']/100), 2), 2, '.', '');
		$price_str="
			<font style='color: #888; font-size:x-small; text-decoration:line-through'>$row[price]$valuta</font>
			<img src='images/discount.png' height='24px' title='Скидка'>
			<font style='color: #000;'>$price_new$valuta</font>
		";
		$price_str=trim($price_str);
	}
	else {
		$price_str="<font style='color: #000;'>$row[price]$valuta</font>";
	};
	$avg_estimation = isset($row['avg_estimation']) ? round($row['avg_estimation'], 2) : "Пока нет отзывов для этого товара.";
	
// Теперь, когда у нас есть значение type_of_light_product, мы можем выбрать соответствующие характеристики
$query = "SELECT * FROM type_of_light_product WHERE id =".$row['type_of_light_product'];
$result = mysqli_query($con, $query);
$row2 = mysqli_fetch_assoc($result);

// Выводим характеристики
echo "Характеристики:<br>";

// Поворотник
if ($row2['Поворотник'] !== null) {
    $query = "SELECT category.id as cat_id,
    category.descr as cat_descr,
    type_of_light_source.id as source_id,
    type_of_light_source.descr as source_descr,
    type_of_light_source.power,
    type_of_light_source.lumen,
    type_of_light_source.voltage,
    type_of_light_source.glow_temperature,
    type_of_light_reflector.id as reflector_id,
    type_of_light_reflector.descr as reflector_descr
FROM `category`
LEFT JOIN `type_of_light_source` ON `category`.`type_of_light_source` = `type_of_light_source`.`id`
LEFT JOIN `type_of_light_reflector` ON `category`.`type_of_light_reflector` = `type_of_light_reflector`.`id`
WHERE `category`.`id` =" . $row2['Поворотник'];
    $result = mysqli_query($con, $query);
    $row3 = mysqli_fetch_assoc($result);
    echo "Поворотник:". $row3['cat_descr'] . ", " . $row3['source_descr'] . ", мощность: " . $row3['power'] . "вт <br>";
}


// Ближний свет
if ($row2['Ближний свет'] !== null) {

	$query = "SELECT category.id as cat_id,
    category.descr as cat_descr,
    type_of_light_source.id as source_id,
    type_of_light_source.descr as source_descr,
    type_of_light_source.power,
    type_of_light_source.lumen,
    type_of_light_source.voltage,
    type_of_light_source.glow_temperature,
    type_of_light_reflector.id as reflector_id,
    type_of_light_reflector.descr as reflector_descr
FROM `category`
LEFT JOIN `type_of_light_source` ON `category`.`type_of_light_source` = `type_of_light_source`.`id`
LEFT JOIN `type_of_light_reflector` ON `category`.`type_of_light_reflector` = `type_of_light_reflector`.`id`
WHERE `category`.`id` =" . $row2['Ближний свет'];
    $result = mysqli_query($con, $query);
    $row3 = mysqli_fetch_assoc($result);
    echo "Ближний свет:".$row3['cat_descr'] . ", " . $row3['source_descr'] . ", мощность: " . $row3['power'] . "вт, температура  свечения: " . $row3['glow_temperature'] . "K<br>";
}

// Дальний свет
if ($row2['Дальний свет'] !== null) {
   
	$query = "SELECT category.id as cat_id,
    category.descr as cat_descr,
    type_of_light_source.id as source_id,
    type_of_light_source.descr as source_descr,
    type_of_light_source.power,
    type_of_light_source.lumen,
    type_of_light_source.voltage,
    type_of_light_source.glow_temperature,
    type_of_light_reflector.id as reflector_id,
    type_of_light_reflector.descr as reflector_descr
FROM `category`
LEFT JOIN `type_of_light_source` ON `category`.`type_of_light_source` = `type_of_light_source`.`id`
LEFT JOIN `type_of_light_reflector` ON `category`.`type_of_light_reflector` = `type_of_light_reflector`.`id`
WHERE `category`.`id` =" . $row2['Дальний свет'];
    $result = mysqli_query($con, $query);
    $row3 = mysqli_fetch_assoc($result);
    echo "Дальний свет:". $row3['cat_descr'] . ", " . $row3['source_descr'] . ", мощность: " . $row3['power'] . "вт, температура  свечения: " . $row3['glow_temperature'] . "K<br>";
}
// Габаритные огни
if ($row2['Габаритные огни'] !== null) {
	$query = "SELECT category.id as cat_id,
    category.descr as cat_descr,
    type_of_light_source.id as source_id,
    type_of_light_source.descr as source_descr,
    type_of_light_source.power,
    type_of_light_source.lumen,
    type_of_light_source.voltage,
    type_of_light_source.glow_temperature,
    type_of_light_reflector.id as reflector_id,
    type_of_light_reflector.descr as reflector_descr
FROM `category`
LEFT JOIN `type_of_light_source` ON `category`.`type_of_light_source` = `type_of_light_source`.`id`
LEFT JOIN `type_of_light_reflector` ON `category`.`type_of_light_reflector` = `type_of_light_reflector`.`id`
WHERE `category`.`id` =" . $row2['Габаритные огни'];
    $result = mysqli_query($con, $query);
    $row3 = mysqli_fetch_assoc($result);
    echo "Габаритные огни:".$row3['cat_descr'] . ", " . $row3['source_descr'] . ", мощность: " . $row3['power'] . "вт, температура  свечения: " . $row3['glow_temperature'] . "K<br>";

}
// ДХО
if ($row2['Дневные ходовые огни'] !== null) {
	$query = "SELECT category.id as cat_id,
    category.descr as cat_descr,
    type_of_light_source.id as source_id,
    type_of_light_source.descr as source_descr,
    type_of_light_source.power,
    type_of_light_source.lumen,
    type_of_light_source.voltage,
    type_of_light_source.glow_temperature,
    type_of_light_reflector.id as reflector_id,
    type_of_light_reflector.descr as reflector_descr
FROM `category`
LEFT JOIN `type_of_light_source` ON `category`.`type_of_light_source` = `type_of_light_source`.`id`
LEFT JOIN `type_of_light_reflector` ON `category`.`type_of_light_reflector` = `type_of_light_reflector`.`id`
WHERE `category`.`id` =" . $row2['Дневные ходовые огни'];
    $result = mysqli_query($con, $query);
    $row3 = mysqli_fetch_assoc($result);
    echo "Дневные ходовые огни:".$row3['cat_descr'] . ", " . $row3['source_descr'] . ", мощность: " . $row3['power'] . "вт, температура  свечения: " . $row3['glow_temperature'] . "K<br>";
}
// Задний ход
if ($row2['Задний ход'] !== null) {
	$query = "SELECT category.id as cat_id,
    category.descr as cat_descr,
    type_of_light_source.id as source_id,
    type_of_light_source.descr as source_descr,
    type_of_light_source.power,
    type_of_light_source.lumen,
    type_of_light_source.voltage,
    type_of_light_source.glow_temperature,
    type_of_light_reflector.id as reflector_id,
    type_of_light_reflector.descr as reflector_descr
FROM `category`
LEFT JOIN `type_of_light_source` ON `category`.`type_of_light_source` = `type_of_light_source`.`id`
LEFT JOIN `type_of_light_reflector` ON `category`.`type_of_light_reflector` = `type_of_light_reflector`.`id`
WHERE `category`.`id` =" . $row2['Задний ход'];
    $result = mysqli_query($con, $query);
    $row3 = mysqli_fetch_assoc($result);
    echo "Задний ход:".$row3['cat_descr'] . ", " . $row3['source_descr'] . ", мощность: " . $row3['power'] . "вт, температура  свечения: " . $row3['glow_temperature'] . "K<br>";

}

	// Противотуманная фара
if ($row2['Противотуманная фара'] !== null) {
    echo "Противотуманная фара: " . $row2['Противотуманная фара'] . "<br>";
}
// Противотуманная фонарь
if ($row2['Противотуманный фонарь'] !== null) {
echo "Противотуманный фонарь: " . $row2['Противотуманный фонарь'] . "<br>";
}
// Корректор угла наклона фар
if ($row2['Корректор угла наклона фар'] !== null) {
	echo "Корректор угла наклона фар: " . $row2['Корректор угла наклона фар'] . "<br>";
	}
	echo "
		<h1>$row[name]</h1>
		$new
		<img src=\"$fname\" width=\"500px\" height=\"500px\" style='cursor:pointer;' onclick='to_cart($row[id]);'><br>
		Оценка по отзывам: $avg_estimation<br>
		Описание:$row[descr]<p>
		Характеристики:
		<p>Цена: $price_str</p>
		Осталось: $row[amount] шт.<br>
		<button onclick='to_cart($row[id]);'>В корзину</button>
	";
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