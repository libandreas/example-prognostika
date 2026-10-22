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

//Copyright, Andreas Express
//2012 - 2017
//http://libandreas.github.io/

//turn delete tips on
if (isset($_COOKIE["removetips"]) && $_COOKIE["removetips"] == "OFF" && $_GET["mode"] == "remove") {
	setcookie("removetips", "ON", time() + 604800, "/");
	header('Location: ' . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
} elseif (isset($_COOKIE["removetips"]) && $_COOKIE["removetips"] == null && $_GET["mode"] == "remove") {
	setcookie("removetips", "ON", time() + 604800, "/");
	header('Location: ' . parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
}

//turn delete tips off
elseif (isset($_COOKIE["removetips"]) && $_COOKIE["removetips"] == "ON" && $_GET["mode"] == "remove") {
	setcookie("removetips", "OFF", time() + 604800, "/");
	header('Location: ' . $_SERVER['HTTP_REFERER']);
} elseif (isset($_GET['mode'])) {

	setcookie("removetips", "ON", time() + 604800, "/");
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>
