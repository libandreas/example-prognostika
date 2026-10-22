<?php

if (is_file($_SERVER['DOCUMENT_ROOT'] . "/common/ttfb.php")) {
	include_once $_SERVER['DOCUMENT_ROOT'] . "/common/ttfb.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/functions.php";
$captcha_enabled = is_file(__DIR__ . '/common/simple-php-captcha.php')
	&& is_file(__DIR__ . '/common/simple-php-captcha.png')
	&& is_file(__DIR__ . '/common/simple-php-captcha.ttf')
	&& function_exists('imagecreatefrompng')
	&& function_exists('imagettftext');
if ($captcha_enabled) {
	include_once __DIR__ . '/common/simple-php-captcha.php';
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/content-0.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/content-1.php";
if (is_file($_SERVER['DOCUMENT_ROOT'] . "/common/simple-file-manager.php")) {
	include_once $_SERVER['DOCUMENT_ROOT'] . "/common/simple-file-manager.php";
}
if (is_file($_SERVER['DOCUMENT_ROOT'] . "/common/spa.php")) {
	include_once $_SERVER['DOCUMENT_ROOT'] . "/common/spa.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-calcs-new.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-calcs-new.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-calcs-season.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-calcs.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-gui.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-html.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-tables.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/kernel/kost-kernel.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/common/auto-version.php";

//συμπληρωματικό paei sti selida ean exei sindethei o xristis
if ($libpasswd == $getpasswd && file_exists("users/$libusername") && $libusername != null) {
	header('Location:/users/index.php');
}
?>
<!DOCTYPE html>
<html lang="el">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<script src="/common/functions.js"></script>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/w3.js"></script>
	<link rel="stylesheet" href="/common/responsive.css">
	<link rel="stylesheet" href="/table/styles.css">
</head>

<body>
	<h2 class="head3">Καλωσορίσατε στο διαχειριστή προγνωστικών<i class="fa fa-caret-down" aria-hidden="true"></i></h2>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr>
				<td colspan="3">

					<form autocomplete="on" method="POST" action="" name="loginlogout" id="loginlogout">
						<h6><b>Email / Username</b><br></h6>
						<p><input required class="aput" name="username" id="username" type="text" /></p>
						<p>
						<h6><b>Password</b><br></h6>
						<p><input required class="aput" name="passwd" id="passwd" type="passwd" /></p>
						<?php if ($captcha_enabled) { ?>
							<div class="simple-php-captcha"></div>
						<?php } ?>
						<p>
							<input type="hidden" name="login" value="1">
							<button value="Login" class="aput" type="submit">Σύνδεση</button>
						</p>
					</form>

				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
