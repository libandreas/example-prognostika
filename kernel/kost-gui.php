<?php

//settings
function call_users_without_live_and_long()
{

	return array("gold", "dinner", "johnny");
}

//today tips
function generate_open_bets_no_special()
{

	global $userme;
	global $i;
	$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$pack = array();
	$i = 0;
	foreach ($files as $filename) {

		//συμαντικό, αν δεν είναι long ή live να το περναέι μόνο
		if (file_exists(str_replace("tips.txt", "specialset.txt", $filename)) && file_get_contents(str_replace("tips.txt", "specialset.txt", $filename)) != null) {
			continue;
		}

		$i++;

		//todo: στο μέλλων θα υπάρχει ένα φίλτρο εδώ για να ξεχωρίζουν τα ενεργά από το ιστορικό

		//πλέων είναι όλα σε ένα
		$pack[] = $filename;
	}
	return $pack;
}

//live bets
function generate_live_bets()
{

	global $userme;
	global $i;
	global $min;
	global $max;
	global $season_start;
	global $season_end;
	$files_1 = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$files_2 = call_records_by_season($season_start, $season_end);
	$files = array_merge($files_1, $files_2);
	$pack = array();
	$i = 0;

	//selides
	setup_pagination_variables('lv');
	foreach ($files as $filename) {

		if (file_exists(str_replace("tips.txt", "specialset.txt", $filename)) && file_get_contents(str_replace("tips.txt", "specialset.txt", $filename)) == 'live') {
		} else {

			continue;
		}

		$i++;

		//todo: στο μέλλων θα υπάρχει ένα φίλτρο εδώ για να ξεχωρίζουν τα ενεργά από το ιστορικό

		//start
		if ($i > $min) {

			$pack[] = $filename;
		}

		//break
		if ($i >= $max) {

			break;
		}
	}
	return $pack;
}

//long term bets
function generate_long_term_bets()
{

	global $userme;
	global $i;
	global $min;
	global $max;
	global $season_start;
	global $season_end;
	$files_1 = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$files_2 = call_records_by_season($season_start, $season_end);
	$files = array_merge($files_1, $files_2);
	$pack = array();
	$i = 0;

	//selides
	setup_pagination_variables('lg');
	foreach ($files as $filename) {

		if (file_exists(str_replace("tips.txt", "specialset.txt", $filename)) && file_get_contents(str_replace("tips.txt", "specialset.txt", $filename)) == 'long') {
		} else {

			continue;
		}

		$i++;

		//todo: στο μέλλων θα υπάρχει ένα φίλτρο εδώ για να ξεχωρίζουν τα ενεργά από το ιστορικό

		//start
		if ($i > $min) {

			$pack[] = $filename;
		}

		//break
		if ($i >= $max) {

			break;
		}
	}
	return $pack;
}

function generate_open_bets()
{

	global $userme;
	global $i;
	$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$pack = array();
	$i = 0;
	foreach ($files as $filename) {

		$i++;

		//todo: στο μέλλων θα υπάρχει ένα φίλτρο εδώ για να ξεχωρίζουν τα ενεργά από το ιστορικό

		//πλέων είναι όλα σε ένα
		$pack[] = $filename;
	}
	return $pack;
}

function generate_open_bets_with_filters()
{

	global $i;
	global $athlima;
	global $xora;

	//sort tips by datetime
	$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/*/tips/*/tips.txt"); //cross users
	$pack = array();
	$i = 0;
	foreach ($files as $filename) {

		$athlima = array(1 => null, 2 => null, 3 => null);
		$athlima[1] = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
		$athlima[1] = trim($athlima[1]);
		$xora = array(1 => '-', 2 => '-', 3 => '-');
		$xora[1] = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
		$xora[1] = trim($xora[1]);

		//apply filters
		if (isset($_GET['athlima']) && $_GET['athlima'] != null) {

			if (isset($_GET['xora']) && $_GET['xora'] != null) {

				if ($_GET['athlima'] == $athlima[1] && $_GET['xora'] == $xora[1]) {

					//πλέων είναι όλα σε ένα
					$pack[] = $filename;
				}
			} else {
				if (isset($_GET['athlima']) && $_GET['athlima'] == $athlima[1]) {

					//πλέων είναι όλα σε ένα
					$pack[] = $filename;
				}
			}
		} else {

			//πλέων είναι όλα σε ένα
			$pack[] = $filename;
		}
	}
	return $pack;
}

function generate_open_bets_for_apotelesmata()
{

	global $userme;
	$files = glob_keep_only_open_tips($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$pack = array();
	rsort($files);
	foreach ($files as $filename) {

		$pack[] = $filename;
	}
	return $pack;
}

//history
function generate_history_bets() //was show
{
	global $season_start;
	global $season_end;
	global $pack;
	global $files;
	global $i;

	//min max limits
	$i = 0;
	global $min;
	global $max;

	//selides
	setup_pagination_variables();

	//include records
	$pack = array();
	$files = call_records_by_season($season_start, $season_end);
	foreach ($files as $filename) {

		$i++;

		//start
		if ($i > $min) {

			$pack[] = $filename;
		}

		//break
		if ($i >= $max) {

			break;
		}
	}
	return $pack;
}

//history
function generate_history_bets_no_special() //was show
{
	global $season_start;
	global $season_end;
	global $pack;
	global $files;
	global $i;

	//min max limits
	$i = 0;
	global $min;
	global $max;

	//selides
	setup_pagination_variables();

	//include records
	$pack = array();
	$files = call_records_by_season($season_start, $season_end);
	foreach ($files as $filename) {

		if (file_exists(str_replace("tips.txt", "specialset.txt", $filename)) && file_get_contents(str_replace("tips.txt", "specialset.txt", $filename)) != null) {
			continue;
		}

		$i++;

		//start
		if ($i > $min) {

			$pack[] = $filename;
		}

		//break
		if ($i >= $max) {

			break;
		}


	}
	return $pack;
}

function generate_history_bets_with_filters()
{

	global $season_start;
	global $season_end;
	global $athlima;
	global $min;
	global $max;
	global $i;

	//SELIDES
	setup_pagination_variables();
	$i = 0;

	//INCLUDE RECORDS
	$pack = array();
	$files = call_records_by_season_front_page($season_start, $season_end);
	foreach ($files as $filename) {

		$athlima = array(1 => null, 2 => null, 3 => null);
		$athlima[1] = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
		$athlima[1] = trim($athlima[1]);
		$xora = array(1 => '-', 2 => '-', 3 => '-');
		$xora[1] = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
		$xora[1] = trim($xora[1]);

		if (isset($_GET['athlima']) && $_GET['athlima'] != null) {
			if ($_GET['athlima'] == $athlima[1]) {
				if ($i >= $min) {

					$pack[] = $filename;
				}
				$i++;
			}
		} else {

			if ($i >= $min) {

				$pack[] = $filename;
			}
			$i++;
		}
		if ($i > $max) {

			break;
		}
	}
	return $pack;
}

//count tips
function count_live_bets($userme)
{

	$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$lb = 0;
	foreach ($files as $filename) {
		$special = str_replace('tips.txt', 'specialset.txt', $filename);
		if (file_get_contents_or_null($special) == 'live') {
			$lb++;
		}
	}
	return $lb;
}

function count_open_bets()
{

	global $userme;
	$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	$i = 0;
	foreach ($files as $filename) {

		$i++;
	}
	return $i;
}

function count_long_term_bets($userme)
{

	$ltb = 0;
	$files = call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/*/tips.txt");
	foreach ($files as $filename) {
		$special = str_replace('tips.txt', 'specialset.txt', $filename);
		if (file_get_contents_or_null($special) == 'long') {
			$ltb++;
		}
	}
	return $ltb;
}

//statistics
function generate_overall_packs_with_key()
{

	global $season_start;
	global $season_end;
	global $overall_extra_data;
	$livelongs = array(false, 'live', 'long');
	$overall_packs_with_key = array();
	foreach ($livelongs as $livelong) {

		//make pack ana livelong
		$pack = call_records_by_season_and_live_long($season_start, $season_end, $livelong);

		//call picks from pack..
		if (is_array($pack) && count($pack) > 0) {

			$ola = call_user_records(false, false, false, $pack);
			$R = rand(10, 99); //rand must by same on both arrays
			$overall_packs_with_key[$ola . $R] = $pack;
			$overall_extra_data[$ola . $R] = $livelong;
		}
	}
	krsort($overall_packs_with_key);
	return $overall_packs_with_key;
}
function generate_eteries_packs_with_key()
{

	global $season_start;
	global $season_end;
	global $eteries_extra_data;
	$eteries_packs_with_key = array();
	$eteries = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/eteries/1/eteries.txt');
	foreach ($eteries as $book) {

		//load the company name
		$bookarray = explode("**", $book); //use $bookarray[2] for book name..

		//call the database of picks that include this company
		$pack = call_records_by_season_and_company($season_start, $season_end, $bookarray[2]);
		if (is_array($pack) && count($pack) > 0) {

			//call the picks with multiple picks
			$profit = count_user_profit(false, false, false, $pack);
			$R = rand(10, 99); //rand must by same on both arrays
			$eteries_packs_with_key[$profit . $R] = $pack;
			$eteries_extra_data[$profit . $R] = $bookarray[2];
		}
	}
	krsort($eteries_packs_with_key);
	return $eteries_packs_with_key;
}
function generate_sports_packs_with_key()
{

	global $season_start;
	global $season_end;
	global $sports_extra_data;
	$sports_packs_with_key = array();
	$athlimata = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/athlimata/1/athlimata.txt');
	foreach ($athlimata as $athlima) {

		//call the database of picks that include this company
		$pack = call_records_by_season_and_athlima($season_start, $season_end, $athlima);
		if (is_array($pack) && count($pack)) {

			//call the picks with multiple picks
			$profit = count_user_profit(false, false, false, $pack);
			$R = rand(10, 99);
			$sports_packs_with_key[$profit . $R] = $pack;
			$sports_extra_data[$profit . $R] = $athlima;
		}
	}
	krsort($sports_packs_with_key);
	return $sports_packs_with_key;
}
function generate_pontarismata_packs_with_key($pontarismata)
{

	//pontarismata
	global $season_start;
	global $season_end;
	global $pontarismata_extra_data;
	$pontarismata_packs_with_key = array();
	foreach ($pontarismata as $pontarisma) {

		//make pack ana pontarisma
		$pnt = explode('-', $pontarisma);
		$pack = call_records_by_season_and_pontarisma($season_start, $season_end, $pnt[0], $pnt[1]);
		if (is_array($pack) && count($pack) > 0) {

			//call picks from pack..
			$profit = count_user_profit(false, false, false, $pack);
			$R = rand(10, 99); //rand must by same on both arrays
			$pontarismata_packs_with_key[$profit . $R] = $pack;
			$pontarismata_extra_data[$profit . $R] = $pontarisma;
		}
	}
	return $pontarismata_packs_with_key;
}

//call protathlimata packs, by athlima and xora
function generate_leagues_pack_with_key()
{

	global $season_start;
	global $season_end;
	global $leagues_extra_data;
	$list = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/athlimata/1/athlimata.txt');
	$leagues_packs_with_key = array();
	foreach ($list as $athlima) {

		$athlima = trim($athlima);
		$list = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/xores/1/' . $athlima . '.txt');
		foreach ($list as $xora) {

			$xora = trim($xora);
			if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/users/global/protathlimata/1/' . $xora . '-' . $athlima . '.txt')) {
				$list = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/protathlimata/1/' . $xora . '-' . $athlima . '.txt');
			} else {
				$list = array();
			}

			foreach ($list as $prot) {

				//make pack ana protathlima
				$prot = trim($prot);
				$pack = call_records_by_season_and_protathlima($season_start, $season_end, $athlima, $xora, $prot);
				if (is_array($pack) && count($pack) > 0) {

					//call picks from pack..
					$R = rand(10, 99); //rand must by same on both arrays

					//taxinomhsh
					if (isset($_GET["tax"]) && $_GET["tax"] == "profit") {
						$t = count_user_profit(false, false, false, $pack);
						$leagues_packs_with_key[$t . $R] = $pack;
						$leagues_extra_data[$t . $R] = $athlima . '**' . $xora . '**' . $prot;
					} elseif (isset($_GET["tax"]) && $_GET["tax"] == "picks") {
						$ola = call_user_records(false, false, false, $pack);
						$leagues_packs_with_key[$ola . $R] = $pack;
						$leagues_extra_data[$ola . $R] = $athlima . '**' . $xora . '**' . $prot;
					} elseif (isset($_GET["tax"]) && $_GET["tax"] == "winrate") {
						$t = call_user_success_rate(false, false, false, $pack);
						$leagues_packs_with_key[$t . $R] = $pack;
						$leagues_extra_data[$t . $R] = $athlima . '**' . $xora . '**' . $prot;
					} elseif (isset($_GET["tax"]) && $_GET["tax"] == "yield") {
						$t = count_user_yield(false, false, false, $pack);
						$leagues_packs_with_key[$t . $R] = $pack;
						$leagues_extra_data[$t . $R] = $athlima . '**' . $xora . '**' . $prot;
					} elseif (isset($_GET["tax"]) && $_GET["tax"] == "avgodds") {
						$t = call_user_average_odds(false, false, false, $pack);
						$leagues_packs_with_key[$t . $R] = $pack;
						$leagues_extra_data[$t . $R] = $athlima . '**' . $xora . '**' . $prot;
					} else {
						$t = count_user_profit(false, false, false, $pack);
						$leagues_packs_with_key[$t . $R] = $pack;
						$leagues_extra_data[$t . $R] = $athlima . '**' . $xora . '**' . $prot;
					}
				}
			}
		}
	}

	//taxonomy list by lots of picks
	krsort($leagues_packs_with_key);

	//selidopoihsh
	global $min;
	global $max;
	setup_pagination_variables('lgs');
	$i = 0;
	$leagues_packs_with_key_new = array();

	//set 0 and 10 if not isset with leagues
	//if (!isset($_GET['leagues'])) {
	//	setup_pagination_variables_defaults();
	//}

	foreach ($leagues_packs_with_key as $k => $v) {

		if ($i >= $min && $i <= $max) {

			$leagues_packs_with_key_new[$k] = $v;
		}
		$i++;
	}

	return $leagues_packs_with_key_new;
}

//call markets packs, by agores
function generate_markets_pack_with_key()
{

	//call agores
	global $season_start;
	global $season_end;
	global $markets_extra_data;
	$list = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/athlimata/1/athlimata.txt');
	$markets_packs_with_key = array();
	foreach ($list as $athlima) {

		$athlima = trim($athlima);
		$list = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/agores/1/' . $athlima . '.txt');
		foreach ($list as $agora) {

			$agora = trim($agora);

			//make pack ana agora
			$pack = call_records_by_season_and_agora($season_start, $season_end, $athlima, $agora);
			if (is_array($pack) && count($pack) > 0) {

				//call picks from pack..
				$R = rand(10, 99); //rand must by same on both arrays

				//tax
				if (isset($_GET['tax']) && $_GET["tax"] == "profit") {
					$t = count_user_profit(false, false, false, $pack);
					$markets_packs_with_key[$t . $R] = $pack;
					$markets_extra_data[$t . $R] = $athlima . '**' . $agora;
				} elseif (isset($_GET['tax']) && $_GET["tax"] == "picks") {
					$ola = call_user_records(false, false, false, $pack);
					$markets_packs_with_key[$ola . $R] = $pack;
					$markets_extra_data[$ola . $R] = $athlima . '**' . $agora;
				} elseif (isset($_GET["tax"]) && $_GET["tax"] == "winrate") {
					$t = call_user_success_rate(false, false, false, $pack);
					$markets_packs_with_key[$t . $R] = $pack;
					$markets_extra_data[$t . $R] = $athlima . '**' . $agora;
				} elseif (isset($_GET["tax"]) && $_GET["tax"] == "yield") {
					$t = count_user_yield(false, false, false, $pack);
					$markets_packs_with_key[$t . $R] = $pack;
					$markets_extra_data[$t . $R] = $athlima . '**' . $agora;
				} elseif (isset($_GET["tax"]) && $_GET["tax"] == "avgodds") {
					$t = call_user_average_odds(false, false, false, $pack);
					$markets_packs_with_key[$t . $R] = $pack;
					$markets_extra_data[$t . $R] = $athlima . '**' . $agora;
				} else {
					$t = count_user_profit(false, false, false, $pack);
					$markets_packs_with_key[$t . $R] = $pack;
					$markets_extra_data[$t . $R] = $athlima . '**' . $agora;
				}
			}
		}
	}

	//taxonomy list by lots of picks
	krsort($markets_packs_with_key);

	//selidopoihsh
	global $min;
	global $max;
	setup_pagination_variables('mks');
	$i = 0;
	$markets_packs_with_key_new = array();

	//set 0 and 10 if not isset with markets
	//if (!isset($_GET['markets'])) {
	//	setup_pagination_variables_defaults();
	//}

	foreach ($markets_packs_with_key as $k => $v) {

		if ($i >= $min && $i <= $max) {

			$markets_packs_with_key_new[$k] = $v;
		}
		$i++;
	}

	return $markets_packs_with_key_new;
}

//others
//todo: να πάει μέσα στα αρχεία
function get_this_tipster_name()
{

	//get page name
	global $userme;
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/" . $userme . "/info/1/name.txt")) {

		$getname = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/" . $userme . "/info/1/name.txt");
	} else {
		$getname = $userme;
	}
	return $getname;
}

//todo: να πάει μέσα στα αρχεία
function get_this_tipster_url()
{

	global $userme;
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/info/1/url.txt")) {

		$getlink = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/info/1/url.txt");
	} else {

		$getlink = "/table/todaytips.php?u=" . $userme;
	}
	return $getlink;
}

//this is former php-todaytips.php
function push_todaytips_on_db()
{

	global $userme;

	//find today..
	if (isset($_POST['today']) or $_POST['today'] != null) {
		$today = $_POST['today'];
	} else {

		trigger_error('to today param found');
		return;
	}

	//MAKE DIRECTORY
	if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today")) {
		mkdir($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today", 0755, true);
	}

	//ENTRANCE IMPORTANT INFORMATION
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/feremina.txt", date("m"));
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/ferexrono.txt", date("Y"));
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/book.txt", $_POST["book"]);
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/put.txt", date("d, m, Y, G:i"));
	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/posoA.txt", $_POST['posoA']);

	//KLEIDOMENO
	if (isset($_POST["kleidomeno"])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/kleidomeno.txt", $_POST["kleidomeno"]);
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/kleidomeno.txt")) {
		unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/kleidomeno.txt");
	}

	//DESCRIPTION
	if (isset($_POST["per"])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/per.txt", $_POST["per"]);
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/per.txt")) {
		unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/per.txt");
	}

	//AGORA
	if (isset($_POST['agora'])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/agora.txt", str_replace('_', ' ', $_POST["agora"]));
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/agora.txt")) {
		unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/agora.txt");
	}

	//AGORA 2
	if (isset($_POST['Dagora'])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dagora.txt", str_replace('_', ' ', $_POST["Dagora"]));
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dagora.txt")) {
		unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dagora.txt");
	}

	//AGORA 3
	if (isset($_POST['Tagora'])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tagora.txt", str_replace('_', ' ', $_POST["Tagora"]));
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tagora.txt")) {
		unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tagora.txt");
	}

	//SPECIAL
	if (isset($_POST["specialset"])) {
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/specialset.txt", $_POST["specialset"]);
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/specialset.txt")) {
		unlink($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/specialset.txt");
	}

	//RECORD DATA 1 FIRST MATCH
	if (isset($_POST["odds"])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/mera.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["mera"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/minas.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["minas"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/xronos.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["xronos"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/ora.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["ora"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/lepta.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["lepta"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/omada1.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["omada1"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/omada2.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["omada2"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/tips.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["tips"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/athlima.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["athlima"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/protathlima.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["protathlima"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/xora.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["xora"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/odds.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["odds"]);
			fclose($fp);
		}
	}

	//RECORD DATA 2 SECOND MATCH
	if (isset($_POST["Dodds"])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dmera.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dmera"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dminas.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dminas"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dxronos.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dxronos"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dora.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dora"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dlepta.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dlepta"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Domada1.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Domada1"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Domada2.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Domada2"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dtips.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dtips"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dathlima.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dathlima"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dprotathlima.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dprotathlima"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dxora.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dxora"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dodds.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Dodds"]);
			fclose($fp);
		}
	}

	//RECORD DATA 3 THIRD MATCH
	if (isset($_POST["Todds"])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tmera.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tmera"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tminas.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tminas"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Txronos.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Txronos"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tora.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tora"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tlepta.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tlepta"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tomada1.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tomada1"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tomada2.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tomada2"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Ttips.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Ttips"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tathlima.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tathlima"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tprotathlima.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Tprotathlima"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Txora.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Txora"]);
			fclose($fp);
		}

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Todds.txt", "w");
		if ($fp) {
			fwrite($fp, $_POST["Todds"]);
			fclose($fp);
		}
	}
}

//this is former php-apot-tips.php A+B
function push_apot_tips_on_db()
{

	global $userme;

	//find today..
	if (isset($_GET['today']) or $_GET['today'] != null) {
		$today = $_GET['today'];
	} else {

		trigger_error('to today param found');
		return;
	}

	//MAKE DIRECTORY
	if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today")) {
		mkdir($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today", 0755, true);
	}

	//RESULTS 1
	if (isset($_GET['apot'])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/apot.txt", "w");
		if ($fp) {
			fwrite($fp, $_GET["apot"]);
			fclose($fp);
		}
	}

	if (isset($_GET['Dapot'])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Dapot.txt", "w");
		if ($fp) {
			fwrite($fp, $_GET["Dapot"]);
			fclose($fp);
		}
	}

	if (isset($_GET['Tapot'])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/Tapot.txt", "w");
		if ($fp) {
			fwrite($fp, $_GET["Tapot"]);
			fclose($fp);
		}
	}

	//CASH OUT IS OPTIONAL
	if (isset($_GET['cashout'])) {

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/cashout.txt", "w");
		if ($fp) {
			fwrite($fp, $_GET["cashout"]);
			fclose($fp);
		}
	}

	//START RECORDS FORMER PHP-APOT-B
	//echo ("Making Records<br>");

	//Fere minas kai xronos, time of tip entrance
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/entrance.txt")) { //old feremina
		$feremina = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/entrance.txt"); //old feremina
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/feremina.txt")) { //new feremina
		$feremina = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/feremina.txt"); //new feremina
	}

	//patch feremina kai ferexrono if not found //new
	elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/minas.txt")) {
		$feremina = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/minas.txt");
	}

	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/ferexrono.txt")) { //new feremina
		$ferexrono = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/ferexrono.txt");
	}

	//patch feremina kai ferexrono if not found //new
	elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/xronos.txt")) {
		$ferexrono = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/tips/$today/xronos.txt");
	}

	//setting up wdl yia polla tips kai eite ena tip
	if (isset($_GET["wdl1"])) {

		$fx = $_GET["wdl1"];
		switch ($fx) {
			case "V":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.1.txt", "DRAW");
				break;
			case "X":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.1.txt", "CANCELLED");
				break;
			case "W":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.1.txt", "WIN");
				break;
			case "L":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.1.txt", "LOSE");
				break;
			case "W/2":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.1.txt", "HALF WIN");
				break;
			case "L/2":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.1.txt", "HALF LOSE");
				break;
		}
	}
	if (isset($_GET["wdl2"])) {

		$Dfx = $_GET["wdl2"];
		switch ($Dfx) {
			case "V":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.2.txt", "DRAW");
				break;
			case "X":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.2.txt", "CANCELLED");
				break;
			case "W":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.2.txt", "WIN");
				break;
			case "L":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.2.txt", "LOSE");
				break;
			case "W/2":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.2.txt", "HALF WIN");
				break;
			case "L/2":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.2.txt", "HALF LOSE");
				break;
		}
	}
	if (isset($_GET["wdl3"])) {

		$Tfx = $_GET["wdl3"];
		switch ($Tfx) {
			case "V":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.3.txt", "DRAW");
				break;
			case "X":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.3.txt", "CANCELLED");
				break;
			case "W":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.3.txt", "WIN");
				break;
			case "L":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.3.txt", "LOSE");
				break;
			case "W/2":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.3.txt", "HALF WIN");
				break;
			case "L/2":
				file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/wdl.3.txt", "HALF LOSE");
				break;
		}
	}
}

function push_edit_apotelesmata_on_db()
{

	global $userme;

	//find today..
	if (isset($_GET['today']) or $_GET['today'] != null) {
		$today = $_GET['today'];
	} else {

		trigger_error('to today param found');
		return;
	}

	//find apot.txt new method
	$apot_files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/$userme/records/*/$today/apot.txt");
	$apot_files_2 = glob($_SERVER['DOCUMENT_ROOT'] . "/$userme/tips/$today/apot.txt");
	$apot_files = array_merge($apot_files_1, $apot_files_2);
	$apot_file = $apot_files[0];

	//apot
	if (isset($_POST['apot'])) {
		file_put_contents($apot_file, $_POST['apot']);
	}
	if (isset($_POST['Dapot'])) {
		file_put_contents(str_replace("apot.txt", "Dapot.txt", $apot_file), $_POST['Dapot']);
	}
	if (isset($_POST['Tapot'])) {
		file_put_contents(str_replace("apot.txt", "Tapot.txt", $apot_file), $_POST['Tapot']);
	}
}

function delete_tips($dir)
{

	$dir = normalize_path($dir);
	if (str_contains($dir, "/tips/") or str_contains($dir, "/records/")) {

		delete_directory($dir);
	}
}