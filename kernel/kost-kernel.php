<?php
/**
 * Created by PhpStorm
 * User: Andreas Express
 * Date: 9/10/17
 * Time: 5:29 PM
 */

function send_review($libusername, $code1, $code2, $code3, $code4, $mode)
{
	$title = "Αίτηση συνδρομής για το πρόγραμμα προγνωστικών";
	$name = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$libusername/info/1/name.txt");
	$today = date("d-m-Y");
	if ($mode == 1) {
		$x = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/kostos-1.txt");
	} elseif ($mode == 3) {
		$x = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/kostos-3.txt");
	} elseif ($mode == 6) {
		$x = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/kostos-6.txt");
	}
	$E = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/email/email.txt");
	$O = $title . PHP_EOL;
	$O .= PHP_EOL;
	$O .= "Η/Μ: $today" . PHP_EOL;
	$O .= PHP_EOL;
	$O .= "==Δηλωθέντα στοιχεία==" . PHP_EOL;
	$O .= PHP_EOL;
	$O .= "Όνομα: $name" . PHP_EOL;
	$O .= "EMAIL: $libusername" . PHP_EOL;
	$O .= "Κάρτα πληρωμής 1: $code1" . PHP_EOL;
	$O .= "Κάρτα πληρωμής 2: $code2" . PHP_EOL;
	$O .= "Κάρτα πληρωμής 3: $code3" . PHP_EOL;
	$O .= "Κάρτα πληρωμής 4: $code4" . PHP_EOL;
	$O .= "Διάρκεια συνδρομής: $mode μήνες" . PHP_EOL;
	$O .= "Χρήματα: $x Ευρώ";
	$headers = "From: $E\r\n";
	$headers .= "Reply-To: $libusername\r\n";
	$headers .= "Return-Path: $E\r\n";
	mail("$E", "$title", $O, $headers);
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/eviews/$libusername.txt", $O);
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$libusername/info/1/exp.txt", null);
}

function delete_user_tips($dir)
{

	//more security
	if (strpos($dir, "records") !== false or strpos($dir, "tips") !== false) {
		if (strpos($dir, "users") !== false) {

			delete_directory($dir);
		}
	}
}

//login variables from cookies
global $libusername;
if (isset($_COOKIE["username"])) {

	$libusername = urldecode($_COOKIE["username"]);
} else {

	$libusername = null;
}

global $libpasswd;
if (isset($_COOKIE["passwd"])) {

	$libpasswd = urldecode($_COOKIE["passwd"]);
} else {

	$libpasswd = null;
}

//login variables from forms
global $formusername;
if (isset($_POST["username"])) {

	$formusername = $_POST["username"];
} else {

	$formusername = null;
}

global $formpasswd;
if (isset($_POST["passwd"])) {

	$formpasswd = $_POST["passwd"];
} else {

	$formpasswd = null;
}

//get passwd
global $getpasswd;
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/passwd.txt")) {

	$getpasswd = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/passwd.txt");
} elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername/info/1/passwd.txt")) {

	$getpasswd = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername/info/1/passwd.txt");
} else {

	$getpasswd = rand(1111, 9999); //this is here for security
}

//get level
global $getlevel;
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/level.txt")) {

	$getlevel = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/level.txt");
} elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername/info/1/level.txt")) {

	$getlevel = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername/info/1/level.txt");
} else {

	$getlevel = "user";
}

//ψάχνει τον τρέχοντα χρήστη του φακέλου
global $userme;
if (isset($_GET['u'])) {
	$userme = $_GET['u']; //important change
} else {
	$_GET['u'] = 'global';
	$userme = 'global';
}

//timezone
global $timezone;
$timezone = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/global/info/1/timezone.txt");
date_default_timezone_set($timezone);

//lock url
global $lock_url;
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/global/info/1/lock-url.txt")) {
	$lock_url = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/global/info/1/lock-url.txt");
} else {
	$lock_url = "#";
}

//cookies and login-logout
if (isset($_POST["login"])) {

	setcookie("username", $formusername, time() + 1204800, "/");
	setcookie("passwd", $formpasswd, time() + 1204800, "/");
	if (!file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername")) {

		trigger_error('Ο χρήστης με αυτό το email δεν βρέθηκε');

	} elseif ($_POST["passwd"] != file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername/info/1/passwd.txt")) {

		trigger_error('Ο κωδικός δεν είναι σωστός');

	} elseif (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$formusername") && $formpasswd == $getpasswd && $formusername != null) {

		header("location: " . site_url_des() . "/users/index.php");
		exit;
	}
}

//deprecated - μόνο αν δεν υπάρχει το ums
if (isset($_POST["logout"]) or isset($_GET["logout"])) {

	setcookie("username", null, time() + 1204800, "/");
	setcookie("passwd", null, time() + 1204800, "/");
	header("location: " . site_url_des() . "/index.php");
	exit;
}

//change passwords
if (isset($_POST["change-passwd"])) {

	if ($_POST["passwd"] == file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/passwd.txt") && $_POST["passwd"] != null) {

		if ($_POST["anewpasswd"] == $_POST["newpasswd"] && $_POST["anewpasswd"] != null) {

			file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/passwd.txt", $_POST["newpasswd"]);
			setcookie("libusername", $libusername, time() + 1204800, "/");
			setcookie("libpasswd", $_POST["newpasswd"], time() + 1204800, "/");
			trigger_error("Ο κωδικός άλλαξε έχετε συνθεθεί με νέο password πλέων");

		} else {

			trigger_error("Οι νέοι κωδικοί δεν ταιριάζουν");
		}
	} else {

		trigger_error("Ο τρέχων κωδικός δεν είναι σωστός");
	}
}

//γενικές μεταβλητές που αφορούν το σύστημα συνδρομών
//περιλαμβάνουν και τις 2 εκδοχές συνδρομής 1) ισχίου για μη-μέλη 2) κλείδωμα προγνωστικών
global $sindromi_start;
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/ini.txt")) {

	$sindromi_start = strtotime(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/ini.txt"));
} else {
	$sindromi_start = null;
}

global $sindromi_end;
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/exp.txt")) {

	$sindromi_end = strtotime(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/users/$libusername/info/1/exp.txt"));
} else {
	$sindromi_end = null;
}

global $sindromi_now;
$sindromi_now = strtotime(date("Y-m-d"));

//φίλτρα για να δούμε ποιος μπορεί να βλέπει τα κλειδωμένα TIPS - $pass_lock
global $pass_lock;
if ($getlevel == 'admin' && $libpasswd == $getpasswd && $libusername != null) {

	$pass_lock = true;
}

//αν ειναι χρήστης προγνωστικών μονο για το account:
elseif ($libusername == $userme && $libpasswd == $getpasswd && $libusername != null) {

	$pass_lock = true;
}

//αν ειμαι απλός χρήστης:
elseif ($libpasswd == $getpasswd && $libusername != null) {

	//εαν δεν έχει λήξη η συνδρομή του:
	if (isset($sindromi_end) && $sindromi_end >= $sindromi_now) {

		$pass_lock = true;
	} else {

		$pass_lock = false;
	}
}

//εαν δεν έχει συνδεθεί
else {

	$pass_lock = false;
}

//seasons
global $season_start;
global $season_end;
$getseasons = file($_SERVER["DOCUMENT_ROOT"] . "/users/global/info/1/seasons.txt");
$currentseason_sys = date("Y") . date("m");
$currentseason_file = explode(" - ", $getseasons[0]);
$currentseason_file[0] = intval($currentseason_file[0]);
$currentseason_file[1] = intval($currentseason_file[1]);
if (isset($_GET["s"])) {

	$s = array();
	$s = explode(" - ", $_GET["s"]);
	$season_start = $s[0];
	$season_end = $s[1];
}

//εδώ ελέγχει αν η εποχή έχει λήξη
elseif ($currentseason_file[0] <= $currentseason_sys && $currentseason_file[1] >= $currentseason_sys) {

	$season_start = $currentseason_file[0];
	$season_end = $currentseason_file[1];

} else {

	trigger_error("No current season found, please update the season catalog with the correct seasons");
}

//export javascript version
echo "<script>var season_start = $season_start;</script>";
echo "<script>var season_end = $season_start;</script>";

//show current season for gui
$s_y[0] = substr($season_start, 0, 4); //show starting year of season
$s_y[1] = substr($season_end, 0, 4); //show ending year of season
$s_m[0] = substr($season_start, -2); //show starting month of season
$s_m[1] = substr($season_end, -2); //show ending month of season

global $current_season_for_gui;
$current_season_for_gui = $s_m[0] . "/" . $s_y[0] . ' - ' . $s_m[1] . "/" . $s_y[1];