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

$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");
$c = 0;
foreach ($files as $file) {

	$basename = basename($file);

	//mono tipsters
	$name = file_get_contents_or_null($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
	if ($name != null) {

		$c++;
	}
}

foreach ($files as $file) {

	$basename = basename($file);

	//mono tipsters
	$name = file_get_contents_or_null($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
	if ($name != null) {

		//COUNT OPEN BETS
		$j = 0;
		$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/tips/*/tips.txt");
		foreach ($files as $filename) {
			$t = array();
			$special = str_replace('tips.txt', 'specialset.txt', $filename);
			//na dixnei mono ayta poy den einai long kai live bet
			if (file_exists($special)) {

				$check = file_get_contents($special);
				if ($check != "long") {
					$j++;
				}
			} else {
				$j++;
			}
		}
		$numbers_of_picks[$basename] = $j;
	}
}

//SORT BY NUMBERS OF PICKS
natsort($numbers_of_picks);
$numbers_of_picks = array_reverse($numbers_of_picks, true);
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

<body style="background-color:white">
	<h2 style="position: relative;padding: 10px 10px 10px 10px;margin-bottom: 0;color: white;background:#2767a3;font-weight: bold;font-size: 16px;border-left: 8px solid transparent;text-align: center;margin-top: 0;">Προγνωστικά Στοιχήματος (Open Bets)</h2>
	<div id='custom_frontpage_widget'>
		<?php
		$i = 0;
		foreach ($numbers_of_picks as $basename => $numbers_of_picks) {

			//mono tipsters
			$name = file_get_contents_or_null($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
			if ($name != null) {

				//image
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/image.jpg")) {
					$img = $_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/image.jpg";
				} else {
					$img = null;
				}

				//SEASONLESS OVERALL PROFIT
				$userme = $basename; //important
				$user = $basename; //important
				$prof = count_user_profit();
				$prof = str_replace(',', '', $prof);
				$prof = str_replace("+", '', $prof);
				if ($prof > 0) {
					$prof = "<span style='font-weight:700;color:forestgreen'>(+$prof)</span>";
				} elseif ($prof == 0) {
					$prof = "<span style='font-weight:700;color:black'>($prof)</span>";
				} else {
					$prof = "<span style='font-weight:700;color:red'>($prof)</span>";
				}
				?>
				<a target='_parent' style="cursor:pointer;display:block;padding: 13px;position: relative;overflow: hidden;white-space: nowrap;text-decoration: none;">
					<?php if ($img != null) { ?>
						<img style="display:none;width: 28px;height: 28px;float: left;margin-right: 7px;\" src="<?php echo $img ?>">
					<?php } ?>
					<h6 style="position: relative;font-size: 11pt;font-weight: 700;">
						<?php echo get_this_tipster_name(); ?>&nbsp;<?php echo $prof; ?>
					</h6>
					<div style="background: #d7dde2;display: inline-block;position: absolute;right: 0;top: 0;height: 100%;width: 46px !important;font-size: 12pt;text-align: center;font-weight: 700;color: #1d1e1e;">
						<span style="position: relative;top:14px;">
							<?php echo $numbers_of_picks ?>
						</span>
					</div>
				</a>
				<?php
				$i++;
			}
		}
		?>
	</div>
</body>

</html>
