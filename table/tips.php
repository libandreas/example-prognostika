<?php
/**
 * Created by PhpStorm
 * User: User
 * Date: 22/8/2019
 * Time: 8:31 μμ
 */

$agora = $_GET['agora'];
$agora = str_replace("_", " ", $agora);
?>

<?php if ($agora == 'Match Winner') { ?>
	<option value="">Επιλέξτε:</option>
	<option value="1">1</option>
	<option value="X">X</option>
	<option value="2">2</option>
<?php } else { ?>
	<option value="">Manual</option>
<?php } ?>