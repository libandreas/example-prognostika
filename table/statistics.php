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
	<div id="diva">

		<?php if ($libpasswd == $getpasswd && $getlevel == 'admin' or $libpasswd == $getpasswd && $libusername == $userme) { ?>
			<a target="_parent" href="/pliromes/todaytips.php?u=<?php echo $userme ?>"><span style="color:red">[Προσθήκη tips]</span></a>
		<?php } ?>

		<?php if ($libpasswd == $getpasswd && $getlevel == 'admin' or $libpasswd == $getpasswd && $libusername == $userme) { ?>
			<a target="_parent" style="color:green" href="/pliromes/apotelesmata.php?u=<?php echo $userme ?>">[Προσθήκη αποτελεσμάτων]</a>
		<?php } ?>

		<?php if ($libpasswd == $getpasswd && $getlevel == 'admin' or $libpasswd == $getpasswd && $libusername == $userme) { ?>
			<a target="_parent" href="/index.php?logout=1" style="float:right"><span style="color:royalblue">[Exit]</span></a>
		<?php } ?>

		<?php if ($libpasswd == $getpasswd && $getlevel == 'admin' or $libpasswd == $getpasswd && $libusername == $userme) { ?>
			<hr>
		<?php } ?>

		<h2 class="head3">
			<?php echo get_this_tipster_name() ?>
			<i class="fa fa-caret-down" aria-hidden="true"></i>
			<div style="display: inline-block;float: right">
				<a href="/table/todaytips.php?u=<?php echo $userme ?>" class="title-button" style="color:white;text-decoration:none;padding: 8px;background: #213657;display: inline-block;position: relative;top: -8px;font-size: 11pt;">
					&#9917; Bets
				</a>
				<a href="/table/statistics.php?u=<?php echo $userme ?>" class="title-button" style="color:white;text-decoration:none;padding: 8px;background: #213657;display: inline-block;position: relative;top: -8px;font-size: 11pt;">
					&#128200; Στατιστικά
				</a>
				<a href="#" class="title-button" style="color:white;text-decoration:none;padding: 8px;background: #213657;display: inline-block;position: relative;top: -8px;font-size: 11pt;">
					&#9989; About
				</a>
			</div>
		</h2>

		<h3>Overall</h3>
		<form method="get" action="" style="margin-bottom: 1em;">
			<input type="hidden" name="u" value="<?php echo $userme ?>">
			<select required name="s" style="padding: 7px;margin-right:3px;background: #0a1626;color: white;font-weight: 700;border: 0">
				<option value="">Select Season</option>
				<?php
				foreach ($getseasons as $season) {

					$season = trim($season);
					$text = explode(" - ", $season);
					$text[0] = substr($text[0], 0, 4);
					$text[1] = substr($text[1], 0, 4);
					echo "<option value=\"$season\">$text[0] - $text[1]</option>";
				}
				?>
			</select>
			<input type="submit" value="Αναζήτηση" style="padding: 8px 9px;background: #0a1626;color: white;font-weight: 700;border: 0">
			<a class="desktop" href="/table/statistics.php?u=<?php echo $userme ?>" style="text-decoration: none">
				<input type="button" value="Επαναφορά πίνακα" style="padding: 8px 9px;background: #0a1626;color: white;font-weight: 700;border: 0">
			</a>
			<br>
		</form>
		<h2 style="margin-bottom: 0" class="head4">Προγνωστικά
			<?php echo get_this_tipster_name() ?>
			<i class="fa fa-caret-down" aria-hidden="true"></i>
			<?php
			$prof = count_user_profit();
			if ($prof > 0) {
				$prof = "<span style='color:limegreen'>+$prof</span>";
			} elseif ($prof == 0) {
				$prof = "<span style='color:white'>$prof</span>";
			} else {
				$prof = "<span style='color:red'>$prof</span>";
			}
			?>
			<span style="float:right">Overall Profit:
				<?php echo $prof ?>
			</span>
		</h2>
		<div>
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Stakes/Pick</th>
					<th style="text-align: center;color: white;background: #213657">Picks</th>
					<th style="text-align: center;color: white;background: #213657">Win Rate</th>
					<th style="text-align: center;color: white;background: #213657">Profit</th>
					<th style="text-align: center;color: white;background: #213657">Yield</th>
					<th style="text-align: center;color: white;background: #213657">Avg Stake</th>
					<th style="text-align: center;color: white;background: #213657">Avg Odds</th>
				</tr>
				<?php
				$i = 0;
				$overall_packs_with_key = generate_overall_packs_with_key();
				foreach ($overall_packs_with_key as $key => $pack) {
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							if ($overall_extra_data[$key] == 'long') {
								echo "<strong>Long Term</strong>";
							} elseif ($overall_extra_data[$key] == 'live') {
								echo "<strong>Live</strong>";
							} else {
								echo "<strong>Pre-Game</strong>";
							}
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_records(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_success_rate(false, false, false, $pack) . "%";
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = trim(count_user_profit(false, false, false, $pack));
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo count_user_yield(false, false, false, $pack) . '%';
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_stake(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_odds(false, false, false, $pack);
							?>
						</td>
					</tr>
					<?php
					$i++;
				}
				?>
			</table>
		</div>

		<h3>Ιστορικό ανά μήνα</h3>
		<?php
		$monlink = $season_start;
		$monlinks = array();

		//push the first monlink
		$monlinks[] = $season_start;

		//make the step monlinks
		while ($monlink <= $season_end) {
			$monlink = monlink_step($monlink);
			$monlinks[] = $monlink;
		}

		//trim the last monlink
		array_pop($monlinks);
		?>
		<div style="overflow-x: auto">
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Month</th>
					<th style="text-align: center;color: white;background: #213657">Picks</th>
					<th style="text-align: center;color: white;background: #213657">Win Rate</th>
					<th style="text-align: center;color: white;background: #213657">Profit</th>
					<th style="text-align: center;color: white;background: #213657">Yield</th>
					<th style="text-align: center;color: white;background: #213657">Avg Stake</th>
					<th style="text-align: center;color: white;background: #213657">Avg Odds</th>
				</tr>
				<?php
				$i = 0;
				foreach ($monlinks as $monlink) {

					//generate pack for that month
					$files = generate_all_packs_from_tip_minas($monlink);
					if (empty($files)) {
						continue;
					}
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							$m = substr($monlink, -2);
							$Y = substr($monlink, 0, 4);
							$date = $m . "/" . $Y;
							echo $date;
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php echo call_user_records(false, false, false, $files) ?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php echo call_user_success_rate(false, $monlink, false, $files) ?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = count_user_profit(false, false, false, $files);
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">

							<?php echo count_user_yield(false, false, false, $files) . '%'; ?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php echo call_user_average_stake(false, false, false, $files) ?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php echo call_user_average_odds(false, false, false, $files) ?>
						</td>
					</tr>
					<?php
					$i++;
				}
				?>
			</table>
		</div>

		<h3>Bookmakers</h3>
		<div style="overflow-x: auto">
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Bookmaker</th>
					<th style="text-align: center;color: white;background: #213657">Picks</th>
					<th style="text-align: center;color: white;background: #213657">Win Rate</th>
					<th style="text-align: center;color: white;background: #213657">Profit</th>
					<th style="text-align: center;color: white;background: #213657">Yield</th>
					<th style="text-align: center;color: white;background: #213657">Avg Stake</th>
					<th style="text-align: center;color: white;background: #213657">Avg Odds</th>
				</tr>
				<?php
				//load the pre-made list
				$eteries_packs_with_key = generate_eteries_packs_with_key();
				foreach ($eteries_packs_with_key as $key => $pack) {
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							echo $eteries_extra_data[$key];
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_records(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_success_rate(false, false, false, $pack) . "%";
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = trim(count_user_profit(false, false, false, $pack));
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo count_user_yield(false, false, false, $pack) . '%';
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_stake(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_odds(false, false, false, $pack);
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>

		<h3>Sports</h3>
		<div style="overflow-x: auto">
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Sports</th>
					<th style="text-align: center;color: white;background: #213657">Picks</th>
					<th style="text-align: center;color: white;background: #213657">Win Rate</th>
					<th style="text-align: center;color: white;background: #213657">Profit</th>
					<th style="text-align: center;color: white;background: #213657">Yield</th>
					<th style="text-align: center;color: white;background: #213657">Avg Stake</th>
					<th style="text-align: center;color: white;background: #213657">Avg Odds</th>
				</tr>
				<?php
				//load the pre-made list
				$sports_packs_with_key = generate_sports_packs_with_key();
				foreach ($sports_packs_with_key as $key => $pack) {
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							//read the company from extra data
							echo $sports_extra_data[$key];
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_records(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_success_rate(false, false, false, $pack) . "%";
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = trim(count_user_profit(false, false, false, $pack));
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo count_user_yield(false, false, false, $pack) . '%';
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_stake(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_odds(false, false, false, $pack);
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>

		<div style="overflow-x: auto">

			<h3><a name="leagues">Leagues / Cups</a></h3>
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Country</th>
					<th style="text-align: center;color: white;background: #213657">Leagues</th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&lgs-min=1&lgs-max=10&tax=picks" ?>">Picks &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&lgs-min=1&lgs-max=10&tax=winrate" ?>">Win Rate &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&lgs-min=1&lgs-max=10&tax=profit" ?>">Profit &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&lgs-min=1&lgs-max=10&tax=yield" ?>">Yield &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&lgs-min=1&lgs-max=10&tax=avgodds" ?>">Average Odds &#8675;</a></th>
				</tr>
				<?php

				//load the premade list
				$leagues_packs_with_key = generate_leagues_pack_with_key();
				foreach ($leagues_packs_with_key as $key => $pack) {
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							$data = explode('**', $leagues_extra_data[$key]);
							echo $data[1];
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$data = explode('**', $leagues_extra_data[$key]);
							echo $data[2];
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_records(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_success_rate(false, false, false, $pack) . "%";
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = trim(count_user_profit(false, false, false, $pack));
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo count_user_yield(false, false, false, $pack) . '%';
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_odds(false, false, false, $pack);
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<br>
		<div class="pagination">
			<?php setup_pagination_variables('lgs'); ?>
			<a class="prev page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&lgs-min=<?php echo 0 ?>&lgs-max=<?php echo 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">&laquo;</a>
			<a class="page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&lgs-min=<?php echo $min - 10 ?>&lgs-max=<?php echo $max - 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">
				<?php echo $current_page - 1 ?>
			</a>
			<span class="page-numbers current">
				<?php echo $current_page; ?>
			</span>
			<a class="page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&lgs-min=<?php echo $min + 10 ?>&lgs-max=<?php echo $max + 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">
				<?php echo $current_page + 1 ?>
			</a>
			<a class="next page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&lgs-min=<?php echo $min + 10 ?>&lgs-max=<?php echo $max + 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">&raquo;</a>
		</div>

		<h3><a name="markets">Markets</a></h3>
		<div style="overflow-x: auto">
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Market</th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&mks-min=1&mks-max=10&tax=picks" ?>">Picks &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&mks-min=1&mks-max=10&tax=winrate" ?>">Win Rate &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&mks-min=1&mks-max=10&tax=profit" ?>">Profit &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&mks-min=1&mks-max=10&tax=yield" ?>">Yield &#8675;</a></th>

					<th style="text-align: center;color: white;background: #213657;cursor: pointer"><a href="<?php echo "/table/statistics.php?u=$userme&start=$season_start&end=$season_end&mks-min=1&mks-max=10&tax=avgodds" ?>">Average Odds &#8675;</a></th>
				</tr>
				<?php
				//load the premade list
				$i = 0;
				$markets_packs_with_key = generate_markets_pack_with_key();
				foreach ($markets_packs_with_key as $key => $pack) {
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							$data = explode('**', $markets_extra_data[$key]);
							echo $data[1];
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_records(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_success_rate(false, false, false, $pack) . "%";
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = trim(count_user_profit(false, false, false, $pack));
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo count_user_yield(false, false, false, $pack) . '%';
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_odds(false, false, false, $pack);
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<br>
		<div class="pagination">
			<?php setup_pagination_variables('mks'); ?>
			<a class="prev page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&mks-min=<?php echo 0 ?>&mks-max=<?php echo 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">&laquo;</a>
			<a class="page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&mks-min=<?php echo $min - 10 ?>&mks-max=<?php echo $max - 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">
				<?php echo $current_page - 1 ?>
			</a>
			<span class="page-numbers current">
				<?php echo $current_page; ?>
			</span>
			<a class="page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&mks-min=<?php echo $min + 10 ?>&mks-max=<?php echo $max + 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">
				<?php echo $current_page + 1 ?>
			</a>
			<a class="next page-numbers" href="/table/statistics.php?u=<?php echo $userme ?>&mks-min=<?php echo $min + 10 ?>&mks-max=<?php echo $max + 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">&raquo;</a>
		</div>

		<h3>Stakes / Πονταρίσματα</h3>
		<div style="overflow-x: auto">
			<table class="staticstable" cellpadding="6" cellspacing="0">
				<tr>
					<th style="height:23px;text-align: left;color: white;background: #213657">Stakes/Pick</th>
					<th style="text-align: center;color: white;background: #213657">Picks</th>
					<th style="text-align: center;color: white;background: #213657">Win Rate</th>
					<th style="text-align: center;color: white;background: #213657">Profit</th>
					<th style="text-align: center;color: white;background: #213657">Yield</th>
					<th style="text-align: center;color: white;background: #213657">Avg Stake</th>
					<th style="text-align: center;color: white;background: #213657">Avg Odds</th>
				</tr>
				<?php
				$pontarismata = array('1-10', '11-20', '21-30', '31-40', '41-50', '51-100', '151-200', '201-250', '251-300');
				$pontarismata_packs_with_key = generate_pontarismata_packs_with_key($pontarismata);
				foreach ($pontarismata_packs_with_key as $key => $pack) {
					?>
					<tr>
						<td nowrap style="height:23px;border-bottom: 4px solid gainsboro;text-align: left;">
							<?php
							echo $pontarismata_extra_data[$key]
								?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_records(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_success_rate(false, false, false, $pack) . "%";
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							$n = trim(count_user_profit(false, false, false, $pack));
							if ($n == 0) {
								$color = "black";
							} elseif ($n >= 0) {
								$color = "green";
							} else {
								$color = "red";
							}
							?>
							<span style="color:<?php echo $color ?>"><strong>
									<?php echo $n ?>
								</strong></span>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo count_user_yield(false, false, false, $pack) . '%';
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_stake(false, false, false, $pack);
							?>
						</td>
						<td nowrap style="border-bottom: 4px solid gainsboro;text-align: center;">
							<?php
							echo call_user_average_odds(false, false, false, $pack);
							?>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
		<br>
	</div>
	<div style="display:none" id="loading-screen">
		<div></div>
	</div>
</body>

</html>
