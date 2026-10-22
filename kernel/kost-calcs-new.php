<?php
/**
 * Created by PhpStorm
 * User: Andreas Express
 * Date: 9/8/17
 * Time: 4:14 PM
 */

//PROFIT
function count_user_profit($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}

	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {

		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/profit.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/profit.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$n = 0;
	$p = null;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$poso = str_replace('tips.txt', 'posoA.txt', $file);
		if (file_exists($file)) {
			$poso = trim(file_get_contents($poso));
		}

		$odds = str_replace('tips.txt', 'odds.txt', $file);
		if (file_exists($odds)) {
			$odds = trim(file_get_contents($odds));
		}

		$athlima = str_replace('tips.txt', 'athlima.txt', $file);
		if (file_exists($athlima)) {
			$athlima = trim(file_get_contents($athlima));
		}

		if (trim($athlima) != null) {

			if ($odds >= 1) {
				$odds = round($odds, 2);
			} else {
				$odds = 1;
			}

			if (file_exists(str_replace('tips.txt', 'Dodds.txt', $file))) {

				$Dodds = str_replace('tips.txt', 'Dodds.txt', $file);
				$Dodds = trim(file_get_contents($Dodds));
				if ($Dodds >= 1) {

					$Dodds = round($Dodds, 2);
				} else {
					$Dodds = 1;
				}
			} else {
				$Dodds = 1;
			}

			if (file_exists(str_replace('tips.txt', 'Todds.txt', $file))) {

				$Todds = str_replace('tips.txt', 'Todds.txt', $file);
				$Todds = trim(file_get_contents($Todds));
				if ($Todds >= 1) {

					$Todds = round($Todds, 2);
				} else {
					$Todds = 1;
				}
			} else {
				$Todds = 1;
			}

			//FILTER FOR DRAW AND CANCEL
			if ($wins == 'DRAW') {
				$odds = 1;
			} elseif ($wins == 'CANCELLED') {
				$odds = 1;
			}
			if ($Dwins == 'DRAW') {
				$Dodds = 1;
			} elseif ($Dwins == 'CANCELLED') {
				$Dodds = 1;
			}
			if ($Twins == 'DRAW') {
				$Todds = 1;
			} elseif ($Twins == 'CANCELLED') {
				$Todds = 1;
			}

			//FILTER FOR HALF WIN
			if ($wins == 'HALF WIN') {
				$odds = $odds - 1;
				$odds = $odds / 2;
				$odds = $odds + 1;
			}
			if ($Dwins == 'HALF WIN') {
				$Dodds = $Dodds - 1;
				$Dodds = $Dodds / 2;
				$Dodds = $Dodds + 1;
			}
			if ($Twins == 'HALF WIN') {
				$Todds = $Todds - 1;
				$Todds = $Todds / 2;
				$Todds = $Todds + 1;
			}

			//τι συμβαίνει με το profit οταν έστω και ένα προγνωστικό χάσει..
			if ($wins == "LOSE" or $Dwins == 'LOSE' or $Twins == 'LOSE') {

				$n = $n - $poso;
			}

			//τι συμβαίνει με το profit οταν έστω και ένα προγνωστικό χάσει..
			elseif ($wins == "HALF LOSE" or $Dwins == 'HALF LOSE' or $Twins == 'HALF LOSE') {

				$n = $n - $poso / 2;
			} else {

				$n = $n + $odds * $Dodds * $Todds * $poso - $poso;
			}
		}
	}

	return $p . round($n + $k, 0);
}

//YIELD (PERCENT)
//Yield: με τον τύπο  [profit/stake * 100]  - Παράδειγμα: Έστω ότι ποντάρω 38 σημεία, με 20 μονάδες το καθένα, σε απόδοση 1.25. Άρα το συνολικό μου ποντάρισμα είναι 38x20 = 760. Αν κερδίσω τα 33 από αυτά, θα έχω καθαρό κέρδος 65 μονάδες. Οπότε θα έχω 65/760 = 0.0855 = 8.55% yield
function count_user_yield($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	//ΔΕΝ ΕΧΕΙ ΕΠΕΞΕΡΓΑΣΙΑ ΕΠΕΙΔΉ ΑΠΟΤΕΛΕΙΤΑΙ ΑΠΟ 2 ΑΛΛΑ ΠΡΩΤΟΓΕΝΗ ΣΤΑΤΙΣΤΙΚΑ
	if ($userme == false) {
		global $userme;
	}
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);
	}

	$m = 0; //sinolika ponarismata
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$poso = str_replace('tips.txt', 'posoA.txt', $file);
		if (file_exists($poso)) {
			$poso = trim(file_get_contents($poso));
		}

		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//EPISTROFES (KERDH KAI PONTARISMATA)
			if ($wins == "WIN" or $Dwins == 'WIN' or $Twins == 'WIN') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} elseif ($wins == "HALF WIN" or $Dwins == 'HALF WIN' or $Twins == 'HALF WIN') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} elseif ($wins == "LOSE" or $Dwins == 'LOSE' or $Twins == 'LOSE') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} elseif ($wins == "HALF LOSE" or $Dwins == 'HALF LOSE' or $Twins == 'HALF LOSE') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} else {
				$m = $m + $poso;
			}
		}
	}
	$n = count_user_profit($year, $month, $today, $files, $userme);
	if ($m != 0) {

		$r = $n / $m;
		$var = number_format($r * 100, 2);
		$var = floatval($var);
		$var = str_replace(',', '', $var);
		return $var;
	} else {

		return 0;
	}
}

function count_user_stake($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/stake.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/stake.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$m = 0; //sinolika ponarismata
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$poso = str_replace('tips.txt', 'posoA.txt', $file);
		$poso = trim(file_get_contents($poso));
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//EPISTROFES (KERDH KAI PONTARISMATA)
			if ($wins == "WIN" or $Dwins == 'WIN' or $Twins == 'WIN') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} elseif ($wins == "HALF WIN" or $Dwins == 'HALF WIN' or $Twins == 'HALF WIN') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} elseif ($wins == "LOSE" or $Dwins == 'LOSE' or $Twins == 'LOSE') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} elseif ($wins == "HALF LOSE" or $Dwins == 'HALF LOSE' or $Twins == 'HALF LOSE') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
			} else {
				$m = $m + $poso;
			}
		}
	}
	return $m + $k;
}

//AVERAGE ODDS
function call_user_average_odds($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	//ΔΕΝ ΕΧΕΙ ΕΠΕΞΕΡΓΑΣΙΑ ΕΠΕΙΔΉ ΑΠΟΤΕΛΕΙΤΑΙ ΑΠΟ 2 ΑΛΛΑ ΠΡΩΤΟΓΕΝΗ ΣΤΑΤΙΣΤΙΚΑ
	if ($userme == false) {
		global $userme;
	}
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);
	}

	$i = 0;
	$n = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		if (file_exists(str_replace('tips.txt', 'odds.txt', $file))) {

			$odds = str_replace('tips.txt', 'odds.txt', $file);
			$odds = trim(file_get_contents($odds));
		} else {
			$odds = 1;
		}
		if (file_exists(str_replace('tips.txt', 'Dodds.txt', $file))) {
			$Dodds = str_replace('tips.txt', 'Dodds.txt', $file);
			$Dodds = trim(file_get_contents($Dodds));
		} else {
			$Dodds = 1;
		}
		if (file_exists(str_replace('tips.txt', 'Todds.txt', $file))) {
			$Todds = str_replace('tips.txt', 'Todds.txt', $file);
			$Todds = trim(file_get_contents($Todds));
		} {
			$Todds = 1;
		}

		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			if ($wins == "DRAW" or $Dwins == 'DRAW' or $Twins == 'DRAW') {
			} elseif ($wins == "CANCELLED" or $Dwins == 'CANCELLED' or $Twins == 'CANCELLED') {
			} else {

				$i++;
				$n = $n + $odds * $Dodds * $Todds;
			}
		}
	}

	if ($i != 0) {

		return number_format(($n / $i), 2);
	} else {

		return 0;
	}
}

//AVERAGE ODDS
function call_user_total_odds($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);
	}
	$n = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		if (file_exists(str_replace('tips.txt', 'odds.txt', $file))) {

			$odds = str_replace('tips.txt', 'odds.txt', $file);
			$odds = trim(file_get_contents($odds));
		} else {
			$odds = 1;
		}
		if (file_exists(str_replace('tips.txt', 'Dodds.txt', $file))) {
			$Dodds = str_replace('tips.txt', 'Dodds.txt', $file);
			$Dodds = trim(file_get_contents($Dodds));
		} else {
			$Dodds = 1;
		}
		if (file_exists(str_replace('tips.txt', 'Todds.txt', $file))) {
			$Todds = str_replace('tips.txt', 'Todds.txt', $file);
			$Todds = trim(file_get_contents($Todds));
		} {
			$Todds = 1;
		}

		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			if ($wins == "CANCELLED" or $Dwins == 'CANCELLED' or $Twins == 'CANCELLED') {
			} else {

				$n = $n + $odds * $Dodds * $Todds;
			}
		}
	}

	return $n;
}

//AVERAGE STAKE
function call_user_average_stake($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/average-stake.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/average-stake.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	$m = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$poso = str_replace('tips.txt', 'posoA.txt', $file);
		$poso = trim(file_get_contents($poso));
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//EPISTROFES (KERDH KAI PONTARISMATA)
			if ($wins == "WIN" or $Dwins == 'WIN' or $Twins == 'WIN') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
				$i++;
			} elseif ($wins == "HALF WIN" or $Dwins == 'HALF WIN' or $Twins == 'HALF WIN') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
				$i++;
			} elseif ($wins == "LOSE" or $Dwins == 'LOSE' or $Twins == 'LOSE') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
				$i++;
			} elseif ($wins == "HALF LOSE" or $Dwins == 'HALF LOSE' or $Twins == 'HALF LOSE') {

				//SINOLIKA PONTARISMATA
				$m = $m + $poso;
				$i++;
			} else {
				$m = $m + $poso;
				$i++;
			}
		}
	}

	if ($i != 0) {
		return number_format(($m / $i) + $k, 2);
	} else {
		return 0 + $k;
	}
}

//SUCCESS RATE (PERCENT) !!! DEPRECATED !!!
function call_user_success_rate($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	//ΔΕΝ ΕΧΕΙ ΕΠΕΞΕΡΓΑΣΙΑ ΕΠΕΙΔΉ ΑΠΟΤΕΛΕΙΤΑΙ ΑΠΟ 2 ΑΛΛΑ ΠΡΩΤΟΓΕΝΗ ΣΤΑΤΙΣΤΙΚΑ
	if ($userme == false) {
		global $userme;
	}
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);
	}

	$i = 0;
	$j = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//call_user_kerdismena PICK...
			if ($wins == "WIN" or $wins == "HALF WIN") {
				$i++;
			}
			if ($Dwins == "WIN" or $Dwins == "HALF WIN") {
				$i++;
			}
			if ($Twins == "WIN" or $Twins == "HALF WIN") {
				$i++;
			}

			//SINOLIKA PICK, OXI TA CANCELED
			if ($wins == "WIN" or $wins == "HALF WIN" or $wins == "DRAW" or $wins == 'LOSE' or $wins == 'HALF LOSE') {
				$j++;
			}
			if ($Dwins == "WIN" or $Dwins == "HALF WIN" or $Dwins == "DRAW" or $Dwins == 'LOSE' or $Dwins == 'HALF LOSE') {
				$j++;
			}
			if ($Twins == "WIN" or $Twins == "HALF WIN" or $Twins == "DRAW" or $Twins == 'LOSE' or $Twins == 'HALF LOSE') {
				$j++;
			}
		}
	}

	if ($j != 0) {

		$c = $i / $j * 100; //was $i/$j
		return number_format($c, 0);
	} else {

		return 0;
	}
}

//ALL IN ONE [NEW]
function count_user_stats_all($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);
	}

	$all_in_one = array();
	$files_fixed = array();
	foreach ($files as $file) {

		//ψάχνει το χρόνο-μήνα του προγνωστικού
		if ($month != null) {

			$minas = trim(file_get_contents(str_replace('tips.txt', 'minas.txt', $file)));
			$xronos = trim(file_get_contents(str_replace('tips.txt', 'xronos.txt', $file)));
			$xronosminas = $xronos . $minas;
		}

		//ψάχνει tips για ένα μήνα προγνωστικού, αν δεν υπάρχει τα ψάχνει όλα
		if ($xronosminas == $month or $month == null) {

			//να μην δείχνει τίποτα εαν δεν υπάρχει αθλημα
			$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
			if (trim($athlima) != null) {

				$files_fixed[] = $file;
			}
		}
	}

	$all_in_one['ola'] = call_user_records(null, null, null, $files_fixed, $userme);
	$all_in_one['success_rate'] = call_user_success_rate(null, null, null, $files_fixed, $userme);
	$all_in_one['profit'] = count_user_profit(null, null, null, $files_fixed, $userme);
	$all_in_one['yielder'] = count_user_yield(null, null, null, $files_fixed, $userme);
	$all_in_one['average_stake'] = call_user_average_stake(null, null, null, $files_fixed, $userme);
	$all_in_one['average_odds'] = call_user_average_odds(null, null, null, $files_fixed, $userme);
	return $all_in_one;
}

//WIN RATE (PERCENT) !!! DEPRECATED !!!
function call_user_win_rate($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/win-rate.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/win-rate.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	$j = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {

			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {

			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {

			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$cash = str_replace('tips.txt', 'cashout.txt', $file);
		$cash = trim(file_get_contents($cash));
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//TELIKO APOTELESMATA...
			if ($cash != null) {
				$i++; //theorite nikimeno ean exei cashout
			} elseif ($wins == "LOSE" or $Dwins == 'LOSE' or $Twins == 'LOSE') {
				$j++;
			} elseif ($wins == "HALF LOSE" or $Dwins == 'HALF LOSE' or $Twins == 'HALF LOSE') {
				$j++;
			} elseif ($wins == "WIN" or $Dwins == 'WIN' or $Twins == 'WIN') {
				$i++;
			} elseif ($wins == "HALF WIN" or $Dwins == 'HALF WIN' or $Twins == 'HALF WIN') {
				$i++;
			}
		}
	}
	$c = $i / ($i + $j) * 100;
	$c = $c + $k;
	return number_format($c, 0);
}



//CASHRATE (PERCENT)
function call_user_cash_rate($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);

	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/cash-rate.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/cash-rate.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	$j = 0;
	foreach ($files as $file) {

		$cash = str_replace('tips.txt', 'cashout.txt', $file);
		$cash = trim(file_get_contents($cash));
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//TELIKO APOTELESMATA...
			if ($cash != null) {
				$i++;
				$j = $j + $cash;
			}

			//FORMAT
			$j = round($j, 0);
		}
	}
	$var = "<span style=\"color:cornflowerblue;\">+" . $j + $k . " (" . $i . ")" . "</span>";
	return $var;
}

//call_user_kerdismena
function call_user_kerdismena($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);

	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/kerdismena.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/kerdismena.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {

			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {

			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {

			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//TELIKO APOTELESMATA...
			if ($wins == "WIN" or $wins == "HALF WIN") {
				$i++;
			}
			if ($Dwins == "WIN" or $Dwins == "HALF WIN") {
				$i++;
			}
			if ($Twins == "WIN" or $Twins == "HALF WIN") {
				$i++;
			}
		}
	}

	return $i + $k;
}

//count_user_epistramena
function count_user_epistramena($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/epistramena.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/epistramena.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {

			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {

			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {

			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}

		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//TELIKO APOTELESMATA...
			if ($wins == "DRAW" or $wins == "CANCELLED") {
				$i++;
			}
			if ($Dwins == "DRAW" or $Dwins == "CANCELLED") {
				$i++;
			}
			if ($Twins == "DRAW" or $Twins == "CANCELLED") {
				$i++;
			}
		}
	}

	return $i + $k;
}

//VOID
function count_user_draws($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);

	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/draws.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/draws.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//TELIKO APOTELESMATA...
			if ($wins == "DRAW") {
				$i++;
			}
			if ($Dwins == "DRAW") {
				$i++;
			}
			if ($Twins == "DRAW") {
				$i++;
			}
		}
	}

	return $i + $k;
}

//XAMENA
function count_user_xamena($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$k = 0;
	$ks = array();
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);

	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΑΝΑ ΜΗΝΑ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/$month/xamena.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);

	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);

		//ΕΠΕΞΕΡΓΑΣΙΑ ΟΛΩΝ
		$mds = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/stats/*/xamena.txt");
		foreach ($mds as $md) {

			$ks[] = floatval(file_get_contents($md));
		}
		$k = array_sum($ks);
	}

	$i = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//TELIKO APOTELESMATA...
			if ($wins == "LOSE" or $wins == "HALF LOSE") {
				$i++;
			}
			if ($Dwins == "LOSE" or $Dwins == "HALF LOSE") {
				$i++;
			}
			if ($Twins == "LOSE" or $Twins == "HALF LOSE") {
				$i++;
			}
		}
	}

	return $i + $k;
}

//OLA TA PROGNOSTIKA, TA PAROLI METROIONTAI KSEXORISTA
function count_user_records_previous($year = null, $month = null, $today = null, $files = false, $userme = false)
{
	$k = call_user_kerdismena($year, $month, false, $files, $userme);
	$x = count_user_xamena($year, $month, false, $files, $userme);
	$e = count_user_draws($year, $month, false, $files, $userme);
	$sum = $k + $x + $e;
	return $sum;
}

function generate_all_packs_from_tip_minas($monlink, $userme = false)
{

	if ($userme == false) {

		global $userme;
	}

	//call all tips
	$packs = array();
	$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
	$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$files = array_merge($files_1, $files_2);
	foreach ($files as $file) {

		//get month from the monlink
		$mon = substr($monlink, -2);
		$mon = intval($mon);

		//get year of the monlink
		$Y = substr($monlink, 0, 4);
		$Y = intval($Y);

		$minas = str_replace('tips.txt', 'minas.txt', $file);
		$minas = trim(file_get_contents($minas));
		$minas = intval($minas);

		$xronos = str_replace('tips.txt', 'xronos.txt', $file);
		$xronos = trim(file_get_contents($xronos));
		$xronos = intval($xronos);

		if ($minas == $mon && $xronos == $Y) {

			$packs[] = $file;
		}
	}

	return $packs;
}

//OLA TA PROGNOSTIKA, FAST MODE
function call_user_records($year = null, $month = null, $today = null, $files = false, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	if ($today != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($month != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$month/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$month*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif ($year != null) {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$year*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$year*/tips.txt");
		$files = array_merge($files_1, $files_2);
	} elseif (is_array($files)) {
	} else {
		$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
		$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
		$files = array_merge($files_1, $files_2);
	}

	$j = 0;
	foreach ($files as $file) {

		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			$wins = str_replace('tips.txt', 'wdl.1.txt', $file);
			$wins = trim(file_get_contents($wins));
		} else {
			$wins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.2.txt', $file))) {
			$Dwins = str_replace('tips.txt', 'wdl.2.txt', $file);
			$Dwins = trim(file_get_contents($Dwins));
		} else {
			$Dwins = null;
		}
		if (file_exists(str_replace('tips.txt', 'wdl.3.txt', $file))) {
			$Twins = str_replace('tips.txt', 'wdl.3.txt', $file);
			$Twins = trim(file_get_contents($Twins));
		} else {
			$Twins = null;
		}
		$athlima = trim(file_get_contents(str_replace('tips.txt', 'athlima.txt', $file)));
		if (trim($athlima) != null) {

			//SINOLIKA PICK, OXI TA CANCELED
			if ($wins == "WIN" or $wins == "HALF WIN" or $wins == "DRAW" or $wins == 'LOSE' or $wins == 'HALF LOSE') {
				$j++;
			}
			if ($Dwins == "WIN" or $Dwins == "HALF WIN" or $Dwins == "DRAW" or $Dwins == 'LOSE' or $Dwins == 'HALF LOSE') {
				$j++;
			}
			if ($Twins == "WIN" or $Twins == "HALF WIN" or $Twins == "DRAW" or $Twins == 'LOSE' or $Twins == 'HALF LOSE') {
				$j++;
			}
		}
	}
	return $j;
}

//APOTELESMATA
function format_tip_apot($poso, $odds, $mode)
{

	if ($mode == "LOSE") {
		return "-" . $poso;
	} elseif ($mode == "HALF LOSE") {
		return "-" . $poso;
	} elseif ($mode == "WIN") {
		return "+" . $odds * $poso - $poso;
	} elseif ($mode == "HALF WIN") {
		$odds = $odds / 2;
		return "+" . $odds * $poso - $poso;
	} else {
		return "-";
	}
}

//PICKS
function count_user_records_previous_2($userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$b_count = 0;
	$bs_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/mera.txt");
	$bs_2 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/Dmera.txt");
	$bs_3 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/Tmera.txt");
	$bs_4 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/Rmera.txt");
	foreach ($bs_1 as $b) {

		if (file_get_contents($b) != null) {
			$b_count++;
		}
	}
	foreach ($bs_2 as $b) {

		if (file_get_contents($b) != null) {
			$b_count++;
		}
	}
	foreach ($bs_3 as $b) {

		if (file_get_contents($b) != null) {
			$b_count++;
		}
	}
	foreach ($bs_4 as $b) {

		if (file_get_contents($b) != null) {
			$b_count++;
		}
	}
	return $b_count;
}

//BETS
function count_user_records($year = null, $month = null, $userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/*/tips.txt");
	$files_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$files = array_merge($files_1, $files_2);
	$i = 0;
	foreach ($files as $files) {
		$i++;
	}
	return $i;
}

function count_user_tips($userme = false)
{

	if ($userme == false) {
		global $userme;
	}
	$files = glob_keep_only_open_tips($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/tips.txt");
	foreach ($files as $file) {

		$i++;
	}
	return $i;
}

function count_user_records_and_tips($userme = false)
{
	return count_user_tips($userme) + count_user_records($userme);
}

?>