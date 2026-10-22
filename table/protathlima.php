<?php

//andreas express
$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/global/protathlimata/1/*.txt");

foreach ($files as $file) {

	$filename = str_replace('.txt', null, basename($file));

	//an vlepo to trexon protaathlima
	if ($_GET["xora"] . "-" . $_GET["athlima"] == $filename) {

		$prots = file($file);
		foreach ($prots as $prot) {

			if ($prot != null or $prot != PHP_EOL or $prot != " ") {

				$prot = trim($prot);
				echo "<option value=\"$prot\">$prot</option>";
			}
		}
	}
}
?>