<?php
if (is_file($_SERVER['DOCUMENT_ROOT'] . "/common/ttfb.php")) {
	include_once $_SERVER['DOCUMENT_ROOT'] . "/common/ttfb.php";
}
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/url-rewrites.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/url-redirects.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/common/functions.php";
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
?>
<!DOCTYPE html>
<html lang="el">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<script src="/common/iframes.js"></script>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/w3.js"></script>
	<link rel="stylesheet" href="/common/responsive.css">
	<link rel="stylesheet" href="/table/styles.css">
</head>

<body>

	<h2 class="head3">Καλωσορίσατε στο διαχειριστή προγνωστικών <i class="fa fa-caret-down" aria-hidden="true"></i></h2>

	<?php
	if (isset($libusername)) {

		echo "<a href=\"/table/account.php?u=$libusername\">[Ρυθμίσεις προφίλ]</a>&nbsp;";
	} else {
		echo "<a href=\"/index.php\">[Σύνδεση]</a>&nbsp;";
	}
	if (isset($getlevel) && str_contains($getlevel, "admin")) {

		echo "<a href='/pliromes/index.php'>[Κέντρο ελέγχου]</a>";
	}
	?>
	<?php if ($libpasswd == $getpasswd && file_exists($libusername) && str_contains($getlevel, "admin") or $libpasswd == $getpasswd && file_exists($libusername) && $libusername == $userme) { ?>
		<a target="_parent" href="/index.php?logout=1" style="float:right"><span style="color:royalblue">[Exit]</span></a>
	<?php } ?>
	<br><br>
	<?php
	//make users buttons
	$files = glob("*");
	foreach ($files as $file) {

		if (basename($file) == 'global')
			continue;

		$basename = basename($file);
		$name = file_get_contents_or_null("$basename/info/1/name.txt");
		if ($name != null) {

			//call user name
			if (file_exists("$basename/info/1/name.txt")) {

				$name = file_get_contents("$basename/info/1/name.txt");
			} else {

				$name = ucfirst($basename);
			}

			//call user link
			if (file_exists("$basename/info/1/url.txt")) {

				$url = file_get_contents("$basename/info/1/url.txt");
				if ($url != null) {

					$url = "/table/todaytips.php?u=$basename";
				}
			} else {

				$url = "/table/todaytips.php?u=$basename";
			}

			$t_buttons = "<div style='position: relative'><a style=\"color:white;text-decoration: none\" href=\"$url\"><h4 style=\"border-color:limegreen;margin-bottom: 7px\" class=\"head2\">$name</h4></a></div>";
			echo $t_buttons;
		}
	}
	?>
</body>

</html>
