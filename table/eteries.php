<?php
$eteries = file($_SERVER['DOCUMENT_ROOT'] . '/users/global/eteries/1/eteries.txt');
foreach ($eteries as $book) {

	$bookarray = explode("**", $book);
	echo "<option value=\"$book\">$bookarray[2]</option>";
}
?>