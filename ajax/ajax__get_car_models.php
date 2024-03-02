<?php
include "../database.php";
include "../func.php";
error_reporting(E_ALL);
// подключаемся к БД
$con = connect();

// Получаем ID выбранной марки автомобиля из параметров запроса
$carbrandId = isset($_GET['carbrand']) ? intval($_GET['carbrand']) : 0;

// Формируем запрос к базе данных для получения списка моделей автомобилей для выбранной марки
$query = "SELECT id, name FROM car_model WHERE car_brand = $carbrandId";
$result = mysqli_query($con, $query);

// Формируем HTML-код для списка моделей автомобилей
$selectOptions = '<option value="">Выберите модель автомобиля</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $selectOptions .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
}

// Отправляем HTML-код списка моделей автомобилей обратно на клиент
echo $selectOptions;
?>