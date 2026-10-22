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

//an einai diaxirisths alios na kleinei eite an eimai o xristis poy exei tin selida
if ($libpasswd == $getpasswd && $getlevel == 'admin' or $libpasswd == $getpasswd && $libusername == $userme) {
} else {

	header('HTTP/1.1 403 FORBIDDEN');
	exit('Status: 403 You do not have access to this page');
}

//diagrafi tips mono an einai diaxirisths
if ($libpasswd == $getpasswd && $getlevel == 'admin' && $libpasswd != null && $libpasswd != null && isset($_GET["delete-tip"]) && isset($_GET["dir"])) {

	delete_tips($_GET["dir"]);
	echo "<meta http-equiv=\"refresh\" content=\"0;url=/table/todaytips.php?u=$userme\">";
	exit;
}

//προσθήκη προγνωστικού, αυτό ήταν παλιά στο php-todaytips
//todo: να κάνει Ελενχο αν ειναι login
if (isset($_POST['add-prognostiko'])) {

	push_todaytips_on_db();
}

//get today
if (isset($_GET['today'])) {
	$today_form = $_GET['today'];
} else {
	$today_form = date("YmdHis");
}

//mode diplo triplo
$mode = 1;
$selectmono = null;
$selectdiplo = null;
$selecttriplo = null;
if (isset($_GET["mode"]) && $_GET['mode'] == "2") {
	$selectdiplo = "xronselect";
	$mode = 2;
} elseif (isset($_GET["mode"]) && $_GET['mode'] == "3") {
	$selecttriplo = "xronselect";
	$mode = 3;
} else {
	$selectmono = "xronselect";
	$mode = 1;
}

setup_table_variables($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today_form/tips.txt");
foreach ($GLOBALS as $name => $value) {
	global $$name;
}

//kleidoma tips
if ($kleidomeno == 'on') {
	$checked_kleidomeno = 'checked';
} else {
	$checked_kleidomeno = null;
}

//special tips
if ($special == 'live') {

	$checked_live = 'checked';
	$checked_long = null;
	$checked_null = null;
} elseif ($special == 'long') {

	$checked_live = null;
	$checked_long = 'checked';
	$checked_null = null;
} else {

	$checked_live = null;
	$checked_long = null;
	$checked_null = "checked";
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
	<script src="/js/jquery.min.js"></script>
	<?php if (is_file($_SERVER['DOCUMENT_ROOT'] . '/ckeditor/ckeditor.js')) { ?>
		<script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
	<?php } ?>
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
					<?php echo get_this_tipster_name() ?> > Προσθήκη Tips:
				</h2>
				<hr>
				<?php
				if (empty($_GET['today'])) {

					echo "<a class=\"xron $selectmono\" href=\"todaytips.php?u=$userme\">Μονό</a>&nbsp;";
					echo "<a class=\"xron $selectdiplo\" href=\"todaytips.php?u=$userme&mode=2\">Διπλό</a>&nbsp;";
					echo "<a class=\"xron $selecttriplo\" href=\"todaytips.php?u=$userme&mode=3\">Τριπλό</a>&nbsp;";
					echo "<hr>";
				}
				?>
				<form onkeydown="return event.key != 'Enter';" method="post">
					<?php
					//pollaplo tips
					for ($n = 1; $n <= $mode; $n++) {

						if ($n == 1) {
							$x = null;
						} elseif ($n == 2) {
							$x = "D";
						} elseif ($n == 3) {
							$x = 'T';
						}

						echo "<section class='sec'></section>";
						echo "<p><b>Επιλογή πρότασης $n</b></p>";
						echo "<section class='sec'></section>";
						?>
						<!--previous mono-->
						<span>Άθλημα:</span>
						<select required id="athlima" onchange='$("#<?php echo $x ?>xora").load("/table/xora.php?athlima=" + encodeURIComponent(this.value));$("#<?php echo $x ?>agora").load("/table/agora.php?athlima=" + encodeURIComponent(this.value));' name="<?php echo $x ?>athlima">
							<?php if ($athlima[$n] == null) { ?>
								<option value="">Επιλέξτε:</option>
							<?php } else { ?>
								<option value="<?php echo $athlima[$n] ?>">
									<?php echo $athlima[$n] ?>
								</option>
							<?php } ?>
							<?php
							$files = file($_SERVER['DOCUMENT_ROOT'] . "/users/global/athlimata/1/athlimata.txt");
							foreach ($files as $file) {
								$file = trim($file);
								?>
								<option value="<?php echo $file ?>">
									<?php echo $file ?>
								</option>
								<?php
							}
							?>

						</select>
						<section class='sec'></section>

						<span>Χώρα:</span>
						<select required onchange='$("#<?php echo $x ?>protathlima").load("/table/protathlima.php?athlima=" + encodeURIComponent($("#athlima").val()) + "&xora=" + encodeURIComponent(this.value));' id="<?php echo $x ?>xora" name="<?php echo $x ?>xora">

							<?php if ($xora[$n] == null) { ?>
								<option value="">Επιλέξτε:</option>
							<?php } else { ?>
								<option value="<?php echo $xora[$n] ?>">
									<?php echo $xora[$n] ?>
								</option>
							<?php } ?>
						</select>

						<section class='sec'></section>

						<span>Πρωτάθλημα:</span>
						<select id="<?php echo $x ?>protathlima" name="<?php echo $x ?>protathlima">

							<?php if ($protathlima[$n] == null) { ?>
								<option value="">Επιλέξτε:</option>
							<?php } else { ?>
								<option value="<?php echo $protathlima[$n] ?>">
									<?php echo $protathlima[$n] ?>
								</option>
							<?php } ?>
						</select>

						<!--previous monotips-->
						<section class='sec'></section>

						<span>
							Γηπεδούχος:
						</span>
						<input required name="<?php echo $x ?>omada1" value="<?php echo $omada1[$n]; ?>" size="49" type="text" />

						<section class='sec'></section>

						<span>
							Φιλοξενούμενος:
						</span>
						<input required name="<?php echo $x ?>omada2" value="<?php echo $omada2[$n]; ?>" size="49" type="text" />

						<section class='sec'></section>
						<span>Η/Μ Μέρα / Mήνας / Έτος: </span><select required name="<?php echo $x ?>mera">
							<option value='<?php echo $mera[$n] ?>'>
								<?php echo $mera[$n] ?>
							</option>
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>

						<span> - </span><select required name="<?php echo $x ?>minas">
							<option value='<?php echo $minas[$n] ?>'>
								<?php echo $minas[$n] ?>
							</option>
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
						</select>

						<span> - </span><select required name="<?php echo $x ?>xronos">
							<option value='<?php echo $xronos[$n] - 2 ?>'>
								<?php echo $xronos[$n] - 2 ?>
							</option>
							<option value='<?php echo $xronos[$n] - 1 ?>'>
								<?php echo $xronos[$n] - 1 ?>
							</option>
							<option selected value='<?php echo $xronos[$n] ?>'>
								<?php echo $xronos[$n] ?>
							</option>
							<option value="<?php echo $xronos[$n] + 1 ?>">
								<?php echo $xronos[$n] + 1 ?>
							</option>
							<option value="<?php echo $xronos[$n] + 2 ?>">
								<?php echo $xronos[$n] + 2 ?>
							</option>
						</select>
						<section class='sec'></section>

						<span>Ώρα : Λεπτά:</span><select required name="<?php echo $x ?>ora">
							<option value='<?php echo $ora[$n] ?>'>
								<?php echo $ora[$n] ?>
							</option>
							<option value="00">00</option>
							<option value="01">01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
						</select>

						<span> : </span><select required name="<?php echo $x ?>lepta">
							<option value='<?php echo $lepta[$n] ?>'>
								<?php echo $lepta[$n] ?>
							</option>
							<option value="00">00</option>
							<option value="05">05</option>
							<option value="10">10</option>
							<option value="15">15</option>
							<option value="20">20</option>
							<option value="25">25</option>
							<option value="30">30</option>
							<option value="35">35</option>
							<option value="40">40</option>
							<option value="45">45</option>
							<option value="50">50</option>
							<option value="55">55</option>
						</select>

						<section class='sec'></section>

						<span>Αγορά:</span>
						<select required onchange='$("#<?php echo $x ?>tipslist").load("/table/tips.php?agora=" + encodeURIComponent(this.value));' id="<?php echo $x ?>agora" name="<?php echo $x ?>agora">
							<?php if ($agora[$n] == null) { ?>
								<option value="">Επιλέξτε:</option>
							<?php } else { ?>
								<option value="<?php echo $agora[$n] ?>">
									<?php echo $agora_with_space[$n] ?>
								</option>
							<?php } ?>
						</select>
						<section class='sec'></section>

						<span>Pick: </span>

						<!--αυτό το πεδίο ειναι βοηθητικό και δεν περνάει στη βάση δεδομένων-->
						<select onchange="$('#tips').val(this.value);" id="<?php echo $x ?>tipslist">
							<?php if ($tips[$n] == null) { ?>
								<option value="">Επιλέξτε:</option>
							<?php } else { ?>
								<option value="<?php echo $tips[$n] ?>">
									<?php echo $tips[$n] ?>
								</option>
							<?php } ?>
						</select>

						<input required id="tips" name="<?php echo $x ?>tips" value="<?php echo $tips[$n]; ?>" size="22" type="text" />

						<section class='sec'></section>
						<span>Odds: </span>
						<input required maxlength="3" value="<?php echo $odds[$n]; ?>" name="<?php echo $x ?>odds" style="width:85px" step="0.01" size="1" type="number" min="1" max="99">
						<?php
					}
					?>
					<section class='sec'></section>
					<p><textarea class="ckeditor" style="width:100%;height: 94px;" name="per" placeholder="Περιγραφή:">
							<?php
							if (isset($_GET['today'])) {
								echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today_form/per.txt");
							}
							?>
						</textarea>
					</p>
					<section class='sec'></section>
					<span>Company:</span>
					<select required name="book">
						<?php
						if (empty($booktext)) {
							echo "<option value=\"\">Επιλέξτε</option>";
						} else {
							echo "<option value=\"$book\">$booktext</option>";
						}
						?>
						<?php include $_SERVER['DOCUMENT_ROOT'] . "/table/eteries.php"; ?>
					</select>
					<section class='sec'></section>
					<span>Τελικό ποσό πρότασης: </span>
					<?php if (isset($_GET['today'])) {
						$posoA = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today_form/posoA.txt");
					} else {
						$posoA = null;
					} ?>
					<input required name="posoA" type="number" maxlength="3" step="1" value="<?php echo $posoA ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" title="Numbers only">
					<input type="hidden" name="user" value="<?php echo $userme ?>">
					<section class='sec'></section>
					<p> <i> <input <?php echo $checked_live ?> value="live" type='radio' name="specialset">
							LIVE BET
							<br>
							<input <?php echo $checked_long ?> value="long" type='radio' name="specialset">
							LONG TERM BET
							<br>
							<input <?php echo $checked_null ?> value="" type='radio' name="specialset">
							REGULAR
						</i>
					</p>
					<p>
						<input <?php echo $checked_kleidomeno ?> type='checkbox' name="kleidomeno">
						Κλειδωμένο προγνωστικό.
					</p>

					<section class='sec'></section>

					<center>
						<input name="today" type="hidden" value="<?php echo $today_form ?>">
						<input type="hidden" name="add-prognostiko" value="1">
						<input type="submit" value="Υποβολή">
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
