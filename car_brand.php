<?php
header('Content-type: text/html; charset=utf-8');
include "auth.php";
error_reporting(E_ALL);
if (!in_array($_SESSION['level'], array(10, 2))) { // доступ разрешен только группе пользователей
    header("Location: login.php"); // остальных просим залогиниться
    exit;
}
;
$edit = in_array($_SESSION['level'], array(10, 2)) ? true : false;

/*
   Скрипт-редактор
   */
include "database.php";
include "func.php";
include "scripts.php";
$con = connect();
$title = 'Марки автомобилей';
$table = 'car_model';
$table_2 = 'car_brand';
?>
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
            <td width="40%" class="menu2">
                <?php
                include('menu.php');
                ?>
            </td>

            <!-- контент -->
            <td class="content">

                <h1>
                    <?php echo $title; ?>
                </h1>
                <?php
                // если надо удалить
                if (!empty($_GET['delete_id'])) {
                    $id = intval($_GET['delete_id']);

                    // каскадное удаление из содержимого заказов
                    $query = "
			DELETE FROM `items`
			WHERE
				product_id IN (
					SELECT id
					FROM products
					WHERE cat_id=$id
				)
		";
                    mysqli_query($con, $query) or die(mysqli_error($con));

                    // каскадное удаление из каталога товаров
                    $query = "
			DELETE FROM `products`
			WHERE cat_id=$id
		";
                    mysqli_query($con, $query) or die(mysqli_error($con));

                    // удаление модели
                    $query = "
			DELETE FROM `$table`
			WHERE id=$id
		";
                    mysqli_query($con, $query) or die(mysqli_error($con));

                    // удаление марки
                    $query = "
			DELETE FROM `$table_2`
			WHERE id=$id
		";
                    mysqli_query($con, $query) or die(mysqli_error($con));

                }
                ;

                // если надо редактировать, загружаем данные
                if (!empty($_GET['edit_id'])) {
                    $id = intval($_GET['edit_id']);
                    $query = "
			SELECT
				`name`, `id`
			FROM `$table_2`
			WHERE id=$id
		";
                    $res = mysqli_query($con, $query) or die(mysqli_error($con));
                    $row = mysqli_fetch_array($res);
                    $name = $row['name'];
                    $car_brand = $row['id'];
                }
                ;

                // если надо сохранить (если не пусто)
                if (!empty($_POST['name'])) {
                    $name = mysqli_real_escape_string($con, trim($_POST['name']));
                    $car_brand = intval(trim($_POST['id']));
                    $fields = "
				`name`='$name',
				`id`='$car_brand'
		";
                    // если надо сохранить отредактированное
                    if (!empty($_REQUEST['hidden_edit_id'])) {
                        $id = intval($_REQUEST['hidden_edit_id']);
                        $query = "
				UPDATE `$table_2`
				SET
					$fields
				WHERE
					id=$id
			";
                    } else { // добавление новой строки
                        $query = "
				INSERT INTO `$table_2`
				SET
					$fields
			";
                    }
                    ;

                    mysqli_query($con, $query) or die(mysqli_error($con));
                }
                ;

                if (isset($_POST['btn_submit'])) // была нажата кнопка сохранить - не надо больше отображать id
                    $id = 0;

                // добавляем возможность удаления админам
                $delete_confirm = "onClick=\"return window.confirm(\'Подтверждаете удаление?\');\"";
                $admin_delete = $edit ? ", CONCAT('<a href=\"$table_2.php?delete_id=', `$table_2`.id, '\" $delete_confirm>', 'удалить&nbsp;#', `$table_2`.id, '</a>') AS 'Удаление'" : '';
                // добавляем возможность редактирования админам
                $admin_edit = $edit ? ", CONCAT('<a href=\"$table_2.php?edit_id=', `$table_2`.id, '\">', 'редактировать&nbsp;#', `$table_2`.id, '</a>') AS 'Редактирование'" : '';
                $query = "
		SELECT
			`$table_2`.`id` AS 'Код',
			`$table_2`.`name` AS 'Марка'
			$admin_delete
			$admin_edit
		FROM
			`$table_2`;
	";

                echo SQLResultTable($query, $con, '');
                ?>

                <?php
                // доступ к редактированию только админу
                if ($edit) { // if (admin)
                    ?>
                    <form name="form" action="<?php echo $table_2 ?>.php" method="post">
                        <table>
                            <tr>
                                <th colspan="2">
                                    <p>Редактор
                                        <?php if (!empty($id))
                                            echo "(редактируется строка с кодом $id)"; ?>
                                    </p>
                                </th>
                            </tr>

                            <tr>
                                <td>Марка</td>
                                <td>
                                    <textarea id="name" name="name" type="textarea"><?php if (!empty($name))
                                        echo $name; ?></textarea>
                                </td>
                            </tr>

                            <input name="hidden_edit_id" type="hidden" value="<?php if (!empty($id))
                                echo $id; ?>">

                            <tr>
                                <td colspan='2'>
                                    <button id="btn_reset" onclick="btn_reset_click();">Очистить поля</button>
                                    <button id="btn_submit" name="btn_submit" type="submit">Сохранить</button>
                                </td>
                            </tr>
                        </table>

                    </form>
                    <?php
                }
                ; // if (admin)
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