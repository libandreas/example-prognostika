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

//if headers allreay send
if (!headers_sent()) {

	//New to fix CORS error
	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: *");
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
}

//start
echo "[" . PHP_EOL;

//Find seasons and save to array
foreach ($getseasons as $season) {

	$season = trim($season);
	$text = explode(" - ", $season);
	$seasons_array[0] = $text[0];
	$seasons_array[1] = $text[1];
	$text[0] = substr($text[0], 0, 4);
	$text[1] = substr($text[1], 0, 4);

	//Show current season
	if ($seasons_array[0] <= $season_start && $seasons_array[1] >= $season_end) {
		$seasons_all[] = $season;
	}

	//show historical season
	elseif ($seasons_array[0] < $season_start && $seasons_array[1] < $season_end) {
		$seasons_all[] = $season;
	}
}

//count all active users
$u = 0;
$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*");
foreach ($files as $file) {

	$basename = basename($file);

	//mono tipsters
	$name = file_get_contents_or_null($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
	if ($name != null) {

		$u++;
	}
}

//scan all users
$k = 0;
foreach ($files as $file) {

	$basename = basename($file);

	//mono tipsters
	$name = file_get_contents_or_null($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/info/1/name.txt");
	if ($name != null) {

		//profit all seasons per user
		$userme = $basename;
		$prof = count_user_profit();
		$prof = str_replace(',', '', $prof);
		$prof = str_replace("+", '', $prof);
		$prof = intval($prof);

		//show json
		echo "{\"user\": \"$basename\"," . PHP_EOL;
		echo "\"profitallseason\": $prof," . PHP_EOL;
		echo "\"profitperseason\": [{" . PHP_EOL;

		//count Seasons per user
		$i = 0;
		foreach ($seasons_all as $season) {

			$text = explode(" - ", $season);
			$seasons_array[0] = $text[0];
			$seasons_array[1] = $text[1];
			$profit = count_user_profit_by_season($seasons_array[0], $seasons_array[1]);
			$profit = str_replace("+", '', $profit);
			$profit = intval($profit);

			if ($profit != 0) {

				$i++;
			}
		}

		//seasons per user
		$j = 0;
		foreach ($seasons_all as $season) {

			$text = explode(" - ", $season);
			$seasons_array[0] = $text[0];
			$seasons_array[1] = $text[1];
			$text[0] = substr($text[0], 0, 4);
			$text[1] = substr($text[1], 0, -2);
			$profit = count_user_profit_by_season($seasons_array[0], $seasons_array[1]);
			$profit = str_replace("+", '', $profit);
			$profit = intval($profit);

			if ($profit != 0) {

				echo "\"$text[0]" . "-" . "$text[1]\": $profit";

				//Το τελευταίο δεδομένο δεν πρέπει να έχει κόμμα.
				$j++;
				if ($j != $i) {
					echo ",";
				}
				echo PHP_EOL;
			}
		}
		echo "}]," . PHP_EOL;

		//open tips
		$o = 0;
		foreach (call_tips_by_date_and_time($_SERVER['DOCUMENT_ROOT'] . "/users/$basename/tips/*/tips.txt") as $filename) {

			$special = str_replace('tips.txt', 'specialset.txt', $filename);
			if (file_exists($special) && file_get_contents($special) != 'long') {

				$o++;
			}
		}
		echo "\"opentips\": $o" . PHP_EOL;

		echo "}";

		//το τελευταίο δεδομένο δεν πρέπει να έχει κόμμα.
		$k++;
		if ($k != $u) {
			echo ",";
		}

		echo PHP_EOL;
	}
}

//end
echo "]" . PHP_EOL;
