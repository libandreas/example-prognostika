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
//an einai diaxirisths alios na kleinei
if ($libpasswd == $getpasswd && $getlevel == "admin" && $libpasswd != null && $libpasswd != null) {
} else {

	header('HTTP/1.1 403 FORBIDDEN');
	exit('Status: 403 You do not have access to this page');
}

//today param
if (!isset($_GET['today'])) {

	trigger_error('today is empty');
	$apot = array(1 => null, 2 => null, 3 => null);
	$today = null;
	$disabled = 'disabled';
} else {

	$today = $_GET['today'];
	$disabled = null;

	//find variableds via table php
	$try_1 = $_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/apot.txt";
	$try_1 = glob($try_1);
	$try_2 = $_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/apot.txt";
	if (count($try_1) > 0) {

		$try_1 = $try_1[0];
		$filename = str_replace("apot.txt", 'tips.txt', $try_1);
		setup_table_variables($filename);
	} elseif (file_exists($try_2)) {

		$try_2 = $_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/apot.txt";
		$filename = str_replace("apot.txt", 'tips.txt', $try_2);
		setup_table_variables($filename);
	} else {

		trigger_error('No file found in');
	}
}

//apothikeysh metabliton
if (isset($_POST['submit']) && isset($_GET['today'])) {

	push_edit_apotelesmata_on_db();

	//redirect
	header("Location: /table/todaytips.php");
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Prognostika Example</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="shortcut icon" href="/pliromes/gears.png" type="image/x-icon">
	<link rel="stylesheet" href="/pliromes/colorblocks-style.css?ver2">
	<link rel="stylesheet" href="/common/responsive.css">
	<link rel="stylesheet" href="/table/styles.css">
	<script src="/js/w3.js"></script>
	<link rel="stylesheet" href="/pliromes/pliromes.css">
	<script src="/common/input-fixes.js"></script>
</head>

<body class="forms-today-tips" style="background-image: url('/pliromes/background.png');background-repeat: repeat-x;margin: 0" id="home">
	<!-- header area -->
	<header class="wrapper clearfix">
		<!-- main navigation -->
		<nav id="topnav" role="navigation">
			<div onclick="w3.show('#menu-main-navigation');w3.show('#close-menu');w3.hide('#open-menu')" id="open-menu" class="menu-toggle">Menu</div>
			<div style="display:none" onclick="w3.hide('#menu-main-navigation');w3.hide('#close-menu');w3.show('#open-menu')" id="close-menu" class="menu-toggle">Close Menu</div>
			<ul class="srt-menu" id="menu-main-navigation">
				<li><a href="/pliromes/todaytips-apot.php?u=<?php echo $_GET['u'] ?>">Επεξεργασία αποτελεσμάτων</a></li>
				<li><a href="/pliromes/apotelesmata.php?u=<?php echo $_GET['u'] ?>">Προσθήκη αποτελεσμάτων</a></li>
				<li><a href="/pliromes/todaytips.php?u=<?php echo $_GET['u'] ?>">Προσθήκη tips</a></li>
				<li><a href="/pliromes/agores.php?u=<?php echo $_GET['u'] ?>">Αγορές</a></li>
				<li><a href="/pliromes/athlimata.php?u=<?php echo $_GET['u'] ?>">Αθλήματα</a></li>
				<li><a href="/pliromes/eteries.php?u=<?php echo $_GET['u'] ?>">Εταιρείες</a></li>
				<li><a href="/pliromes/pliromes.php?u=<?php echo $_GET['u'] ?>">Πληρωμές</a></li>
				<li><a href="/pliromes/protathlimata.php?u=<?php echo $_GET['u'] ?>">Πρωταθλήματα</a></li>
				<li><a href="/pliromes/users.php?u=<?php echo $_GET['u'] ?>">Χρήστες</a></li>
				<li><a href="/pliromes/xores.php?u=<?php echo $_GET['u'] ?>">Χώρες</a></li>
			</ul>
		</nav><!-- #topnav -->
	</header><!-- end header -->

	<!-- hero area the grey one with a slider -->
	<section id="page-header" class="clearfix">
		<div class="wrapper">
			<h1><img class="platform-logo" src="/pliromes/prognostika-example.svg" alt="Prognostika Example" width="360" height="88"></h1>
		</div>
	</section><!-- end hero area -->

	<!-- main content area -->
	<div id="main" class="wrapper clearfix">
		<!-- content area -->
		<section id="content" style="width:100%">
			<br>
			<div style="background: #F0F0F0;border: 1px solid lightslategray;padding:7px;" id="diva" class="form">
				<a target="_parent" href="<?php echo get_this_tipster_url() ?>"><span>[Προβολή προγνωστικών]</span></a>
				<a target="_parent" href="/index.php?logout=1" style="float:right"><span style="color:royalblue">[Exit]</span></a>
				<h2>
					<?php echo get_this_tipster_name() ?> > Επεξεργασία αποτελεσμάτων:
				</h2>
				<hr />
				<form method="post">

					<span>Αποτέλεσμα 1: </span>
					<input required name="apot" type="text" value="<?php echo $apot[1] ?>">

					<section class='sec'></section>
					<span>Αποτέλεσμα 2: </span>
					<input required name="Dapot" type="text" value="<?php echo $apot[2] ?>">

					<section class='sec'></section>
					<span>Αποτέλεσμα 3: </span>
					<input required name="Tapot" type="text" value="<?php echo $apot[3] ?>">

					<section class='sec'></section>

					<center>
						<input <?php echo $disabled ?> name="submit" type="submit" value="Υποβολή">
					</center>
				</form>
			</div>
			<br>
		</section><!-- #end content area -->

	</div><!-- #end div #main .wrapper -->

	<footer style="background: rgba(51, 51, 51, 0.54);color: white;padding:12px;box-sizing: border-box">

		<div id="attribution" class="wrapper clearfix" style="color:white; font-size:11pt;">Σελίδα προγραμματιστή: <a href="https://hdouleiamou.gr/andreas-express/" target="_blank" style="color:white;"><u>Andreas Express</u></a></div>

	</footer><!-- #end footer area -->
</body>

</html>
