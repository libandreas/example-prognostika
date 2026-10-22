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

//προσθήκη αποτελεσμάτων, αυτό ήταν παλιά στο php-apot-a, και php-apot-b
if (isset($_GET['wdlFX'])) {

	push_apot_tips_on_db();
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
			<div style="background: rgb(204, 255, 204);border: 1px solid lightslategray;padding:7px;" id="diva">
				<a target="_parent" href="<?php echo get_this_tipster_url() ?>"><span>[Προβολή προγνωστικών]</span></a>
				<a target="_parent" href="/index.php?logout=1" style="float:right"><span style="color:royalblue">[Exit]</span></a>
				<h2>
					<?php echo get_this_tipster_name() ?> > Αποτελέσματα:
				</h2>
				<hr />
				<table align="center" border="0" cellpadding="2" cellspacing="1" style="width:100%">
					<tr>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>ΠΡΩΤΑΘΛΗΜΑ</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>Η/Μ</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>ΩΡΑ</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>ΑΓΩΝΑΣ</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>TIPS</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>ΑΠΟΔ</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>STAKE</strong></span></td>
						<td style="background-color:rgb(51, 51, 51);text-align:center"><span style="color:#FFFFFF"><strong>ΑΠΟΤΕΛΕΣΜΑ</strong></span></td>
					</tr>
					<?php
					$files = generate_open_bets_for_apotelesmata();
					foreach ($files as $file) {

						setup_table_variables($file);
						?>
						<form method="get" name="dfs">

							<?php for ($n = 1; $n <= $simeia; $n++) { ?>

								<tr style="background: <?php if ($n > 1) {
									echo "#87878745;";
								} else {
									echo "transparent";
								} ?>">
									<td style="text-align:center;word-break: break-word;">
										<?php echo $protathlima[$n] ?>
									</td>
									<td style="text-align:center;"><strong>
											<?php echo $mera[$n] ?>/
											<?php echo $minas[$n] ?>/
											<?php echo $xronos[$n] ?>
										</strong></td>
									<td style="text-align:center;"><strong>
											<?php echo $ora[$n] ?>:
											<?php echo $lepta[$n] ?>
										</strong></td>
									<td style="text-align:center;word-break: break-word;">
										<?php echo $omada1[$n] ?> -
										<?php echo $omada2[$n] ?>
									</td>
									<td style="text-align:center;"><strong>
											<?php echo $tips[$n] ?>
										</strong></td>
									<td style="text-align:center"><strong>
											<?php echo $odds[$n] ?>
										</strong></td>
									<td style="text-align:center;"><strong>
											<?php if ($n == 1) {
												echo $posoA;
											} ?>
										</strong></td>
									<td style="text-align:center; overflow: hidden;white-space: nowrap;">
										<input style="width:70px" name="<?php if ($n == 1) {
											echo 'apot';
										} elseif ($n == 2) {
											echo 'Dapot';
										} elseif ($n == 3) {
											echo 'Tapot';
										} ?>" required maxlength="7" type="text" value="" />
										<select name="wdl<?php echo $n ?>">
											<option value="W">W (Won)</option>
											<option value="V">V (Void)</option>
											<option value="L">L (Lost)</option>
											<option value="W/2">W/2 (Half Won)</option>
											<option value="L/2">L/2 (Half Lost)</option>
											<option value="X">X (Cancelled)</option>
										</select>
										<!--<strong>Cash Out: <input style="width:60px;background: #c1efff" type="number" name="cashout"></strong>-->
										<input name="today" type="hidden" value="<?php echo $today ?>" />
										<input name="u" type="hidden" value="<?php echo $userme ?>" />
										<input <?php if ($n > 1) {
											echo 'disabled';
										} ?> name='wdlFX' type="submit" value="Save" />
									</td>
								</tr>
							<?php } ?>

							<!--spaces-->
							<tr>
								<td colspan="8" style="background: #0000006b;height:12px;"></td>
							</tr>
						</form>
						<?php
					}
					?>
				</table>
			</div>
			<br>
		</section><!-- #end content area -->

	</div><!-- #end div #main .wrapper -->

	<footer style="background: rgba(51, 51, 51, 0.54);color: white;padding:12px;box-sizing: border-box">

		<div id="attribution" class="wrapper clearfix" style="color:white; font-size:11pt;">Σελίδα προγραμματιστή: <a href="https://hdouleiamou.gr/andreas-express/" target="_blank" style="color:white;"><u>Andreas Express</u></a></div>

	</footer><!-- #end footer area -->
</body>

</html>
