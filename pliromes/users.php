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

//add new user
if (isset($_GET["newuser"])) {

	$newuser = strip_tags($_GET['newuser']);
	$newuser = slugify($newuser);
	$newuser = strtolower($newuser);
	$newuser = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $newuser;
	$nicename = strip_tags($_GET['newuser']);
	$nicename = str_replace("_", " ", $nicename);
	$nicename = str_replace("-", '', $nicename);
	$nicename = ucwords($nicename);
	file_put_contents_force($newuser . "/info/1/name.txt", $nicename);
	file_put_contents_force($newuser . "/info/1/tipster.txt", 'tipster');

	//set up permissions
	//exec ("find $newuser -type d -exec chmod 0777 {} +");//for sub directory
	//exec ("find $newuser -type f -exec chmod 0777 {} +");//for files inside directory
}

//find users
$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");

//user rename
foreach ($files as $file) {

	$basename = basename($file);
	$basenamed = str_replace(".", "_", $basename);
	if (isset($_POST["rename_for_$basenamed"]) && $_POST["rename_for_$basenamed"] != null) {

		//write
		$newname = $_POST["rename_for_$basenamed"];
		if (rename($_SERVER['DOCUMENT_ROOT'] . "/users/$basename", $_SERVER['DOCUMENT_ROOT'] . "/users/$newname")) {
			echo box("Rename Success ../$basename to ../$newname", 'green');
		} else {
			echo box("Rename Fail", 'red');
		}
	}
}

//password change
foreach ($files as $file) {

	$basename = basename($file);
	//before you continue replace "_" with "." because php mess up..
	//ensure that "_" is not allowed on forms so mess up will not be bigger...
	$basenamed = str_replace(".", "_", $basename);
	if (isset($_POST["passwd_for_$basenamed"]) && $_POST["passwd_for_$basenamed"] != null) {

		if (file_put_contents_force($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/passwd.txt", $_POST["passwd_for_$basenamed"])) {
			echo box("Password Changed", 'green');
		} else {
			echo box("Password Fail", 'red');
		}
	}
}

//delete User
if (isset($_GET['delete-user']) && $_GET['delete-user'] != null) {

	if (unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$basename")) {
		echo box("Deleted", 'green');
	} else {
		echo box("Delete Fail", 'red');
	}
}

//link change
foreach ($files as $file) {
	$basename = basename($file);
	$basenamed = str_replace(".", "_", $basename);

	//note: before you continue replace "_" with "." because php mess up..
	//ensure that "_" is not allowed on forms so mess up will not be bigger...
	$basenamed = str_replace(".", "_", $basename);
	if (isset($_POST["link_for_$basenamed"]) && $_POST["link_for_$basenamed"] != null) {

		if (file_put_contents_force($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/url.txt", $_POST["link_for_$basenamed"])) {
			echo box("Link Changed", 'green');
		} else {
			echo box("Link Fail", 'red');
		}
	}
}

//links clear
foreach ($files as $file) {

	$basename = basename($file);
	$basenamed = str_replace(".", "_", $basename);
	if (isset($_POST["clearlink_for_$basenamed"]) && $_POST["clearlink_for_$basenamed"] != null) {
		if (file_put_contents_force($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/url.txt", null)) {
			echo box("Link Cleared", "");
		} else {
			echo box("Link Fail", 'red');
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta data-menu-title-start content="Χρήστες" data-menu-title-end>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Prognostika Example</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="/css/normalize.css">
	<link rel="shortcut icon" href="/pliromes/gears.png" type="image/x-icon">
	<link rel="stylesheet" href="/pliromes/colorblocks-style.css">
	<link rel="stylesheet" href="/common/responsive.css">
	<link rel="stylesheet" href="/table/styles.css">
	<script src="/js/w3.js"></script>
	<link rel="stylesheet" href="/pliromes/pliromes.css">
	<script src="/common/input-fixes.js"></script>
</head>

<body style="background-image: url('/pliromes/background.png');background-repeat: repeat-x;margin: 0" id="home">
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
			<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST' or isset($_GET['newuser'])) {

				//redirect on save
				echo "<h3 style='color:limegreen'><b>Αποθήκευση...</b></h3><hr>";
				echo "<meta http-equiv=\"refresh\" content=\"0.5;URL=" . basename(__FILE__) . "\" />";
				exit();
			}

			//find users
			$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");
			echo '<br>';
			echo "<form action=\"\">";
			echo "<input placeholder=\"ΠΡΟΣΘΗΚΗ ΧΡΗΣΤΗ (USERNAME)\" style=\"padding:5px;max-width:100%;width:400px\" name=\"newuser\">&nbsp;";
			echo "<input style=\"max-width: 100%;padding:6px;box-sizing: border-box;color:royalblue;border: 1px solid royalblue;background:ghostwhite\" value=\"Προσθήκη\" type=\"submit\">";
			echo "<br>";
			echo "<small style=\"color:red\"><i>Συμπληρώστε όνομα χρήστη - username και προσθέστε κανονικό όνομα και τις υπόλοιπες πληροφορίες στη συνέχεια.</i></small>";
			echo "</form>";
			?>
			<h2>Λίστα χρηστών συστήματος: (Tipsters)<small style="float:right"><a href="/index.php?logout=1">[Έξοδος - Exit]</a></small></h2>
			<?php
			echo "<hr>";
			echo "<form method=\"post\">";
			echo "<div style=\"overflow-x:auto\">";
			echo "<table style=\"text-align: left\" width='100%' border='1' cellpadding='7' cellspacing='9'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th></th>";
			echo "<th align='left'>USER</th>";
			echo "<th></th>";
			echo "<th>ΜΕΤΟΝΟΜΑΣΙΑ ΧΡΗΣΤΗ</th>";
			echo "<th>ΑΛΛΑΓΗ PASSWORD</th>";
			echo "<th>PAGE LINK</th>";
			echo "<th></th>";
			echo "</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			echo "<tr>";
			$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");
			foreach ($files as $file) {

				$basename = basename($file);

				//αν δεν ειναι κανένας χρήστης και είναι άσχετος φάκελος
				if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt")) {
					continue;
				}

				$name = file_get_contents_or_null($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/passwd.txt")) {
					$this_passwd = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/passwd.txt");
				} else {
					$this_passwd = null;
				}

				if ($this_passwd == null) {
					$border = "border: 2px solid red";
					$this_passwd = "Type a Password";
				} //να μην έχει else γιατι ειναι υποχρεωτικό
				else {
					$border = null;
				}

				//call user link
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/url.txt")) {
					$this_link = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/url.txt");
				} else {
					$this_link = "/table/todaytips.php?u=$basename";
				}

				$push = null;
				$push .= "<small><b>$name</b></small><br>";
				$push .= "&#8594; <a style='color:black' href=\"$this_link\"><small><u>$basename</u></small></a>";
				$del = "<a title=\"Διαγραφή χρήστη\" onclick='return confirm(\"Επιβεβαίωση διαγραφής χρήστη.. ΘΑ ΔΙΑΓΡΑΦΟΥΝ ΟΛΑ ΤΑ ΔΕΔΟΜΕΝΑ!\")' style=\"color:darkred\" href='?delete-user=$basename&u=$libusername'>[x]</a></small>";

				//patches for global user
				if ($basename == 'global') {
					$disabled = 'disabled';
					$this_passwd = str_repeat("*", strlen($this_passwd));
					$del = null;
				} else {
					$disabled = null;
				}
				echo "
                    <tr>
                    <td><span style='display:block;border-radius:100%;height:20px;width:20px;border:1px solid darkslategray'></span></td>
                    <td style='max-width: 300px;word-wrap: break-word;'>$push</td>
                    <td></td>
                    <td><input $disabled placeholder=\"$basename\" style=\"padding:7px\" name=\"rename_for_$basename\"></td>
                    <td><input $disabled placeholder=\"$this_passwd\" style=\"padding:7px;$border\" name=\"passwd_for_$basename\"></td>
                    <td>Clear:<input type='checkbox' name=\"clearlink_for_$basename\">&nbsp;<input placeholder=\"$this_link\" style=\"padding:7px;\" name=\"link_for_$basename\"></td>
                    <td>$del</td>
                    </tr>
                    ";
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo '<br>';
			echo "<button type='submit'>Αποστολή</button>";
			echo '<br>';
			echo "</div><br>";
			echo "</form>";
			?>
			<h2>Season Catalog:</h2>
			<hr>
			<?php
			if (isset($_POST["season-submit"])) {

				$contents = str_replace("\r\n", "\n", $_POST["seasons"]);
				$contents = str_replace("\r", "\n", $contents);
				$contents = str_replace("\n", "\r\n", $contents);
				file_put_contents_force($_SERVER['DOCUMENT_ROOT'] . '/users/global/info/1/seasons.txt', $contents);
			}
			$seasons = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/users/global/info/1/seasons.txt');
			$seasons = trim($seasons);
			$seasons = str_replace("\r\n", "\n", $seasons);
			$seasons = str_replace("\r", "\n", $seasons);
			$seasons = str_replace("\n", "\r\n", $seasons);
			?>
			<form method="post">
				<div style="overflow-x:auto">
					<center>
						<div style="float:left;text-align:right">
							<i>Format: Ym(start) - Ym(end) <br>From the <b>newest</b> season to the <b>oldest</b> season..<br><br><b>Example:</b></i>
							<pre style="text-align:right">202008 - 202107
								201908 - 202007
								201808 - 201907
							</pre>
							<i><small>The global will auto-select the current season.</small></i>
						</div>
						<textarea required placeholder="YEARSTART - YEAREND" style="margin: 0px; width: 330px; height: 230px;font-family: monospace, serif;" name="seasons">
							<?php echo $seasons ?>
						</textarea>
					</center>
				</div>
				<hr>
				<p><input name="season-submit" value="Αποστολή" type="submit"></p>
			</form>
		</section><!-- #end content area -->

	</div><!-- #end div #main .wrapper -->

	<footer style="background: rgba(51, 51, 51, 0.54);color: white;padding:12px;box-sizing: border-box">

		<div id="attribution" class="wrapper clearfix" style="color:white; font-size:11pt;">Σελίδα προγραμματιστή: <a href="https://hdouleiamou.gr/andreas-express/" target="_blank" style="color:white;"><u>Andreas Express</u></a></div>

	</footer><!-- #end footer area -->
</body>

</html>
