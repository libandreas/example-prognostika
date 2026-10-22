<?php
function setup_table_variables($filename)
{
	global $per;
	if (file_exists(str_replace("tips.txt", "per.txt", $filename))) {

		$per = file_get_contents(str_replace("tips.txt", "per.txt", $filename));
		$per = links_to_open_in_a_new_tab($per);
		$per = trim($per);
		//$per = nl2br($per); //όχι πλέων γιατί έχει editor!!
	} else {
		$per = null;
	}

	//OTHER
	global $today;
	global $minaslink;
	global $posoA;
	global $put;
	if (file_exists(str_replace("tips.txt", "tips.txt", $filename))) {

		$today = basename(dirname($filename)); //new
		$minaslink = basename(dirname(dirname($filename))); //new
		$posoA = file_get_contents(str_replace("tips.txt", "posoA.txt", $filename));
		$put = file_get_contents(str_replace("tips.txt", "put.txt", $filename));
	} else {

		$today = null;
		$minaslink = null;
		$posoA = null;
		$put = null;
	}

	//GET CORRECT USERME OF CURRENT TIP //NEW
	global $userme;
	global $userme_of_tip;
	$userme_of_tip = basename(dirname(dirname(dirname($filename))));
	if ($userme_of_tip == 'records') {
		$userme_of_tip = basename(dirname(dirname(dirname(dirname($filename)))));
	} else {
		$userme_of_tip = basename(dirname(dirname(dirname($filename)))); //ένα λιγότερο dirname όταν ειναι μέσα στο tips
	}

	//GET NAME OF TIPSTER SPECIAL //NEW
	global $getname_of_tip;
	$getname_of_tip = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $userme_of_tip . "/info/1/name.txt";
	if (file_exists($getname_of_tip)) {
		$getname_of_tip = file_get_contents($getname_of_tip);
	} else {
		$getname_of_tip = null;
	}

	//GET URL OF TIPSTER SPECIAL //NEW
	global $getlink_of_tip;
	$getlink_of_tip = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $userme_of_tip . "/info/1/url.txt";
	if (file_exists($getlink_of_tip)) {
		$getlink_of_tip = file_get_contents($getlink_of_tip);
	} else {
		$getlink_of_tip = "/table/todaytips.php?u=" . $userme_of_tip;
	}

	//TIP DATA
	global $simeia;
	global $athlima;
	global $tips;
	global $xora;
	global $protathlima;
	global $mera;
	global $minas;
	global $xronos;
	global $ora;
	global $lepta;
	global $omada1;
	global $omada2;
	global $odds;
	global $agora;
	global $agora_with_space;
	global $flag;
	$simeia = 0;
	$athlima = array(1 => null, 2 => null, 3 => null);
	$tips = array(1 => null, 2 => null, 3 => null);
	$xora = array(1 => '-', 2 => '-', 3 => '-');
	$protathlima = array(1 => null, 2 => null, 3 => null);
	$mera = array(1 => date('d'), 2 => date('d'), 3 => date('d'));
	$minas = array(1 => date('m'), 2 => date('m'), 3 => date('m'));
	$xronos = array(1 => date('Y'), 2 => date('Y'), 3 => date('Y'));
	$ora = array(1 => date("h"), 2 => date("h"), 3 => date("h"));
	$lepta = array(1 => date("s"), 2 => date("s"), 3 => date("s"));
	$omada1 = array(1 => null, 2 => null, 3 => null);
	$omada2 = array(1 => null, 2 => null, 3 => null);
	$odds = array(1 => 1, 2 => 1, 3 => 1);
	$agora = array(1 => null, 2 => null, 3 => null);
	$agora_with_space = array(1 => null, 2 => null, 3 => null);
	$flag = array(1 => "/flags/Unknown.svg", 2 => "/flags/Unknown.svg", 3 => "/flags/Unknown.svg");

	//1
	if (file_exists(str_replace("tips.txt", "tips.txt", $filename))) {

		$simeia = 1;
		$athlima[1] = file_get_contents(str_replace("tips.txt", "athlima.txt", $filename));
		$athlima[1] = trim($athlima[1]);
		$tips[1] = file_get_contents(str_replace("tips.txt", "tips.txt", $filename));
		$xora[1] = file_get_contents(str_replace("tips.txt", "xora.txt", $filename));
		$xora[1] = trim($xora[1]);
		$protathlima[1] = file_get_contents(str_replace("tips.txt", "protathlima.txt", $filename));
		$mera[1] = file_get_contents(str_replace("tips.txt", "mera.txt", $filename));
		$minas[1] = file_get_contents(str_replace("tips.txt", "minas.txt", $filename));
		$xronos[1] = file_get_contents(str_replace("tips.txt", "xronos.txt", $filename));
		$ora[1] = file_get_contents(str_replace("tips.txt", "ora.txt", $filename));
		$lepta[1] = file_get_contents(str_replace("tips.txt", "lepta.txt", $filename));
		$omada1[1] = file_get_contents(str_replace("tips.txt", "omada1.txt", $filename));
		$omada2[1] = file_get_contents(str_replace("tips.txt", "omada2.txt", $filename));
		$odds[1] = file_get_contents(str_replace("tips.txt", "odds.txt", $filename));
		$agora[1] = file_get_contents(str_replace("tips.txt", "agora.txt", $filename));
		$agora_with_space[1] = str_replace("_", " ", $agora[1]);
		if (file_exists("/flags/" . $xora[1] . '.svg')) {
			$flag[1] = "/flags/" . $xora[1] . '.svg';
		}
	}

	//2
	if (file_exists(str_replace("tips.txt", "Dtips.txt", $filename))) {

		$simeia = 2;
		$athlima[2] = file_get_contents(str_replace("tips.txt", "Dathlima.txt", $filename));
		$athlima[2] = trim($athlima[2]);
		$tips[2] = file_get_contents(str_replace("tips.txt", "Dtips.txt", $filename));
		$xora[2] = file_get_contents(str_replace("tips.txt", "Dxora.txt", $filename));
		$xora[2] = trim($xora[2]);
		$protathlima[2] = file_get_contents(str_replace("tips.txt", "Dprotathlima.txt", $filename));
		$mera[2] = file_get_contents(str_replace("tips.txt", "Dmera.txt", $filename));
		$minas[2] = file_get_contents(str_replace("tips.txt", "Dminas.txt", $filename));
		$xronos[2] = file_get_contents(str_replace("tips.txt", "Dxronos.txt", $filename));
		$ora[2] = file_get_contents(str_replace("tips.txt", "Dora.txt", $filename));
		$lepta[2] = file_get_contents(str_replace("tips.txt", "Dlepta.txt", $filename));
		$omada1[2] = file_get_contents(str_replace("tips.txt", "Domada1.txt", $filename));
		$omada2[2] = file_get_contents(str_replace("tips.txt", "Domada2.txt", $filename));
		$odds[2] = file_get_contents(str_replace("tips.txt", "Dodds.txt", $filename));
		$agora[2] = file_get_contents(str_replace("tips.txt", "Dagora.txt", $filename));
		$agora_with_space[2] = str_replace("_", " ", $agora[2]);
		if (file_exists("/flags/" . $xora[2] . '.svg')) {
			$flag[2] = "/flags/" . $xora[2] . '.svg';
		}
	}

	//3
	if (file_exists(str_replace("tips.txt", "Ttips.txt", $filename))) {

		$simeia = 3;
		$athlima[3] = file_get_contents(str_replace("tips.txt", "Tathlima.txt", $filename));
		$athlima[3] = trim($athlima[3]);
		$tips[3] = file_get_contents(str_replace("tips.txt", "Ttips.txt", $filename));
		$xora[3] = file_get_contents(str_replace("tips.txt", "Txora.txt", $filename));
		$xora[3] = trim($xora[3]);
		$protathlima[3] = file_get_contents(str_replace("tips.txt", "Tprotathlima.txt", $filename));
		$mera[3] = file_get_contents(str_replace("tips.txt", "Tmera.txt", $filename));
		$minas[3] = file_get_contents(str_replace("tips.txt", "Tminas.txt", $filename));
		$xronos[3] = file_get_contents(str_replace("tips.txt", "Txronos.txt", $filename));
		$ora[3] = file_get_contents(str_replace("tips.txt", "Tora.txt", $filename));
		$lepta[3] = file_get_contents(str_replace("tips.txt", "Tlepta.txt", $filename));
		$omada1[3] = file_get_contents(str_replace("tips.txt", "Tomada1.txt", $filename));
		$omada2[3] = file_get_contents(str_replace("tips.txt", "Tomada2.txt", $filename));
		$odds[3] = file_get_contents(str_replace("tips.txt", "Todds.txt", $filename));
		$agora[3] = file_get_contents(str_replace("tips.txt", "Tagora.txt", $filename));
		$agora_with_space[3] = str_replace("_", " ", $agora[3]);
		if (file_exists("/flags/" . $xora[3] . '.svg')) {
			$flag[3] = "/flags/" . $xora[3] . '.svg';
		}
	}

	//FAIL
	global $fail;
	if (file_exists(str_replace("tips.txt", "fail.txt", $filename))) {
		$fail = file_get_contents(str_replace("tips.txt", "fail.txt", $filename));
	} else {
		$fail = null;
	}

	//CACHOUT - DEPRECACED
	global $cash;
	if (file_exists(str_replace("tips.txt", "cashout.txt", $filename))) {
		$cash = file_get_contents(str_replace("tips.txt", "cashout.txt", $filename));
	} else {
		$cash = null;
	}

	//DWL
	global $dwl;
	$dwl = array(1 => '-', 2 => '-', 3 => '-');
	if (file_exists(str_replace("tips.txt", "wdl.1.txt", $filename))) {
		$dwl[1] = file_get_contents(str_replace("tips.txt", "wdl.1.txt", $filename));
	}
	if (file_exists(str_replace("tips.txt", "wdl.2.txt", $filename))) {
		$dwl[2] = file_get_contents(str_replace("tips.txt", "wdl.2.txt", $filename));
	}
	if (file_exists(str_replace("tips.txt", "wdl.3.txt", $filename))) {
		$dwl[3] = file_get_contents(str_replace("tips.txt", "wdl.3.txt", $filename));
	}

	//APOT
	global $apot;
	$apot = array(1 => '-', 2 => '-', 3 => '-');
	if (file_exists(str_replace("tips.txt", "apot.txt", $filename))) {
		$apot[1] = file_get_contents(str_replace("tips.txt", "apot.txt", $filename));
	}
	if (file_exists(str_replace("tips.txt", "Dapot.txt", $filename))) {
		$apot[2] = file_get_contents(str_replace("tips.txt", "Dapot.txt", $filename));
	}
	if (file_exists(str_replace("tips.txt", "Tapot.txt", $filename))) {
		$apot[3] = file_get_contents(str_replace("tips.txt", "Tapot.txt", $filename));
	}

	//PROFIT
	global $profit;
	$profit = count_user_profit(null, null, $today, false, $userme_of_tip);
	if ($profit > 0) {

		$profit = "+" . $profit;
	} elseif (empty($profit)) {

		$profit = "-";
	}

	//KLEIDOMA TIPS
	global $kleidomeno;
	if (file_exists(str_replace("tips.txt", "kleidomeno.txt", $filename))) {

		$kleidomeno = file_get_contents(str_replace("tips.txt", "kleidomeno.txt", $filename));
	} elseif (file_exists(str_replace("tips.txt", "klidomeno.txt", $filename))) {

		$kleidomeno = file_get_contents(str_replace("tips.txt", "klidomeno.txt", $filename));
	} else {

		$kleidomeno = null;
	}

	//SPECIAL
	global $special;
	if (file_exists(str_replace("tips.txt", "specialset.txt", $filename))) {

		$special = file_get_contents(str_replace("tips.txt", "specialset.txt", $filename));
	} else {

		$special = null;
	}

	//FIXES PROTATHLIMATA IF NOT FOUND
	if (empty($protathlima[1])) {
		$protathlima[1] = $xora[1];
	}
	if (empty($protathlima[2])) {
		$protathlima[2] = $xora[2];
	}
	if (empty($protathlima[3])) {
		$protathlima[3] = $xora[3];
	}

	//BOOK
	global $book;
	global $bookimg;
	global $booklink;
	global $booktext;
	global $bookcolor;
	if (file_exists(str_replace("tips.txt", "book.txt", $filename))) {

		$book = file_get_contents(str_replace("tips.txt", "book.txt", $filename));
		$bookarray = explode("**", $book);
		$bookimg = $bookarray[0];
		$booklink = $bookarray[1];
		if ($booklink == null) {
			$booklink = "#";
		}
		$booktext = $bookarray[2];
		$bookcolor = $bookarray[3];
		$bookcolor = trim($bookcolor);

		$bookimg = "/images/" . $bookimg;

	} else {

		$book = null;
		$bookimg = null;
		$booklink = "#";
		$booktext = null;
		$bookcolor = null;
	}

	//CANCELLED - DWAW - WIN - LOSE - ETC
	global $dwl;
	if (!empty($dwl[1])) {
		$dwl[1] = trim($dwl[1]);
	}
	if (!empty($dwl[2])) {
		$dwl[2] = trim($dwl[2]);
	}
	if (!empty($dwl[3])) {
		$dwl[3] = trim($dwl[3]);
	}

	//CLASS CANCELLED
	global $profitcolor;
	global $profitkat;
	global $profitclass;
	if (isset($dwl[1]) && str_replace(PHP_EOL, '', $dwl[1]) == "CANCELLED") {
		$profitcolor = "black";
		$profitkat = ucwords(strtolower($dwl[1]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[1]));
	} elseif (isset($dwl[2]) && str_replace(PHP_EOL, '', $dwl[2]) == "CANCELLED") {
		$profitcolor = "black";
		$profitkat = ucwords(strtolower($dwl[2]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[2]));
	} elseif (isset($dwl[3]) && str_replace(PHP_EOL, '', $dwl[3]) == "CANCELLED") {
		$profitkat = ucwords(strtolower($dwl[3]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[3]));
	} elseif (isset($dwl[1]) && str_replace(PHP_EOL, '', $dwl[1]) == "LOSE") {
		$profitcolor = "red";
		$profitkat = ucwords(strtolower($dwl[1]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[1]));
	} elseif (isset($dwl[2]) && str_replace(PHP_EOL, '', $dwl[2]) == "LOSE") {
		$profitcolor = "red";
		$profitkat = ucwords(strtolower($dwl[2]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[2]));
	} elseif (isset($dwl[3]) && str_replace(PHP_EOL, '', $dwl[3]) == "LOSE") {
		$profitcolor = "red";
		$profitkat = ucwords(strtolower($dwl[3]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[3]));
	} elseif (isset($dwl[1]) && str_replace(PHP_EOL, '', $dwl[1]) == "HALF LOSE") {
		$profitcolor = "red";
		$profitkat = ucwords(strtolower($dwl[1]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[1]));
	} elseif (isset($dwl[2]) && str_replace(PHP_EOL, '', $dwl[2]) == "HALF LOSE") {
		$profitcolor = "red";
		$profitkat = ucwords(strtolower($dwl[2]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[2]));
	} elseif (isset($dwl[3]) && str_replace(PHP_EOL, '', $dwl[3]) == "HALF LOSE") {
		$profitcolor = "red";
		$profitkat = ucwords(strtolower($dwl[3]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[3]));
	} elseif (isset($dwl[1]) && str_replace(PHP_EOL, '', $dwl[1]) == "DRAW") {
		$profitcolor = "orange";
		$profitkat = ucwords(strtolower($dwl[1]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[1]));
	} elseif (isset($dwl[2]) && str_replace(PHP_EOL, '', $dwl[2]) == "DRAW") {
		$profitcolor = "orange";
		$profitkat = ucwords(strtolower($dwl[2]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[2]));
	} elseif (isset($dwl[3]) && str_replace(PHP_EOL, '', $dwl[3]) == "DRAW") {
		$profitcolor = "orange";
		$profitkat = ucwords(strtolower($dwl[3]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[3]));
	} elseif (isset($dwl[1]) && str_replace(PHP_EOL, '', $dwl[1]) == "HALF WIN") {
		$profitcolor = "green";
		$profitkat = ucwords(strtolower($dwl[1]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[1]));
	} elseif (isset($dwl[2]) && str_replace(PHP_EOL, '', $dwl[2]) == "HALF WIN") {
		$profitcolor = "green";
		$profitkat = ucwords(strtolower($dwl[2]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[2]));
	} elseif (isset($dwl[3]) && str_replace(PHP_EOL, '', $dwl[3]) == "HALF WIN") {
		$profitcolor = "green";
		$profitkat = ucwords(strtolower($dwl[3]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[3]));
	} elseif (isset($dwl[1]) && str_replace(PHP_EOL, '', $dwl[1]) == "WIN") {
		$profitcolor = "green";
		$profitkat = ucwords(strtolower($dwl[1]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[1]));
	} elseif (isset($dwl[2]) && str_replace(PHP_EOL, '', $dwl[2]) == "WIN") {
		$profitcolor = "green";
		$profitkat = ucwords(strtolower($dwl[2]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[2]));
	} elseif (isset($dwl[3]) && str_replace(PHP_EOL, '', $dwl[3]) == "WIN") {
		$profitcolor = "green";
		$profitkat = ucwords(strtolower($dwl[3]));
		$profitclass = strtolower(str_replace(" ", "-", $dwl[3]));
	} else {
		$profitcolor = null;
		$profitkat = null;
		$profitclass = "stand-by";
	}

	//ODDS FORMAT
	$odds[1] = number_format($odds[1], 2);
	$odds[2] = number_format($odds[2], 2);
	$odds[3] = number_format($odds[3], 2);

	//ADMIN EPEKSERGASIA KAI DELETE VARIABLES
	global $dir_of_tip;
	$dir_of_tip = realpath(dirname($filename));

	//ADMIN EPEKSERGASIA KAI DELETE
	global $libusername;
	global $libpasswd;
	global $getpasswd;
	global $getlevel;

	//poly periergo bug
	if ($tips[1] != null && str_contains($tips[1], "<html")) {

		$tips[1] = null;
	} elseif ($tips[2] != null && str_contains($tips[2], "<html")) {

		$tips[2] = null;
	} elseif ($tips[3] != null && str_contains($tips[3], "<html")) {

		$tips[3] = null;
	}

	//gia tis diafimisis
	$nd = rand(1, 4);
	global $html_banner;
	global $html_banner_mobile;
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/html-banner-$nd.txt")) {

		$html_banner = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/html-banner-$nd.txt");
		$html_banner_mobile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/users/global/info/1/html-banner-$nd-mobile.txt");
	} else {

		$html_banner = null;
		$html_banner_mobile = null;
	}
}