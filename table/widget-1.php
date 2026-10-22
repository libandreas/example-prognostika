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

// start
$monlink = $season_start;
$prognostika = array();
$monlinks = array();
$dates = array();
$datesnew = array();
while ($monlink <= $season_end) {
	if (call_user_records(false, $monlink, false) > 0) {
		array_push($monlinks, $monlink);
	}
	$monlink = monlink_step($monlink);
}
rsort($monlinks);
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
	<div id="diva">
		<h2 class="head3" style="margin-bottom: 0;font-size:17pt;text-align: center">
			<?php
			$text[0] = substr($season_start, 0, 4);
			$text[1] = substr($season_end, 0, 4);
			?>
			Stats <?php echo $text[0] . '-' . $text[1] ?>
		</h2>
		<div style="overflow-x: auto">
			<table class="staticstable" style="background:white;width: 100%;text-align: center;color:#213657;font-size: 12pt" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;color: white;background: #213657">Month</th>
					<th style="color: white;background: #213657">Profit</th>
					<th style="color: white;background: #213657">Yield</th>
				</tr>
				<?php
				$i = 0;
				foreach ($monlinks as $monlink) {

					$all_in_one = count_user_stats_all(false, $monlink, false);
					?>
					<tr>
						<td nowrap style="height:23px;border: 1px solid gainsboro;text-align: center;font-weight: bold">
							<?php
							$m = substr($monlink, -2);
							$Y = substr($monlink, 0, 4);
							$date = $m . "/" . $Y;
							echo $date;
							?>
						</td>
						<td nowrap style="height:23px;border: 1px solid gainsboro;text-align: center;font-weight: bold">
							<?php
							$n = $all_in_one['profit'];
							if ($n == 0) {
								$color = "black";
							} elseif ($n > 0) {
								$n = "+" . $n;
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong><?php echo $n ?></strong></span>
						</td>
						<td nowrap style="height:23px;border: 1px solid gainsboro;text-align: center;font-weight: bold">
							<?php echo $all_in_one['yielder'] . "%"; ?>
						</td>
					</tr>
					<?php
					$i++;
				}
				?>
			</table>
		</div>
	</div>
</body>

</html>
