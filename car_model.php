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
$title = 'Категории';
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

					// удаление категории
					$query = "
			DELETE FROM `$table`
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
				`name`, `car_brand`
			FROM `$table`
			WHERE id=$id
		";
					$res = mysqli_query($con, $query) or die(mysqli_error($con));
					$row = mysqli_fetch_array($res);
					$name = $row['name'];
					$car_brand = $row['car_brand'];
				}
				;

				// если надо сохранить (если не пусто)
				if (!empty($_POST['name'])) {
					$name = mysqli_real_escape_string($con, trim($_POST['name']));
					$car_brand = intval(trim($_POST['car_brand']));
					$fields = "
				`name`='$name',
				`car_brand`='$car_brand'
		";
					// если надо сохранить отредактированное
					if (!empty($_REQUEST['hidden_edit_id'])) {
						$id = intval($_REQUEST['hidden_edit_id']);
						$query = "
				UPDATE `$table`
				SET
					$fields
				WHERE
					id=$id
			";
					} else { // добавление новой строки
						$query = "
				INSERT INTO `$table`
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
				$admin_delete = $edit ? ", CONCAT('<a href=\"$table.php?delete_id=', `$table`.id, '\" $delete_confirm>', 'удалить&nbsp;#', `$table`.id, '</a>') AS 'Удаление'" : '';
				// добавляем возможность редактирования админам
				$admin_edit = $edit ? ", CONCAT('<a href=\"$table.php?edit_id=', `$table`.id, '\">', 'редактировать&nbsp;#', `$table`.id, '</a>') AS 'Редактирование'" : '';
				$query = "
		SELECT
			`$table`.`id` AS 'Код',
			`$table`.`name` AS 'Модель',
			`brand`.`name` AS 'Марка'
			$admin_delete
			$admin_edit
		FROM
			`$table`
		LEFT JOIN
			`$table_2` AS `brand` ON `brand`.`id`=`$table`.`car_brand`
		WHERE 1
			AND `$table`.`id`<>0
		ORDER BY `$table`.`name`
		LIMIT 50;
	";

				echo SQLResultTable($query, $con, '');
				?>

				<?php
				// доступ к редактированию только админу
				if ($edit) { // if (admin)
					?>
					<form name="form" action="<?php echo $table ?>.php" method="post">
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
								<td>Модель</td>
								<td>
									<textarea id="name" name="name" type="textarea"><?php if (!empty($name))
										echo $name; ?></textarea>
								</td>
							</tr>

							<tr>
								<td>Категория</td>
								<td>
									<select id="car_brand" name="car_brand">
										<?php
										$query = "
									SELECT
										`$table_2`.`id`,
										`$table_2`.`name`
									FROM
										`$table_2`
									LEFT JOIN
										`$table`  ON `$table`.`car_brand`=`$table_2`.`id`
									WHERE 1
										AND `$table_2`.`id`<>0
									ORDER BY `$table_2`.`name`;
						";
										$res = mysqli_query($con, $query) or die(mysqli_error($con));
										while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
											$selected = ($car_brand == $row['id']) ? 'selected' : '';
											echo "
								<option value='$row[id]' $selected>$row[name]</option>
							";
										}
										;

										?>
									</select>
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