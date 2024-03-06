<?php
header('Content-Type: application/json; charset=utf-8');

// Подключение к базе данных
include "database.php";
include "func.php";

// Установка соединения с базой данных
$con = connect();
$carbrand = isset($_POST['carbrand']) ? intval($_POST['carbrand']) : null;
$carmodel = isset($_POST['carmodel']) ? intval($_POST['carmodel']) : null;
$country = isset($_POST['country']) ? intval($_POST['country']) : null;
$type_of_light_product = isset($_POST['type_of_light_product']) ? intval($_POST['type_of_light_product']) : null;

// Формирование условий для запроса
$conditions = array();

if (!is_null($carbrand)) {
    $conditions[] = "`carbrand` = $carbrand";
}

if (!is_null($carmodel)) {
    $conditions[] = "`carmodel` = $carmodel";
}

if (!is_null($country)) {
    $conditions[] = "`country` = $country";
}

if (!is_null($type_of_light_product)) {
    $conditions[] = "`type_of_light_product` = $type_of_light_product";
}
// Составление запроса
$query = "SELECT * FROM `products`";

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " ORDER BY `date_add` DESC LIMIT 50";

// Выполнение запроса
$result = mysqli_query($con, $query);

if (!$result) {
    die(json_encode(array('error' => 'Ошибка выполнения запроса: ' . mysqli_error($con))));
}

// Формирование массива товаров
$products = array();
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}

// Отправка данных в формате JSON
echo json_encode($products);

// Закрытие соединения с базой данных
mysqli_close($con);
?>
