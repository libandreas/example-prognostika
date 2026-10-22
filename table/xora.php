<?php

//andreas express
$files = glob($_SERVER['DOCUMENT_ROOT'] . "/users/global/xores/1/*.txt");

foreach ($files as $file) {

	$athlima = str_replace('.txt', null, basename($file));

	//an vlepo to trexon athlima
	if ($_GET["athlima"] == $athlima) {

		$xors = file($file);
		foreach ($xors as $xor) {

			if ($xor != null or $xor != PHP_EOL or $xor != " ") {

				$xor = trim($xor);
				echo "<option value=\"$xor\">$xor</option>";
			}
		}
	}
}
?>