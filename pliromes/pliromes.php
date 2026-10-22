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
if ($libpasswd == $getpasswd && str_contains($getlevel, "admin") && $libpasswd != null && $libpasswd != null) {
} else {

	header('HTTP/1.1 403 FORBIDDEN');
	exit('Status: 403 You do not have access to this page');
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta data-menu-title-start content="Πληρωμές" data-menu-title-end>
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
		<section id="content">
			<h2>Έλεγχος συνδρομών:<small style="float:right"><a href="/index.php?logout=1">[Έξοδος - Exit]</a></small></h2>
			<hr>
			<?php
			echo "<small>Πρώτα κάντε αναζήτηση για εναν χρήστη και στη συνέχεια ορίστε ημερομηνία έναρξης και μέρες διαρκείας.</small>";
			echo "<hr>";
			echo "<form method=\"post\">";
			echo "<div style=\"overflow-x:auto\">";
			echo "<table width='100%' border='1' cellpadding='7' cellspacing='9'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th></th>";
			echo "<th align='left'>USER</th>";
			echo "<th align='left'>ΛΗΞΗ</th>";
			echo "<th></th>";
			echo "<th></th>";
			echo "<th></th>";
			echo "</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			echo "<tr>";
			$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");
			foreach ($files as $file) {

				$basename = basename($file);
				//an den einai asxetos fakelos
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/level.txt")) {

					//να μην ειναι χρήστης του συστήματος
					if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/fs")) {

						$name = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
						$push = "<small><b>$name</b></small><br>";
						$push .= "<a style='color:black' href='mailto:$basename'><small><u>$basename</u></small></a>";
						if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/ini.txt")) {

							//convert the end date in seconds
							$im = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/ini.txt");
							$im_in_s = strtotime($im);
						} else {
							$im = null;
							$im_in_s = null;
						}

						//convert the today date in seconds
						$td_in_s = strtotime(date("Y-m-d"));
						//convert output from seconds back to days
						$j = number_format((((($im_in_s - $td_in_s) / 60) / 60) / 24), 0);

						//if user is canceled by admin
						if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/exp.txt") or file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/exp.txt") == null) {

							$color = "red";
							$text_color_bar = "white";
							$title = "Η συνδρομή του χρήστη ακυρωθηκε:";
						}

						//if user is canceled by global
						elseif ($im_in_s < $td_in_s && $im != null) {

							$color = "red";
							$text_color_bar = "white";
							$title = "Η συνδρομή του χρήστη ακυρωθηκε:";
						}

						//if expires in 3 days
						elseif ($j < 4) {

							$color = "yellow";
							$title = "Απομένουν ακόμη $j μέρες";
						}

						if ($im_in_s >= $td_in_s) {

							$b1 = button("1 ΜΗΝΑΣ", "pliromes.php?x=$basename", 'green');
						} else {

							$b1 = button("1 ΜΗΝΑΣ", "pliromes.php?x=$basename&m=1");
						}

						if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/name/cancelmail.txt") && file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/name/cancelmail.txt") == "yes") {

							$stop = button("<small>ΣΤΑΛΘΗΚΕ</small>", "#", 'green');
						} elseif (isset($_GET['push']) && $_GET["push"] == "0") {

							$stop = button("<small>ΑΠΕΤΥΧΕ</small>", "pliromes.php?txt=stop", 'red');
						} else {

							$stop = button("<small>ΜΉΝΥΜΑ ΑΚΥΡΩΣΗΣ</small>", "pliromes.php?txt=stop");
						}

						if ($color == null) {

							$color = "limegreen";
							$title = "Ενεργή συνδρομή";
						}
						$im_display = date("d-m-Y", $im_in_s);
						$im_display = "<small><b>$im_display</b></small>";
						$del = "<a title=\"Διαγραφή χρήστη\" onclick='return confirm(\"Επιβεβαίωση διαγραφής χρήστη\")' style='color:darkred' href='pliromes.php?del=$basename'>[x]</a></small>";
						echo "
						<tr>
						<td title='$title'><span style='display:block;border-radius:100%;height:20px;width:20px;background: $color;border:1px solid darkgray'></span></td>
						<td style='max-width: 211px;word-wrap: break-word;'>$push</td>
						<td nowrap style='max-width: 97px;'>$im_display</td>
						<td style='max-width: 100px;'>$b1</td>
						<td style='max-width: 106px;'>$stop</td>
						<td style='max-width: 32px;'>$del</td>
						</tr>
						";
					}
				}
			}
			echo "</tr>";
			echo "</tbody>";
			echo "</table>";
			echo "</div><br>";
			echo "</form>";
			?>

		</section><!-- #end content area -->

		<aside>
			<nav id="secondary-navigation">
				<h2>Ενεργοί Συνδρομητές:</h2>
				<hr>
				<small>Οι παρακάτω χρήστες έχουν τώρα πρόσβαση:</small>
				<hr>
				<ul>
					<?php
					$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");
					foreach ($files as $file) {
						$basename = basename($file);

						//an den einai asxetos fakelos
						if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/level.txt")) {
						} else {

							if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/exp.txt")) {
								$endim = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/exp.txt");
								$now = strtotime(date("Y-m-d"));
								$end = strtotime($endim);
								if ($end >= $now) {

									echo "<li style=\"list-style: none\"><small><a target=\"_blank\" href=\"mailto:$basename\">ΕMAIL: $basename<br>Πρόσβαση: <b>OK</b></a></small></li>";
								}
							}
						}
					}
					?>
				</ul>
			</nav>
		</aside><!-- #end left sidebar -->

	</div><!-- #end div #main .wrapper -->

	<footer style="background: rgba(51, 51, 51, 0.54);color: white;padding:12px;box-sizing: border-box">

		<div id="attribution" class="wrapper clearfix" style="color:white; font-size:11pt;">Σελίδα προγραμματιστή: <a href="https://hdouleiamou.gr/andreas-express/" target="_blank" style="color:white;"><u>Andreas Express</u></a></div>

	</footer><!-- #end footer area -->

</body>

</html>
