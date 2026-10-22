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
			<a class="desktop" href="/table/todaytips.php?u=<?php echo $userme ?>" style="text-decoration: none">
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

		<?php
		// Προσαρμογή εμφάνισης για την πλατφόρμα παραδειγμάτων.
		if (file_exists("static-$season_start.php")) {
			include "static-$season_start.php";
		} else {

			$kerdismena = call_user_kerdismena_by_season($season_start, $season_end);
			$success_rate = call_user_success_rate_by_season($season_start, $season_end);
			$ola = call_user_records_by_season($season_start, $season_end);
			$xamena = count_user_xamena_by_season($season_start, $season_end);
			$avgodds = call_user_average_odds_by_season($season_start, $season_end);
			$yielder = count_user_yield_by_season($season_start, $season_end);
			$void = count_user_draws_by_season($season_start, $season_end);
			$profit = count_user_profit_by_season($season_start, $season_end);
		}
		?>
		<table class='boldtable2 desktop' style="width: 100% ">
			<tbody>
				<tr>
					<td style="text-align: right">Season</td>
					<td><strong>
							<?php
							echo $current_season_for_gui;
							?>
						</strong>
					</td>
					<td style="text-align: right">Won</td>
					<td><strong>
							<?php echo $kerdismena; ?>
						</strong></td>
					<td style="text-align: right">Success Rate</td>
					<td><strong>
							<?php echo $success_rate; ?>%
						</strong></td>
				</tr>
				<tr>
					<td style="text-align: right">Total bets</td>
					<td><strong>
							<?php echo $ola; ?>
						</strong></td>
					<td style="text-align: right">Lost</td>
					<td><strong>
							<?php echo $xamena; ?>
						</strong></td>
					<td style="text-align: right">Avg Odds</td>
					<td><strong>
							<?php echo $avgodds ?>
						</strong></td>
				</tr>
				<tr>
					<?php if ($userme != 'dinner') { ?>
						<td style="text-align: right">Yield</td>
						<td><strong>
								<?php echo $yielder ?>%
							</strong></td>
					<?php } else { ?>
						<td style="text-align: right"></td>
						<td><strong></strong></td>
					<?php } ?>
					<td style="text-align: right">Void</td>
					<td><strong>
							<?php echo $void; ?>
						</strong></td>
					<td style="text-align: right">Profit</td>
					<td><strong>
							<?php echo $profit; ?>
						</strong></td>
				</tr>
			</tbody>
		</table>
		<div class="mobile">
			<table class='boldtable2' style="width: 100%">
				<tbody>
					<tr>
						<td>Year</td>
						<td>
							<strong>
								<?php echo $current_season_for_gui; ?>
							</strong>
						</td>
					</tr>
					<tr>
						<td>Won</td>
						<td><strong>
								<?php echo $kerdismena; ?>
							</strong></td>
					</tr>
					<tr>
						<td>Success Rate</td>
						<td><strong>
								<?php echo $success_rate; ?>
							</strong></td>
					</tr>
					<tr>
						<td>Total bets</td>
						<td><strong>
								<?php echo $ola; ?>
							</strong></td>
					</tr>
					<tr>
						<td>Lost</td>
						<td><strong>
								<?php echo $xamena; ?>
							</strong></td>
					</tr>
					<?php if ($userme != 'dinner') { ?>
						<tr>
							<td>Yield</td>
							<td><strong>
									<?php echo $yielder; ?>%
								</strong></td>
						</tr>
					<?php } ?>
					<tr>
						<td>Avg Odds</td>
						<td><strong>
								<?php echo $avgodds; ?>
							</strong></td>
					</tr>
					<tr>
						<td>Void</td>
						<td><strong>
								<?php echo $void; ?>
							</strong></td>
					</tr>
					<tr>
						<td>Profit</td>
						<td><strong>
								<?php echo $profit; ?>
							</strong></td>
					</tr>
				</tbody>
			</table>
		</div>

		<h3>Open Bets</h3>
		<div style="overflow-x: auto">
			<table class="staticstable-new" cellpadding="6" cellspacing="0">
				<?php
				$files = generate_open_bets_no_special();
				$i = 0;
				foreach ($files as $file) {

					setup_table_variables($file);
					$i++;
					?>
					<?php for ($n = 1; $n <= $simeia; $n++) { ?>
						<?php if ($kleidomeno != null && $pass_lock == false) { ?>
							<tr>
								<td title="<?php echo $xora[$n] ?>" colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

									<img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
										<?php echo $omada1[$n] ?> -
										<?php echo $omada2[$n] ?>
									</strong>

									<span style="float:right">

										<strong>&#128337;
											<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
										</strong>
									</span>
								</td>
							</tr>
							<tr class="mobile-tr">
								<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;"></th>
								<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;"></th>
							</tr>
							<tr class="mobile-tr">
								<td colspan="6">
									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>
								</td>
								<td colspan="6">
									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>
								</td>
							</tr>
							<tr>
								<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;"></th>
								<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
								<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
								<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
								<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

								</th>
								<th nowrap colspan="1" style="width:16.6%"></th>
							</tr>
							<tr>
								<td class="desktop-td">
									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>
								</td>
								<td class="desktop-td">
									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>
								</td>
								<td>
									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>
								</td>
								<td nowrap>
									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>
								</td>
								<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>

								</td>
								<td nowrap>

									<a href="<?php $lock_url ?>" target="_blank">
										<img style="width: 23px" src="/images/padlock-icon.webp">
									</a>

								</td>
							</tr>
						<?php } else { ?>
							<tr>
								<td colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

									<img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
										<?php echo $omada1[$n] ?> -
										<?php echo $omada2[$n] ?>
									</strong>

									<span style="float:right">
										<?php if ($n == $simeia) { ?>

											<!--αλλαγή προγνοστικού μόνο admin-->
											<?php
											if ($libpasswd == $getpasswd && $getlevel == 'admin') {

												?><a target="_parent" style="position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>&mode=<?php echo $simeia ?>">&#9997;</a>
												<?php
											}
											?>

											<!--διαγραφή μονο admin-->
											<?php
											if ($libpasswd == $getpasswd && $getlevel == 'admin') {
												?>
												<a style="position:relative;z-index:1;text-decoration: none" onclick="return confirm('Are you sure?')" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&delete-tip=1&dir=<?php echo $dir_of_tip ?>">&#10060;</a>
												<?php
											}
											?>

											<!--to parakato einai mono gia localhost-->
											<?php
											if ($libpasswd == $getpasswd && $getlevel == 'admin') {

												$url = $url = format_edit_link_file($dir_of_tip . "/tips.txt");
												$info = "<a style=\"text-decoration: none\" href=\"$url\" title=\"Άθλημα: $athlima[1], Xώρα: $xora[1], Πρωτάθλημα: $protathlima[1], Καταχωρήθηκε: $put, Id: $today\">&#128270;</a>";
												echo $info;
											}
											?>

										<?php } ?>

										<strong>&#128337;
											<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
										</strong>
									</span>
								</td>
							</tr>
							<tr class="mobile-tr">
								<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Αγορά</th>
								<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Προγνωστικό</th>
							</tr>
							<tr class="mobile-tr">
								<td colspan="6">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $agora[$n] ?>
										</strong>
									</div>
								</td>
								<td colspan="6">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $tips[$n] ?>
										</strong>
									</div>
								</td>
							</tr>
							<tr>
								<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;">Αγορά</th>
								<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Προγνωστικό</th>
								<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">
									<?php if ($n == $simeia) {
										echo 'Stake';
									} ?>
								</th>
								<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Αποτέλεσμα</th>
								<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

									<?php if ($per != null && $n == $simeia) { ?>
										<a id="opn<?php echo $today ?>" onclick="w3.toggleShowTR('#clo<?php echo $today ?>');$('#btn<?php echo $today ?>').hide();resizeIframePostMessage();" style="display: inline-block;padding: 2px 6px;font-size: 9pt;text-align: center;border: 1px solid white;background: #000055;border-radius: 12px;cursor:pointer;">Ανάλυση &rarr;
										</a>
									<?php } ?>

								</th>
								<th nowrap colspan="1" style="width:16.6%"></th>
							</tr>
							<tr>
								<td class="desktop-td">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $agora[$n] ?>
										</strong>
									</div>
								</td>
								<td class="desktop-td">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $tips[$n] ?>
										</strong>
									</div>
								</td>
								<td>

									<?php if ($n == $simeia) {
										?>
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $posoA ?>
											</strong>
										</div>
										<?php
									} ?>
								</td>
								<td nowrap>
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $apot[$n] ?>
										</strong>
									</div>
								</td>
								<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

									<?php if ($n == $simeia) { ?>
										<a target="_blank" style="background:white;display: inline-block;position: relative;width: 95%;margin-left: 5%;margin-right: 0%;height: 32px;text-decoration:none;top:3px;" href="<?php echo $booklink; ?>">

											<div style="background: <?php echo $bookcolor ?>;border-radius: 100%;width: 44px;height: 44px;position: absolute;top: -6px;left: -10px;border: 1px solid white;">
												<img alt="<?php echo $booktext ?>" style="width: 100%;height:auto;" src="<?php echo $bookimg ?>">
											</div>

											<strong style="position: absolute;top: 7px;left: 34%;color:black;font-size: 13pt;font-family: fantasy;">
												<?php echo number_format($odds[1] * $odds[2] * $odds[3], 2) ?>
											</strong>

											<div style="position: absolute;color: white;font-size: 14pt;font-family: fantasy;right: 0px;width: 39px;background: crimson;top: 0px;height: 32px;">
												<span style="position:absolute;top: 4px;right: 11px;font-size: 29px;font-weight: 700;font-family: sans-serif;">&#xbb;</span>
											</div>
										</a>
									<?php } ?>

								</td>
								<td nowrap>

									<?php if ($n == $simeia) { ?>
										<div class="<?php echo $profitclass ?>" style="display:block;padding:6px;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $profit ?>
											</strong>
										</div>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					<?php } ?>

					<!--analisi-->
					<?php if ($per != null && $kleidomeno == null or $per != null && $pass_lock == true) { ?>

						<tr style="display:none;" id="clo<?php echo $today ?>">
							<td class="analisi-new" colspan="12">
								<div style="border: 2px solid whitesmoke;color:white;padding-left:6px;padding-right:6px;border-radius: 12px;">
									<?php echo $per ?>
								</div>
							</td>
						</tr>

					<?php } ?>

					<!--spaces-->
					<tr>
						<td colspan="12" style="height:9px;"></td>
					</tr>
					<tr>
						<td colspan="12" style="background:white;height:7px;"></td>
					</tr>
					<?php
				}
				?>
			</table>

			<?php
			if ($i == 0) { ?>
				<p style="margin-bottom:0;text-align: center">Δεν βρέθηκαν ανοιχτά προγνωστικά σε αυτό το προφίλ.</p>
			<?php } ?>
		</div>

		<?php if (!isset($_GET['show-long-term'])) { ?>
			<a id="buttonlong" style="width: 100%;padding: 9px;margin-top: 19px;" href="/table/todaytips.php?u=<?php echo $_GET['u'] ?>>&show-long-term=1" class="xron xronselect">&#9889; Long Term Bets
				<?php echo "(" . count_long_term_bets($userme) . ")" ?>
			</a>
		<?php } else { ?>

			<a id="buttoncloselong" style="width: 100%;padding: 9px;margin-top: 19px" href="/table/todaytips.php?u=<?php echo $_GET['u'] ?>>" class="xron xronselectclose">&#10060; Long Term Bets</a>
		<?php } ?>

		<?php if (isset($_GET['show-long-term'])) { ?>
			<h3>Long Term Bets</h3>
			<div style="overflow-x: auto">
				<table class="staticstable-new" cellpadding="6" cellspacing="0">
					<?php

					//long term
					$files = generate_long_term_bets();
					foreach ($files as $file) {

						setup_table_variables($file);
						?>
						<?php for ($n = 1; $n <= $simeia; $n++) { ?>
							<?php if ($kleidomeno != null && $pass_lock == false && $dwl[1] == "-") { ?>
								<tr>
									<td title="<?php echo $xora[$n] ?>" colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

										<img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
											<?php echo $omada1[$n] ?> -
											<?php echo $omada2[$n] ?>
										</strong>

										<span style="float:right">
											<strong>&#128337;
												<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
											</strong>
										</span>
									</td>

								</tr>

								<tr class="mobile-tr">
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;"></th>
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;"></th>
								</tr>
								<tr class="mobile-tr">
									<td colspan="6">
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
									<td colspan="6">
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>
									</td>
								</tr>
								<tr>
									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;"></th>
									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
									<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

									</th>
									<th nowrap colspan="1" style="width:16.6%"></th>
								</tr>

								<tr>
									<td class="desktop-td">
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>
									</td>
									<td class="desktop-td">
										<a href="<?php $lock_url ?>" target="_blank"> <img style="width: 23px" src="/images/padlock-icon.webp"> </a>
									</td>
									<td>
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
									<td nowrap>
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>
									</td>
									<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
									<td nowrap>

										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
								</tr>
							<?php } else { ?>
								<tr>
									<td colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left"> <img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
											<?php echo $omada1[$n] ?> -
											<?php echo $omada2[$n] ?>
										</strong>

										<span style="float:right">
											<?php if ($n == $simeia) { ?>

												<!--αλλαγή προγνοστικού μόνο admin-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin' && !str_contains($dir_of_tip, 'records')) {

													?><a target="_parent" style="position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>&mode=<?php echo $simeia ?>">&#9997;</a>
													<?php
												}
												?>

												<!--επεξεργασία αποτελεσμάτων μόνο admin-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin' && file_exists(str_replace("tips.txt", "wdl.1.txt", $file))) {

													?>
													<a target="_parent" style="filter:hue-rotate(400deg);position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips-apot.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>">&#9997;</a>
													<?php
												}
												?>

												<!--διαγραφή μονο admin-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin') {
													?>
													<a style="position:relative;z-index:1;text-decoration: none" onclick="return confirm('Are you sure?')" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&dir=<?php echo $dir_of_tip ?>">&#10060;</a>
													<?php
												}
												?>

												<!--to parakato einai mono gia localhost-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin') {

													$url = format_edit_link_file($dir_of_tip . "/tips.txt");
													$info = "<a style=\"text-decoration: none\" href=\"$url\" title=\"Άθλημα: $athlima[1], Xώρα: $xora[1], Πρωτάθλημα: $protathlima[1], Καταχωρήθηκε: $put, Id: $today\">&#128270;</a>";
													echo $info;
												}
												?>
											<?php } ?>
											<strong>&#128337;
												<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
											</strong>
										</span>
									</td>
								</tr>
								<tr class="mobile-tr">
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Αγορά</th>
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Προγνωστικό</th>
								</tr>
								<tr class="mobile-tr">
									<td colspan="6">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $agora[$n] ?>
											</strong>
										</div>
									</td>
									<td colspan="6">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $tips[$n] ?>
											</strong>
										</div>
									</td>
								</tr>
								<tr>

									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;">Αγορά</th>
									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Προγνωστικό</th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">
										<?php if ($n == $simeia) {
											echo 'Stake';
										} ?>
									</th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Αποτέλεσμα</th>
									<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

										<?php if ($per != null && $n == $simeia) { ?>
											<a id="opn<?php echo $today ?>" onclick="w3.toggleShowTR('#clo<?php echo $today ?>');$('#btn<?php echo $today ?>').hide();resizeIframePostMessage();" style="display: inline-block;padding: 2px 6px;font-size: 9pt;text-align: center;border: 1px solid white;background: #000055;border-radius: 12px;cursor:pointer;">Ανάλυση &rarr;
											</a>
										<?php } ?>

									</th>
									<th nowrap colspan="1" style="width:16.6%"></th>
								</tr>
								<tr>
									<td class="desktop-td">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $agora[$n] ?>
											</strong>
										</div>
									</td>
									<td class="desktop-td">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $tips[$n] ?>
											</strong>
										</div>
									</td>
									<td>
										<?php if ($n == $simeia) {
											?>
											<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
													<?php echo $posoA ?>
												</strong>
											</div>
											<?php
										} ?>
									</td>
									<td nowrap>
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $apot[$n] ?>
											</strong>
										</div>
									</td>
									<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

										<?php if ($n == $simeia) { ?>
											<a target="_blank" style="background:white;display: inline-block;position: relative;width: 95%;margin-left: 5%;margin-right: 0%;height: 32px;text-decoration:none;top:3px;" href="<?php echo $booklink; ?>">

												<div style="background: <?php echo $bookcolor ?>;border-radius: 100%;width: 44px;height: 44px;position: absolute;top: -6px;left: -10px;border: 1px solid white;">
													<img alt="<?php echo $booktext ?>" style="width: 100%;height:auto;" src="<?php echo $bookimg ?>">
												</div>

												<strong style="position: absolute;top: 7px;left: 34%;color:black;font-size: 13pt;font-family: fantasy;">
													<?php echo number_format($odds[1] * $odds[2] * $odds[3], 2) ?>
												</strong>

												<div style="position: absolute;color: white;font-size: 14pt;font-family: fantasy;right: 0px;width: 39px;background: crimson;top: 0px;height: 32px;">
													<span style="position:absolute;top: 4px;right: 11px;font-size: 29px;font-weight: 700;font-family: sans-serif;">&#xbb;</span>
												</div>
											</a>
										<?php } ?>

									</td>
									<td nowrap>

										<?php if ($n == $simeia) { ?>
											<div class="<?php echo $profitclass ?>" style="display:block;padding:6px;border: 3px solid gray;border-radius: 12px"><strong>
													<?php echo $profit ?>
												</strong>
											</div>

										<?php } ?>

									</td>
								</tr>
							<?php } ?>

						<?php } ?>


						<!--analisi-->
						<?php if ($per != null && $kleidomeno == null or $per != null && $pass_lock == true or $per != null && $dwl[1] != "-") { ?>

							<tr style="display:none;" id="clo<?php echo $today ?>">
								<td class="analisi-new" colspan="12">
									<div style="border: 2px solid whitesmoke;color:white;padding-left:6px;padding-right:6px;border-radius: 12px;">
										<?php echo $per ?>
									</div>
								</td>
							</tr>

						<?php } ?>

						<!--spaces-->
						<tr>
							<td colspan="12" style="height:9px;"></td>
						</tr>
						<tr>
							<td colspan="12" style="background:white;height:7px;"></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>

			<div class="pagination">
				<?php setup_pagination_variables('lg'); ?>
				<a class="prev page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lg-min=0&lg-max=10">&laquo;</a>
				<a class="page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lg-min=<?php echo $min - 10 ?>&lg-max=<?php echo $max - 10 ?>">
					<?php echo $current_page - 1 ?>
				</a>
				<span class="page-numbers current">
					<?php echo $current_page; ?>
				</span>
				<a class="page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lg-min=<?php echo $min + 10 ?>&lg-max=<?php echo $max + 10 ?>">
					<?php echo $current_page + 1 ?>
				</a>
				<a class="next page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lg-min=<?php echo $min + 10 ?>&lg-max=<?php echo $max + 10 ?>">&raquo;</a>
			</div>
		<?php } ?>

		<?php if (!isset($_GET['show-live'])) { ?>
			<a id="buttonlong" style="width: 100%;margin-top: 19px;" href="/table/todaytips.php?u=<?php echo $userme ?>&show-live=1" class="xron xronselect">&#9889; Live Bets
				<?php echo "(" . count_live_bets($userme) . ")" ?>
			</a>
		<?php } else { ?>

			<a id="buttoncloselong" style="width: 100%;margin-top: 19px" href="/table/todaytips.php?u=<?php echo $userme ?>" class="xron xronselectclose">&#10060; Live Bets</a>
		<?php } ?>

		<?php if (isset($_GET['show-live'])) { ?>
			<h3>Live Bets</h3>
			<div style="overflow-x: auto">
				<table class=" staticstable-new" cellpadding="6" cellspacing="0">
					<?php

					//live
					$files = generate_live_bets();
					foreach ($files as $file) {

						setup_table_variables($file);
						?>
						<?php for ($n = 1; $n <= $simeia; $n++) { ?>
							<?php if ($kleidomeno != null && $pass_lock == false && $dwl[1] == "-") { ?>
								<tr>
									<td title="<?php echo $xora[$n] ?>" colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

										<img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
											<?php echo $omada1[$n] ?> -
											<?php echo $omada2[$n] ?>
										</strong>

										<span style="float:right">
											<?php if ($n == $simeia) { ?>

												<!--to parakato einai mono gia localhost-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin') {

													$url = $url = format_edit_link_file($dir_of_tip . "/tips.txt");
													$info = "<a style=\"text-decoration: none\" href=\"$url\" title=\"Άθλημα: $athlima[1], Xώρα: $xora[1], Πρωτάθλημα: $protathlima[1], Καταχωρήθηκε: $put, Id: $today\">&#128270;</a>";
													echo $info;
												}
												?>

											<?php } ?>
											<strong>&#128337;
												<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
											</strong>
										</span>
									</td>

								</tr>

								<tr class="mobile-tr">
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;"></th>
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;"></th>
								</tr>
								<tr class="mobile-tr">
									<td colspan="6">
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
									<td colspan="6">
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>
									</td>
								</tr>
								<tr>
									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;"></th>
									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100"></th>
									<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

									</th>
									<th nowrap colspan="1" style="width:16.6%"></th>
								</tr>

								<tr>
									<td class="desktop-td">
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>
									</td>
									<td class="desktop-td">
										<a href="<?php $lock_url ?>" target="_blank"> <img style="width: 23px" src="/images/padlock-icon.webp"> </a>
									</td>
									<td>
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
									<td nowrap>
										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>
									</td>
									<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
									<td nowrap>

										<a href="<?php $lock_url ?>" target="_blank">
											<img style="width: 23px" src="/images/padlock-icon.webp">
										</a>

									</td>
								</tr>
							<?php } else { ?>
								<tr>
									<td colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left"> <img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
											<?php echo $omada1[$n] ?> -
											<?php echo $omada2[$n] ?>
										</strong>

										<span style="float:right">
											<?php if ($n == $simeia) { ?>

												<!--αλλαγή προγνοστικού μόνο admin-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin' && !str_contains($dir_of_tip, 'records')) {

													?><a target="_parent" style="position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>&mode=<?php echo $simeia ?>">&#9997;</a>
													<?php
												}
												?>

												<!--επεξεργασία αποτελεσμάτων μόνο admin-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin' && file_exists(str_replace("tips.txt", "wdl.1.txt", $file))) {

													?>
													<a target="_parent" style="filter:hue-rotate(400deg);position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips-apot.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>">&#9997;</a>
													<?php
												}
												?>

												<!--διαγραφή μονο admin-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin') {
													?>
													<a style="position:relative;z-index:1;text-decoration: none" onclick="return confirm('Are you sure?')" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&delete-tip=1&dir=<?php echo $dir_of_tip ?>">&#10060;</a>
													<?php
												}
												?>

												<!--to parakato einai mono gia localhost-->
												<?php
												if ($libpasswd == $getpasswd && $getlevel == 'admin') {

													$url = $url = format_edit_link_file($dir_of_tip . "/tips.txt");
													$info = "<a style=\"text-decoration: none\" href=\"$url\" title=\"Άθλημα: $athlima[1], Xώρα: $xora[1], Πρωτάθλημα: $protathlima[1], Καταχωρήθηκε: $put, Id: $today\">&#128270;</a>";
													echo $info;
												}
												?>
											<?php } ?>
											<strong>&#128337;
												<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
											</strong>
										</span>
									</td>
								</tr>
								<tr class="mobile-tr">
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Αγορά</th>
									<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Προγνωστικό</th>
								</tr>
								<tr class="mobile-tr">
									<td colspan="6">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $agora[$n] ?>
											</strong>
										</div>
									</td>
									<td colspan="6">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $tips[$n] ?>
											</strong>
										</div>
									</td>
								</tr>
								<tr>

									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;">Αγορά</th>
									<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Προγνωστικό</th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">
										<?php if ($n == $simeia) {
											echo 'Stake';
										} ?>
									</th>
									<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Αποτέλεσμα</th>
									<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

										<?php if ($per != null && $n == $simeia) { ?>
											<a id="opn<?php echo $today ?>" onclick="w3.toggleShowTR('#clo<?php echo $today ?>');$('#btn<?php echo $today ?>').hide();resizeIframePostMessage();" style="display: inline-block;padding: 2px 6px;font-size: 9pt;text-align: center;border: 1px solid white;background: #000055;border-radius: 12px;cursor:pointer;">Ανάλυση &rarr;
											</a>
										<?php } ?>

									</th>
									<th nowrap colspan="1" style="width:16.6%"></th>
								</tr>
								<tr>
									<td class="desktop-td">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $agora[$n] ?>
											</strong>
										</div>
									</td>
									<td class="desktop-td">
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $tips[$n] ?>
											</strong>
										</div>
									</td>
									<td>
										<?php if ($n == $simeia) {
											?>
											<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
													<?php echo $posoA ?>
												</strong>
											</div>
											<?php
										} ?>
									</td>
									<td nowrap>
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $apot[$n] ?>
											</strong>
										</div>
									</td>
									<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

										<?php if ($n == $simeia) { ?>
											<a target="_blank" style="background:white;display: inline-block;position: relative;width: 95%;margin-left: 5%;margin-right: 0%;height: 32px;text-decoration:none;top:3px;" href="<?php echo $booklink; ?>">

												<div style="background: <?php echo $bookcolor ?>;border-radius: 100%;width: 44px;height: 44px;position: absolute;top: -6px;left: -10px;border: 1px solid white;">
													<img alt="<?php echo $booktext ?>" style="width: 100%;height:auto;" src="<?php echo $bookimg ?>">
												</div>

												<strong style="position: absolute;top: 7px;left: 34%;color:black;font-size: 13pt;font-family: fantasy;">
													<?php echo number_format($odds[1] * $odds[2] * $odds[3], 2) ?>
												</strong>
												<div style="position: absolute;color: white;font-size: 14pt;font-family: fantasy;right: 0px;width: 39px;background: crimson;top: 0px;height: 32px;">
													<span style="position:absolute;top: 4px;right: 11px;font-size: 29px;font-weight: 700;font-family: sans-serif;">&#xbb;</span>
												</div>
											</a>
										<?php } ?>

									</td>

									<td nowrap>

										<?php if ($n == $simeia) { ?>
											<div class="<?php echo $profitclass ?>" style="display:block;padding:6px;border: 3px solid gray;border-radius: 12px"><strong>
													<?php echo $profit ?>
												</strong>
											</div>
										<?php } ?>

									</td>
								</tr>
							<?php } ?>
						<?php } ?>

						<!--analisi-->
						<?php if ($per != null && $kleidomeno == null or $per != null && $pass_lock == true or $per != null && $dwl[1] != "-") { ?>

							<tr style="display:none;" id="clo<?php echo $today ?>">
								<td class="analisi-new" colspan="12">
									<div style="border: 2px solid whitesmoke;color:white;padding-left:6px;padding-right:6px;border-radius: 12px;">
										<?php echo $per ?>
									</div>
								</td>
							</tr>

						<?php } ?>

						<!--spaces-->
						<tr>
							<td colspan="12" style="height:9px;"></td>
						</tr>
						<tr>
							<td colspan="12" style="background:white;height:7px;"></td>
						</tr>
						<?php
					}
					?>
				</table>
			</div>

			<div class="pagination">
				<?php setup_pagination_variables('lv'); ?>
				<a class="prev page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lv-min=0&lv-max=10">&laquo;</a>
				<a class="page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lv-min=<?php echo $min - 10 ?>&lv-max=<?php echo $max - 10 ?>">
					<?php echo $current_page - 1 ?>
				</a>
				<span class="page-numbers current">
					<?php echo $current_page; ?>
				</span>

				<a class="page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lv-min=<?php echo $min + 10 ?>&lv-max=<?php echo $max + 10 ?>">
					<?php echo $current_page + 1 ?>
				</a>
				<a class="next page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&lv-min=<?php echo $min + 10 ?>&lv-max=<?php echo $max + 10 ?>">&raquo;</a>
			</div>
		<?php } ?>

		<h3>Pre Game Picks History</h3>
		<div style="overflow-x: auto">
			<table class="staticstable-new" cellpadding="6" cellspacing="0">
				<?php
				$files = generate_history_bets_no_special();
				foreach ($files as $file) {

					setup_table_variables($file);
					?>
					<?php for ($n = 1; $n <= $simeia; $n++) { ?>
						<tr>
							<td colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

								<img src="<?php echo $flag[$n] ?>" style="width:28px;height: 20px;margin-top: -1px;position:absolute"><strong>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php echo strtoupper(substr($xora[$n], 0, 3)); ?>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;
									<?php echo $omada1[$n] ?> -
									<?php echo $omada2[$n] ?>
								</strong>

								<span style="float:right">
									<?php if ($n == $simeia) { ?>

										<!--αλλαγή προγνοστικού μόνο admin-->
										<?php
										if ($libpasswd == $getpasswd && $getlevel == 'admin' && !str_contains($dir_of_tip, 'records')) {

											?><a target="_parent" style="position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips-apot.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>&mode=<?php echo $simeia ?>">&#9997;</a>
											<?php
										}
										?>

										<!--επεξεργασία αποτελεσμάτων μόνο admin-->
										<?php
										if ($libpasswd == $getpasswd && $getlevel == 'admin') {

											?>
											<a target="_parent" style="filter:hue-rotate(400deg);position:relative;z-index:1;text-decoration: none" href="/pliromes/todaytips-apot.php?u=<?php echo $userme_of_tip ?>&today=<?php echo $today ?>">&#9997;</a>
											<?php
										}
										?>

										<!--διαγραφή μονο admin-->
										<?php
										if ($libpasswd == $getpasswd && $getlevel == 'admin') {
											?>
											<a style="position:relative;z-index:1;text-decoration: none" onclick="return confirm('Are you sure?')" href="/pliromes/todaytips.php?u=<?php echo $userme_of_tip ?>&delete-tip=1&dir=<?php echo $dir_of_tip ?>">&#10060;</a>
											<?php
										}
										?>

										<!--to parakato einai mono gia localhost-->
										<?php
										if ($libpasswd == $getpasswd && $getlevel == 'admin') {

											$url = $url = format_edit_link_file($dir_of_tip . "/tips.txt");
											$info = "<a style=\"text-decoration: none\" href=\"$url\" title=\"Άθλημα: $athlima[1], Xώρα: $xora[1], Πρωτάθλημα: $protathlima[1], Καταχωρήθηκε: $put, Id: $today\">&#128270;</a>";
											echo $info;
										}
										?>

									<?php } ?>
									<strong>&#128337;
										<?php echo "$mera[$n]/$minas[$n] - $ora[$n]:$lepta[$n]"; ?>
									</strong>
								</span>
							</td>
						</tr>
						<tr class="mobile-tr">
							<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Αγορά</th>
							<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Προγνωστικό</th>
						</tr>
						<tr class="mobile-tr">
							<td colspan="6">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $agora[$n] ?>
									</strong>
								</div>
							</td>
							<td colspan="6">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $tips[$n] ?>
									</strong>
								</div>
							</td>
						</tr>
						<tr>

							<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100;">Αγορά</th>
							<th class="desktop-td" nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Προγνωστικό</th>
							<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">
								<?php if ($n == $simeia) {
									echo 'Stake';
								} ?>
							</th>
							<th nowrap colspan="1" style="width:16.6%;font-size:10pt;font-weight: 100">Αποτέλεσμα</th>
							<th nowrap colspan="7" style="width:16.6%;font-size:10pt;font-weight: 100;text-align:right;">

								<?php if ($per != null && $n == $simeia) { ?>
									<a id="opn<?php echo $today ?>" onclick="w3.toggleShowTR('#clo<?php echo $today ?>');$('#btn<?php echo $today ?>').hide();resizeIframePostMessage();" style="display: inline-block;padding: 2px 6px;font-size: 9pt;text-align: center;border: 1px solid white;background: #000055;border-radius: 12px;cursor:pointer;">Ανάλυση &rarr;
									</a>
								<?php } ?>

							</th>
							<th nowrap colspan="1" style="width:16.6%"></th>
						</tr>
						<tr>

							<td class="desktop-td">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $agora[$n] ?>
									</strong>
								</div>
							</td>
							<td class="desktop-td">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $tips[$n] ?>
									</strong>
								</div>
							</td>
							<td>

								<?php if ($n == $simeia) { ?>
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $posoA ?>
										</strong>
									</div>
									<?php
								} ?>
							</td>

							<td nowrap>
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $apot[$n] ?>
									</strong>
								</div>
							</td>
							<td colspan="7" style="background:transparent;min-width: 136px;text-align:center;">

								<?php if ($n == $simeia) { ?>
									<a target="_blank" style="background:white;display: inline-block;position: relative;width: 95%;margin-left: 5%;margin-right: 0%;height: 32px;text-decoration:none;top:3px;" href="<?php echo $booklink; ?>">

										<div style="background: <?php echo $bookcolor ?>;border-radius: 100%;width: 44px;height: 44px;position: absolute;top: -6px;left: -10px;border: 1px solid white;">
											<img alt="<?php echo $booktext ?>" style="width: 100%;height:auto;" src="<?php echo $bookimg ?>">
										</div>

										<strong style="position: absolute;top: 7px;left: 34%;color:black;font-size: 13pt;font-family: fantasy;">
											<?php echo number_format($odds[1] * $odds[2] * $odds[3], 2) ?>
										</strong>

										<div style="position: absolute;color: white;font-size: 14pt;font-family: fantasy;right: 0px;width: 39px;background: crimson;top: 0px;height: 32px;">
											<span style="position:absolute;top: 4px;right: 11px;font-size: 29px;font-weight: 700;font-family: sans-serif;">&#xbb;</span>
										</div>
									</a>
								<?php } ?>

							</td>
							<td nowrap>

								<?php if ($n == $simeia) { ?>
									<div class="<?php echo $profitclass ?>" style="display:block;padding:6px;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $profit ?>
										</strong>
									</div>
								<?php } ?>

							</td>
						</tr>
					<?php } ?>

					<!--analisi-->
					<?php if ($per != null) { ?>

						<tr style="display:none;" id="clo<?php echo $today ?>">
							<td class="analisi-new" colspan="12">
								<div style="border: 2px solid whitesmoke;color:white;padding-left:6px;padding-right:6px;border-radius: 12px;">
									<?php echo $per ?>
								</div>
							</td>
						</tr>

					<?php } ?>

					<!--spaces-->
					<tr>
						<td colspan="12" style="height:9px;"></td>
					</tr>
					<tr>
						<td colspan="12" style="background:white;height:7px;"></td>
					</tr>

					<!--advertisment-->
					<?php if (($i - 1) % 4 === 0) { ?>
						<tr class="desktop-tr">
							<td colspan="12" style="background:white;color:black">
								<?php echo $html_banner ?>
							</td>
						</tr>
						<tr class="mobile-tr">
							<td colspan="12" style="background:white;color:black">
								<?php echo $html_banner_mobile ?>
							</td>
						</tr>
					<?php } ?>
					<?php
				}
				?>
			</table>
		</div>
		<br>

		<div class="pagination">
			<?php setup_pagination_variables(); ?>
			<a class="prev page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&min=0&max=10">&laquo;</a>
			<a class="page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&min=<?php echo $min - 10 ?>&max=<?php echo $max - 10 ?>">
				<?php echo $current_page - 1 ?>
			</a>
			<span class="page-numbers current">
				<?php echo $current_page; ?>
			</span>
			<a class="page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&min=<?php echo $min + 10 ?>&max=<?php echo $max + 10 ?>">
				<?php echo $current_page + 1 ?>
			</a>
			<a class="next page-numbers" href="/table/todaytips.php?u=<?php echo $userme ?>&min=<?php echo $min + 10 ?>&max=<?php echo $max + 10 ?>">&raquo;</a>
		</div>

	</div>
	<div id="loading-screen">
		<div></div>
	</div>
</body>

</html>
