<?php
/**
 * Created by PhpStorm
 * User: User
 * Date: 24/10/2019
 * Time: 5:07 μμ
 */

//functions for statistics
function sort_tips_by_date_and_time($files)
{

	$prognostika = array();
	foreach ($files as $filename) {

		$d = str_replace('tips.txt', 'mera.txt', $filename);
		$m = str_replace('tips.txt', 'minas.txt', $filename);
		$Y = str_replace('tips.txt', 'xronos.txt', $filename);
		$h = str_replace('tips.txt', 'ora.txt', $filename);
		$s = str_replace('tips.txt', 'lepta.txt', $filename);
		$d = file_get_contents($d);
		$m = file_get_contents($m);
		$Y = file_get_contents($Y);
		$h = file_get_contents($h);
		$s = file_get_contents($s);

		//protereotita megalitero --> mikrotero
		$proter = $Y . $m . $d . $h . $s;

		//we add rand numbers to replace and h and s values
		$proter = $proter . rand(11, 99);

		//MAKE AN ARRAY OF DATETIME(PROTER) AND FILENAME(WITH PAT)
		$prognostika[$proter] = $filename;
	}
	krsort($prognostika);
	return $prognostika;
}

function call_tips_by_date_and_time($glob_pattern)
{

	$files = glob_keep_only_open_tips($glob_pattern);
	$prognostika = sort_tips_by_date_and_time($files);
	return $prognostika;
}

function monlink_step($monlink_input)
{

	$m = substr($monlink_input, -2);
	$y = substr($monlink_input, 0, 4);
	if ($m < 9) {

		$m = $m + 1;
		$m = "0" . $m;
	} elseif ($m < 12) {

		$m = $m + 1;
	} else {

		$y = $y + 1;
		$m = "01";
	}
	return $y . $m;
}

function glob_keep_only_records($pattern)
{

	$array = array();
	$files = glob($pattern);
	foreach ($files as $file) {

		$check = str_replace('tips.txt', 'wdl.1.txt', $file);

		//an den exei wdl oti syminei anoixto kai etsi prepei na min to metraei
		if (!file_exists($check)) {
			continue;
		}

		$array[] = $file;
	}
	return $array;
}

function glob_keep_only_open_tips($pattern)
{

	$array = array();
	$files = glob($pattern);
	foreach ($files as $file) {

		//an exei wdl oti syminei einai kleisto kai den to metraei
		if (file_exists(str_replace('tips.txt', 'wdl.1.txt', $file))) {
			continue;
		}

		$array[] = $file;
	}
	return $array;
}

function call_records_by_season($monlink_start, $monlink_end)
{

	global $userme;
	$monlink = $monlink_start;
	$prognostika = array();
	while ($monlink <= $monlink_end) {

		$prognostika_prin = $prognostika;
		$prognostika_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$monlink/*/tips.txt");
		$prognostika_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$monlink*/tips.txt");
		$prognostika = array_merge($prognostika_1, $prognostika_2);
		$prognostika = array_merge((array) $prognostika_prin, (array) $prognostika);

		//go one step further..
		$monlink = monlink_step($monlink);
	}

	$prognostika = array_unique($prognostika);
	$prognostika = sort_tips_by_date_and_time($prognostika);
	return $prognostika;
}

function call_records_by_season_and_company($monlink_start, $monlink_end, $company)
{

	global $userme;
	$monlink = $monlink_start;
	$prognostika = array();
	$prognostika_new = array();
	while ($monlink <= $monlink_end) {

		$prognostika_prin = $prognostika;
		$prognostika_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$monlink/*/tips.txt");
		$prognostika_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$monlink*/tips.txt");
		$prognostika = array_merge($prognostika_1, $prognostika_2);
		foreach ($prognostika as $filename) {

			$book = file_get_contents(str_replace("tips.txt", "book.txt", $filename));
			$book = explode("**", $book);
			if (array_key_exists(2, $book)) {
				$booktext = $book[2];
			} else {
				$booktext = null;
			}

			if ($booktext == $company) {

				array_push($prognostika_new, $filename);
			}
		}

		$prognostika = $prognostika_new;
		$prognostika = array_merge((array) $prognostika_prin, (array) $prognostika);

		//go one step further..
		$monlink = monlink_step($monlink);
	}

	$prognostika = array_unique($prognostika);

	//but fix, pack of files must not null
	if (count($prognostika) == 0) {

		$prognostika = array();
	}

	//print_r($prognostika);
	return $prognostika;
}

function call_records_by_season_and_athlima($monlink_start, $monlink_end, $athlima)
{

	global $userme;
	$athlima = trim($athlima);
	$monlink = $monlink_start;
	$prognostika = array();
	$prognostika_new = array();
	while ($monlink <= $monlink_end) {

		$prognostika_prin = $prognostika;
		$prognostika_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$monlink/*/tips.txt");
		$prognostika_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$monlink*/tips.txt");
		$prognostika = array_merge($prognostika_1, $prognostika_2);
		foreach ($prognostika as $filename) {

			$athlimatext = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
			$athlimatext = trim($athlimatext);
			if ($athlimatext == $athlima) {

				array_push($prognostika_new, $filename);
			}
		}
		$prognostika = $prognostika_new;
		$prognostika = array_merge((array) $prognostika_prin, (array) $prognostika);
		$monlink = monlink_step($monlink);
	}

	$prognostika = array_unique($prognostika);
	if (count($prognostika) == 0) {

		$prognostika = array();
	}
	return $prognostika;
}

function precall_records_by_season($monlink_start, $monlink_end)
{

	global $userme;

	$monlink = $monlink_start;
	$prognostika = array();
	$aths = array();
	$xors = array();
	$prots = array();
	$agors = array();
	$posa = array();
	$specials = array();
	$prognostika_new = array();
	while ($monlink <= $monlink_end) {

		$prognostika_prin = $prognostika;
		$prognostika_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/$monlink/*/tips.txt");
		$prognostika_2 = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$monlink*/tips.txt");
		$prognostika = array_merge($prognostika_1, $prognostika_2);
		foreach ($prognostika as $filename) {

			if (str_replace("tips.txt", "athlima.txt", $filename)) {
				$ath = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
			} else {
				continue;
			}

			$xor = file_get_contents(str_replace("tips.txt", "xora.txt", $filename));
			$prot = file_get_contents(str_replace("tips.txt", "protathlima.txt", $filename));
			$agor = file_get_contents(str_replace("tips.txt", "agora.txt", $filename));
			$poso = file_get_contents(str_replace("tips.txt", "posoA.txt", $filename));
			if (file_exists(str_replace("tips.txt", "specialset.txt", $filename))) {
				$special = file_get_contents(str_replace("tips.txt", "specialset.txt", $filename));
			} else {
				$special = null;
			}

			array_push($prognostika_new, $filename);

			//MAKE PRE CALLS
			$today = basename(dirname($filename));
			$ath = trim($ath);
			$xor = trim($xor);
			$prot = trim($prot);
			$poso = trim($poso);
			$aths[$today] = $ath;
			$xors[$today] = $xor;
			$prots[$today] = $prot;
			$agors[$today] = $agor;
			$posa[$today] = $poso;
			$specials[$today] = $special;
		}

		if (isset($ath)) {
			$prognostika = $prognostika_new;
		}

		$prognostika = array_merge((array) $prognostika_prin, (array) $prognostika);

		//go one step further..
		$monlink = monlink_step($monlink);
	}

	$prognostika = array_unique($prognostika);

	//but fix, pack of files must not null
	if (count($prognostika) == 0) {

		$prognostika = array();
	}

	define('ATHS_FROM_PRECALL', $aths);
	define('XORS_FROM_PRECALL', $xors);
	define('PROTS_FROM_PRECALL', $prots);
	define('AGORS_FROM_PRECALL', $agors);
	define('POSA_FROM_PRECALL', $posa);
	define('SPECIALBETS_FROM_PRECALL', $specials);
	define('PACKS_FROM_PRECALL', $prognostika);
}

function call_records_by_season_and_protathlima($monlink_start, $monlink_end, $athlima, $xora, $protathlima)
{

	global $userme;

	if (!defined('PACKS_FROM_PRECALL')) {

		precall_records_by_season($monlink_start, $monlink_end);
	}

	$aths = ATHS_FROM_PRECALL;
	$xors = XORS_FROM_PRECALL;
	$prots = PROTS_FROM_PRECALL;
	$prognostika = array();
	$prognostikapack = PACKS_FROM_PRECALL;

	foreach ($prognostikapack as $filename) {

		$today = basename(dirname($filename));
		$ath = $aths[$today];
		$xor = $xors[$today];
		$prot = $prots[$today];

		if ($ath == $athlima && $xor == $xora && $prot == $protathlima) {

			array_push($prognostika, $filename);
		}
	}

	$prognostika = array_unique($prognostika);

	//but fix, pack of files must not null
	if (count($prognostika) == 0) {

		$prognostika = array();
	}

	//print_r($prognostika);
	return $prognostika;
}

function call_records_by_season_and_agora($monlink_start, $monlink_end, $athlima, $agora)
{

	global $userme;

	if (!defined('PACKS_FROM_PRECALL')) {

		precall_records_by_season($monlink_start, $monlink_end);
	}

	$aths = ATHS_FROM_PRECALL;
	$agors = AGORS_FROM_PRECALL;
	$prognostika = array();
	$prognostikapack = PACKS_FROM_PRECALL;

	foreach ($prognostikapack as $filename) {

		$today = basename(dirname($filename));
		$ath = $aths[$today];
		$agor = $agors[$today];

		if ($ath == $athlima && $agor == $agora) {

			array_push($prognostika, $filename);
		}
	}

	$prognostika = array_unique($prognostika);

	//but fix, pack of files must not null
	if (count($prognostika) == 0) {

		$prognostika = array();
	}

	//print_r($prognostika);
	return $prognostika;
}

function call_records_by_season_and_pontarisma($monlink_start, $monlink_end, $start, $end)
{

	global $userme;

	if (!defined('PACKS_FROM_PRECALL')) {

		precall_records_by_season($monlink_start, $monlink_end);
	}

	$posa = POSA_FROM_PRECALL;
	$prognostika = array();
	$prognostikapack = PACKS_FROM_PRECALL;

	foreach ($prognostikapack as $filename) {

		$today = basename(dirname($filename));
		$poso = $posa[$today];

		if ($poso >= $start && $poso <= $end) {

			array_push($prognostika, $filename);
		}
	}

	$prognostika = array_unique($prognostika);

	//but fix, pack of files must not null
	if (count($prognostika) == 0) {

		$prognostika = array();
	}

	//print_r($prognostika);
	return $prognostika;
}

function call_records_by_season_and_live_long($monlink_start, $monlink_end, $live_or_long)
{

	global $userme;

	if (!defined('PACKS_FROM_PRECALL')) {

		precall_records_by_season($monlink_start, $monlink_end);
	}

	$specials = SPECIALBETS_FROM_PRECALL;
	$prognostika = array();
	$prognostikapack = PACKS_FROM_PRECALL;

	foreach ($prognostikapack as $filename) {

		$today = basename(dirname($filename));
		$special = $specials[$today];

		if ($live_or_long == false) {

			if ($special == null) {

				array_push($prognostika, $filename);
			}
		} else {

			if ($special == $live_or_long && $special != null) {

				array_push($prognostika, $filename);
			}
		}
	}

	$prognostika = array_unique($prognostika);

	//but fix, pack of files must not null
	if (count($prognostika) == 0) {

		$prognostika = array();
	}

	//print_r($prognostika);
	return $prognostika;
}

function call_records_by_season_front_page($monlink_start, $monlink_end)
{

	$monlink = $monlink_start;
	$prognostika = array();
	while ($monlink <= $monlink_end) {

		$prognostika_prin = $prognostika;
		$prognostika = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*/records/$monlink/*/tips.txt");
		$prognostika = glob_keep_only_records($_SERVER['DOCUMENT_ROOT'] . "/users/*/tips/$monlink*/tips.txt");
		$prognostika = array_merge((array) $prognostika_prin, (array) $prognostika);

		//go one step further..
		$monlink = monlink_step($monlink);
	}

	$prognostika = array_unique($prognostika);
	$prognostika = sort_tips_by_date_and_time($prognostika);
	return $prognostika;
}

function monlink_to_month($monlink)
{

	$date = substr($monlink, -2);
	$date = str_replace('01', 'January', $date);
	$date = str_replace('02', 'February', $date);
	$date = str_replace('03', 'March', $date);
	$date = str_replace('04', 'April', $date);
	$date = str_replace('05', 'May', $date);
	$date = str_replace('06', 'June', $date);
	$date = str_replace('07', 'July', $date);
	$date = str_replace('08', 'August', $date);
	$date = str_replace('09', 'September', $date);
	$date = str_replace('10', 'October', $date);
	$date = str_replace('11', 'November', $date);
	$date = str_replace('12', 'December', $date);
	return $date;
}

?>