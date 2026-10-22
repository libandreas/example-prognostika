<option value="">Επιλέξτε:</option>
<?php

//andreas express
$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/global/agores/1/*.txt");

foreach ($files as $file) {

	$athlima = str_replace('.txt', null, basename($file));

	//an vlepo to trexon agora
	if ($_GET["athlima"] == $athlima) {

		$agors = file($file);
		foreach ($agors as $agor) {

			if ($agor != null or $agor != PHP_EOL or $agor != " ") {

				$agor = trim($agor);
				$agord = str_replace(" ", "_", $agor);
				echo "<option value=\"$agord\">$agor</option>";
			}
		}
	}
}

foreach ($files as $file) {

	echo dirname(__FILE__) . '/agores/1/' . basename($file);
	echo "<br>";
}
?>