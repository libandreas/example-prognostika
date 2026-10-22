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
if ($libpasswd == $getpasswd && $getlevel == 'admin' or $libpasswd == $getpasswd && $libusername == $userme) {
} else {

	header('HTTP/1.1 403 FORBIDDEN');
	exit('Status: 403 You do not have access to this page');
}

//όνομα και επώνυμο
if (isset($_POST['chuserdata'])) {

	if (isset($_POST['name'])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$libusername/info/1/name.txt", $_POST['name']);
	}
}

//λήξη συνδρομής
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$libusername/info/1/exp.txt")) {

	$end = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$libusername/info/1/exp.txt");
	if ($end != null) {

		$hm = date_create($end);
		$hm = date_format($hm, "d F Y");
		$hm = str_replace("January", "Ιανουαρίου", $hm);
		$hm = str_replace("February", "Φεβρουαρίου", $hm);
		$hm = str_replace("March", "Μαρτίου", $hm);
		$hm = str_replace("April", "Απριλίου", $hm);
		$hm = str_replace("May", "Μαΐου", $hm);
		$hm = str_replace("June", "Ιουνίου", $hm);
		$hm = str_replace("July", "Ιουλίου", $hm);
		$hm = str_replace("August", "Αυγούστου", $hm);
		$hm = str_replace("October", "Οκτωβρίου", $hm);
		$hm = str_replace("September", "Σεπτεμβρίου", $hm);
		$hm = str_replace("November", "Νοεμβρίου", $hm);
		$hm = str_replace("December", "Δεκεμβρίου", $hm);
	} else {
		$hm = "-";
	}
} else {
	$hm = "-";
}
?>
<!DOCTYPE html>
<html lang="el">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<script src="/common/functions.js"></script>
	<script src="/common/iframes.js"></script>
	<script src="/js/jquery.min.js"></script>
	<script src="/js/w3.js"></script>
	<link rel="stylesheet" href="/common/responsive.css">
	<link rel="stylesheet" href="/table/styles.css">
</head>

<body>

	<a target="_parent" href="<?php echo get_this_tipster_url() ?>"><span>[Προβολή προγνωστικών]</span></a>
	<a target="_parent" href="/index.php?logout=1" style="float:right"><span style="color:royalblue">[Exit]</span></a>
	<hr>
	<h2 class="head3">Ρυθμίσεις προφίλ<i class="fa fa-caret-down" aria-hidden="true"></i></h2>

	<!--φερμά, όνομα και επώνυμο-->
	<form method="post">
		<h6><b>Όνομα</b><br></h6>
		<p><input autocomplete="off" class="aput" type="text" value="<?php echo get_this_tipster_name(); ?>" name="name"></b></p>
		<h6><b>Email/Username</b><br></h6>
		<p><input class="aput" type="text" disabled value="<?php echo $libusername ?>"></b></b></p>
		<h6><b>Λήξη Συνδρομής</b><br></h6>
		<p><input class="aput" type="text" disabled value="<?php echo $hm ?>"></b></b></p>
		<p>
			<button class="aput" name="chuserdata" type="submit">Change User Data</button>
		</p>
	</form>

	<hr>

	<!--αλλαγή κωδικού-->
	<form method="post">
		<h6><b>Τωρινό Password</b><br></h6>
		<p><input required class="aput" name="passwd" type="password" /></p>
		<h6><b>Nέο Password</b><br></h6>
		<p><input required class="aput" name="newpasswd" type="password" /></p>
		<h6><b>Επαλήθευση Nέου Password</b><br></h6>
		<p><input required class="aput" name="anewpasswd" type="password" /></p>
		<p>
			<button class="aput" name="change-passwd" type="submit">Change Password</button>
		</p>
	</form>

	<hr>

	<!--αποσύνδεση-->
	<form method="post" action="/index.php">
		<p>
			<button class="aput" name="logout" type="submit">Log Out</button>
		</p>
	</form>

	<!--<h2 style="margin-bottom: 19px;margin-top: 19px;" class="head3">Ανανέωση<i class="fa fa-caret-down" aria-hidden="true"></i></h2>-->

	<!--<h5><b>
			<Ανανέωση συνδρομής:</b>
	</h5><br>-->

	<!--<form class="purchase-offer" method="get">
		<input type="hidden" name="account" value="yes">
		<?php //include("sindromes-gui.php"); ?>
		<p>
			<button class="contact-btn submit-btn" <?php //echo $disabled ?> type="submit">Αίτηση Ανανέωσης</button>
		</p>
	</form>-->
</body>

</html>
