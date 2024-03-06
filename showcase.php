<?php
error_reporting(E_ALL);

// Подключение к базе данных
$con = connect();

$showcase = '';

$query = "
    SELECT
        `name`, `id` AS `carbrand`
    FROM
        `car_brand`
    WHERE 1
        AND `car_brand`.`id` <> 0
";

debug_to_console($query);

echo '<h2><a href="view.php"><img src="images/cats.png" height="18px"> Категории</a></h2>';
echo '';

$res = mysqli_query($con, $query) or die(mysqli_error($con));

while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
    echo "<a class='cats_style' href='view.php?carbrand={$row['carbrand']}'>$row[name]</a><br>";
}

echo '';

echo $showcase;

// Функция для вывода отладочной информации в консоль браузера
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>
