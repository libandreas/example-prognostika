<?php
/**
 * Created by PhpStorm
 * User: Andreas Express
 * Date: 9/12/17
 * Time: 2:35 PM
 */

//HTML SIMPLE
function h1($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<h1" . $extra . ">$puts</h1>" . PHP_EOL;
	} else {
		return "<h1><a $extra href=\"$href\">$puts</a></h1>" . PHP_EOL;
	}
}
//HTML SIMPLE
function h2($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<h2" . $extra . ">$puts</h2>" . PHP_EOL;
	} else {
		return "<h2><a $extra href=\"$href\">$puts</a></h2>" . PHP_EOL;
	}
}
//HTML SIMPLE
function h3($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<h3" . $extra . ">$puts</h3>" . PHP_EOL;
	} else {
		return "<h3><a $extra href=\"$href\">$puts</a></h3>" . PHP_EOL;
	}
}
//HTML SIMPLE
function h4($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<h4" . $extra . ">$puts</h4>" . PHP_EOL;
	} else {
		return "<h4><a $extra href=\"$href\">$puts</a></h4>" . PHP_EOL;
	}
}
//HTML SIMPLE
function h5($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<h5" . $extra . ">$puts</h5>" . PHP_EOL;
	} else {
		return "<h5><a $extra href=\"$href\">$puts</a></h5>" . PHP_EOL;
	}
}
function h6($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<h6" . $extra . ">$puts</h6>" . PHP_EOL;
	} else {
		return "<h6><a $extra href=\"$href\">$puts</a></h6>" . PHP_EOL;
	}
}
function paragraph($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<p" . $extra . ">$puts</p>" . PHP_EOL;
	} else {
		return "<p><a $extra target=\"_parent\" href=\"$href\">$puts</a></p>" . PHP_EOL;
	}
}
function bold($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<p><b>$puts</b></p>" . PHP_EOL;
	} else {
		return "<p><a href='$href' $extra ><b>$puts</b></a></p>" . PHP_EOL;
	}
}
function italic($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<p><i>$puts</i></p>" . PHP_EOL;
	} else {
		return "<p><a href='$href' $extra ><i>$puts</i></a></p>" . PHP_EOL;
	}
}
function small($puts, $href = null, $extra = null)
{
	if ($href == null) {
		return "<p><small>$puts</small></p>" . PHP_EOL;
	} else {
		return "<p><a href='$href' $extra ><small>$puts</small></a></p>" . PHP_EOL;
	}
}
function pre($puts, $extra = null)
{
	return "<p><code><pre $extra >$puts</pre></code></p>" . PHP_EOL;
}
function box($puts, $extra = null, $color = null)
{
	if ($extra == "green") {
		$extra = "color:forestgreen;border-color:forestgreen";
	}
	if ($extra == 'red') {
		$extra = "color:red;border-color:red";
	}
	if ($extra == "blue") {
		$extra = "color:royalblue;border-color:royalblue";
	} else {
		$extra = null;
	}
	return "<div style='width:100%;box-sizing: border-box;background: ghostwhite;padding:5px;border: 1px solid darkgray;$extra'>$puts</div><br>" . PHP_EOL;
}


function img($src, $href = null, $extra = null)
{
	if ($href != null) {
		return "<p><a href='$href' $extra ><img src='$src' style='max-width:100%;box-sizing: border-box'></a></p>" . PHP_EOL;
	} else {
		$extra = null;
		return "<p><img src='$src' style='max-width:100%;box-sizing: border-box'></p>" . PHP_EOL;
	}
}

//HTML LIST
function ul(array $txts, array $urls = null, $extra = null)
{
	$m = "<ul>\n";
	if ($urls == null) {
		foreach ($txts as $text) {
			$m .= "<li $extra >$text</li>";
		}
	}
	foreach (array_combine($txts, $urls) as $text => $href) {
		$m .= "<li><a $extra href=\"$href\" >$text</a></li>";
	}
	$m .= "</ul>\n";
	return $m;
}

function table($array, $extra = null)
{
	$html = "<table $extra border='1' style='max-width: 100%;padding:5px;box-sizing: border-box;border-collapse: collapse'>\n";
	$html .= '<tr>';
	foreach ($array[0] as $key => $href) {
		$html .= '<th style="padding:6px">' . htmlspecialchars($key) . '</th>';
	}
	$html .= '</tr>';
	foreach ($array as $key => $href) {
		$html .= '<tr>';
		foreach ($href as $key2 => $href2) {
			$html .= '<td style="padding:6px">' . htmlspecialchars($href2) . '</td>';
		}
		$html .= '</tr>';
	}
	$html .= '</table>';
	return $html;
}

function menu(array $txts, array $urls = null, $extra = null)
{
	if ($extra == "style='color:forestgreen'") {
		$extra = "color:forestgreen;border-color:forestgreen;background:ghostwhite";
	} elseif ($extra == "style='color:red'") {
		$extra = "color:red;border-color:red;background:ghostwhite";
	} elseif ($extra == "style='color:royalblue'") {
		$extra = "color:royalblue;border-color:royalblue;background:ghostwhite";
	} else {
		$extra = "background:ghostwhite";
	}
	$m = "<p>\n";
	if ($urls != null) {
		$extra2 = "onchange=\"window.location.href=this.value\"";
	}
	$m .= "<select $extra2 style='$extra; max-width: 100%;padding:6px;box-sizing: border-box'>\n";
	if ($urls == null) {
		foreach ($txts as $text) {
			$m .= "<option value='$text'>$text</option>";
		}
	}
	foreach (array_combine($txts, $urls) as $text => $href) {
		$m .= '<option value="' . $href . '">' . $text . '</option>';
	}
	$m .= "</select>\n";
	$m .= "</p>\n";
	return $m;
}

function button($puts, $href = null, $extra = null)
{
	if ($extra == "green") {
		$extra = "color:forestgreen;border-color:forestgreen;background:ghostwhite";
	} elseif ($extra == "red") {
		$extra = "color:red;border-color:red;background:ghostwhite";
	} elseif ($extra == "blue") {
		$extra = "color:royalblue;border-color:royalblue;background:ghostwhite";
	} else {
		$extra = "background:ghostwhite";
	}
	if ($href == null) {
		return "<button style=\"max-width: 100%;border:1px solid darkgray;padding:6px;box-sizing: border-box;$extra\">$puts</button>" . PHP_EOL;
	} else {
		return "<a href=\"$href\"><span style='max-width: 100%;border:1px solid darkgray;padding:6px;box-sizing: border-box;color:black;$extra'>$puts</span></a>" . PHP_EOL;
	}
}

?>