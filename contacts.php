<?php
	/*
	Главная страница
	*/
	header('Content-type: text/html; charset=utf-8');
	error_reporting(E_ALL);
	include('auth.php');
	include('func.php');
	$title='Главная';
?>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<table id="main_table" border="0">
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
		<td width="270px" class="menu" style="vertical-align:top;">
			<?php
				include('menu.php');
				include('showcase.php');
			?>
		</td>

		<!-- контент -->
		<td width="900px"   style="vertical-align:top;">

			<h1>Контакты</h1>

						<p>Адрес: Россия, 220000, г. Москва, ул. Ростовская, д.16а, офис 198.
						</p>

						<p>
						Страница в социальной сети: <a href="https://t.me/autoops">https://t.me/autoopt</a>
						</p>


            </div>

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