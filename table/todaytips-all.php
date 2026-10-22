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
		<!--MAIN HEAD-->
		<h2 class="head3" style="background:transparent;padding-left:0;padding-right:0">
			<i class="fa fa-caret-down" aria-hidden="true"></i>
			<div style="display:inline-block;float:left">
				<a href="todaytips-all.php" class="title-button">
					&#11088; Όλα τα αθλήματα
				</a>
				<?php
				$lines = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/athlimata/1/athlimata.txt');
				foreach ($lines as $line) { ?>
					<a href="todaytips.php?athlima=<?php echo $line ?>" class="title-button">
						&#128204;
						<?php echo $line ?>
					</a>
					<?php
				}
				?>
			</div>
		</h2>

		<h3>Open Bets</h3>
		<div style="overflow-x: auto">
			<table class="staticstable-new" cellpadding="6" cellspacing="0">
				<?php
				$files = generate_open_bets_with_filters();
				foreach ($files as $file) {

					setup_table_variables($file);

					//εκτός long bets
					if ($special == 'long') {
						continue;
					}
					?>
					<?php for ($n = 1; $n <= $simeia; $n++) { ?>
						<?php if ($kleidomeno != null && $pass_lock == false) { ?>
							<tr>
								<td title="<?php echo $xora[$n] ?>" colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

									<a style="color:white" href="<?php echo $getlink_of_tip ?>">
										<?php echo $getname_of_tip ?>
									</a>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;

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

									<a style="color:white" href="<?php echo $getlink_of_tip ?>">
										<?php echo $getname_of_tip ?>
									</a>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;

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
								<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Αγορά</th>
								<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Προγνωστικό</th>
							</tr>
							<tr class="mobile-tr">
								<td colspan="6">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $agora[$n] ?>
										</strong></div>
								</td>
								<td colspan="6">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $tips[$n] ?>
										</strong></div>
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
										<a id="opn<?php echo $today ?>" onclick="w3.toggleShowTR('#clo<?php echo $today ?>');$('#btn<?php echo $today ?>').hide();resizeIframePostMessage();" style="display: inline-block;padding: 2px 6px;font-size: 9pt;text-align: center;border: 1px solid white;background: #000055;border-radius: 12px;cursor:pointer;">Ανάλυση &rarr; </a>
									<?php } ?>

								</th>
								<th nowrap colspan="1" style="width:16.6%"></th>
							</tr>
							<tr>
								<td class="desktop-td">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $agora[$n] ?>
										</strong></div>
								</td>
								<td class="desktop-td">
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $tips[$n] ?>
										</strong></div>
								</td>
								<td>
									<?php if ($n == $simeia) {
										?>
										<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
												<?php echo $posoA ?>
											</strong></div>
										<?php
									} ?>
								</td>
								<td nowrap>
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $apot[$n] ?>
										</strong></div>
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
		<h3>Picks History</h3>
		<div style="overflow-x: auto">
			<table class="staticstable-new" cellpadding="6" cellspacing="0">
				<?php
				$files = generate_history_bets_with_filters();
				foreach ($files as $file) {

					setup_table_variables($file);

					//εκτός long bets
					if ($special == 'long') {
						continue;
					}
					?>
					<?php for ($n = 1; $n <= $simeia; $n++) { ?>
						<tr>
							<td colspan="12" style="font-size:10pt;padding:9px 4px;color:white;text-align:left">

								<a style="color:white" href="<?php echo $getlink_of_tip ?>">
									<?php echo $getname_of_tip ?>
								</a>&nbsp;&nbsp;&nbsp;&#x27A3;&nbsp;&nbsp;&nbsp;

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
							<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Αγορά</th>
							<th nowrap colspan="6" style="font-size:10pt;font-weight: 100;">Προγνωστικό</th>
						</tr>
						<tr class="mobile-tr">
							<td colspan="6">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $agora[$n] ?>
									</strong></div>
							</td>
							<td colspan="6">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $tips[$n] ?>
									</strong></div>
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
									<a id="opn<?php echo $today ?>" onclick="w3.toggleShowTR('#clo<?php echo $today ?>');$('#btn<?php echo $today ?>').hide();resizeIframePostMessage();" style="display: inline-block;padding: 2px 6px;font-size: 9pt;text-align: center;border: 1px solid white;background: #000055;border-radius: 12px;cursor:pointer;">Ανάλυση &rarr; </a>
								<?php } ?>

							</th>
							<th nowrap colspan="1" style="width:16.6%"></th>
						</tr>
						<tr>
							<td class="desktop-td">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $agora[$n] ?>
									</strong></div>
							</td>
							<td class="desktop-td">
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $tips[$n] ?>
									</strong></div>
							</td>
							<td>
								<?php if ($n == $simeia) {
									?>
									<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
											<?php echo $posoA ?>
										</strong></div>
									<?php
								} ?>
							</td>
							<td nowrap>
								<div style="display:block;background:#000055;padding:6px;color:white;border: 3px solid gray;border-radius: 12px"><strong>
										<?php echo $apot[$n] ?>
									</strong></div>
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
				</tr>
			</table>
		</div>
		<br>

		<div class="pagination">
			<?php setup_pagination_variables(); ?>
			<a class="prev page-numbers" href="?u=<?php echo $userme ?>&min=<?php echo 0 ?>&max=<?php echo 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">&laquo;</a>
			<a class="page-numbers" href="?u=<?php echo $userme ?>&min=<?php echo $min - 10 ?>&max=<?php echo $max - 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">
				<?php echo $current_page - 1 ?>
			</a>
			<span class="page-numbers current">
				<?php echo $current_page; ?>
			</span>
			<a class="page-numbers" href="?u=<?php echo $userme ?>&min=<?php echo $min + 10 ?>&max=<?php echo $max + 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">
				<?php echo $current_page + 1 ?>
			</a>
			<a class="next page-numbers" href="?u=<?php echo $userme ?>&min=<?php echo $min + 10 ?>&max=<?php echo $max + 10 ?>&s=<?php echo $season_start ?>+-+<?php echo $season_end ?>">&raquo;</a>
		</div>
	</div>
</body>

</html>
