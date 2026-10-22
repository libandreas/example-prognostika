<?php

//note: από εδώ και πέρα το αρχείο λειτουργεί μονο όταν καλείτε απευθείας
if (realpath(__FILE__) != realpath($_SERVER["SCRIPT_FILENAME"])) {

	return;
}

$files_1 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*/tips/*/table.php");
$files_2 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*/records/*/records.php");
$files_3 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*/records/*/*/table.php");
$files_4 = glob($_SERVER['DOCUMENT_ROOT'] . "/users/*/records/*/*/form.php");
$files = array_merge($files_1, $files_2, $files_3, $files_4);

//αυτό το αρχείο ψάχνει όλες τις σελίδες και website και σβήνει όλα τα error_log που υπάρχουν μέσα στο hosting
//τουλάχιστον από εκεί που κοιτάει το πρόγραμμα
foreach ($files as $file) {

	unlink($file);
	echo $file . PHP_EOL;
}