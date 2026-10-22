<?php

//A simple PHP CAPTCHA script
//Mirrorright 2011 by Cory LaViska for A Beautiful Site, LLC
//See readme.md for usage, demo, and licensing info
//All-In-One @AndreasExpress
//bug: μετά απο τεστ, αν έχει ελληνικά ο φάκελος δεν δείχνει γράμματα το captcha

function setup_simple_php_captcha_buffer($html)
{
	return preg_replace_callback('/<form\b[^>]*>.*?<\/form>/is', function ($match) {
		$form = $match[0];

		if (preg_match('/<div\b[^>]*class=["\'][^"\']*\bsimple-php-captcha\b[^"\']*["\'][^>]*>.*?<\/div>/is', $form)) {
			return preg_replace('/<div\b[^>]*class=["\'][^"\']*\bsimple-php-captcha\b[^"\']*["\'][^>]*>.*?<\/div>/is', view_simple_php_captcha(), $form, 1);
		}

		return $form;
	}, $html);
}

function check_simple_php_captcha($human_code = false, $session_code = false)
{

	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	$human_code = $human_code !== false ? $human_code : ($_POST["human"] ?? null);
	$session_code = $session_code !== false ? $session_code : ($_SESSION['captcha']['code'] ?? null);
	if ($human_code != null && $session_code != null) {

		if ($human_code == $session_code) {

			return true;
		}
	}
}

// Only a direct GET to this file can request the CAPTCHA image.
$captcha_image_request = $_SERVER['REQUEST_METHOD'] === 'GET'
	&& realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)
	&& isset($_GET['captcha']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!check_simple_php_captcha()) {
		echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Verification failed</title></head><body>';
		echo '<p>Sorry, you did not pass the human verification check.</p>';
		echo '<p><a class="cms-link" href="' . htmlspecialchars($_SERVER['HTTP_REFERER'] ?? '/', ENT_QUOTES, 'UTF-8') . '">Return</a></p>';
		echo '</body></html>';
		exit;
	}

	unset($_SESSION['captcha']);
}

if (!$captcha_image_request) {
	ob_start('setup_simple_php_captcha_buffer');
}

function view_simple_php_captcha($placeholder = false)
{

	//ξεκινάει από εδώ
	if ($placeholder == false) {

		$placeholder = "Type Here..";
	}

	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	$_SESSION['captcha'] = simple_php_captcha();
	$image_url = $_SESSION['captcha']['image_src'];
	session_write_close();
	$html = "<div id=\"simple-php-captcha\"><strong>Captcha: *</strong><br>";
	$html .= '<img src="' . htmlspecialchars($image_url, ENT_QUOTES, 'UTF-8') . '"><br>';
	$html .= '<input placeholder="' . htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8') . '" type="text" name="human">';
	$html .= "</div>";
	//session_write_close();
	return $html;
}

///////////////////////////////////////////////////////////////////////////
///SIMPLE PHP CAPTCHA ORIGINAL FUNCTIONS
///////////////////////////////////////////////////////////////////////////
function simple_php_captcha($config = array())
{

	//check for gd library
	if (!function_exists('gd_info')) {

		trigger_error('required GD library is missing');
		return;
	}

	//default values
	$captcha_config = array(
		'code' => '',
		'min_length' => 5,
		'max_length' => 5,
		'backgrounds' => array(
			str_replace('\\', '/', str_replace('.php', '.png', __FILE__))
		),
		'fonts' => array(
			str_replace('\\', '/', str_replace('.php', '.ttf', __FILE__))
		),
		'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
		'min_font_size' => 28,
		'max_font_size' => 28,
		'color' => '#666',
		'angle_min' => 0,
		'angle_max' => 10,
		'shadow' => true,
		'shadow_color' => '#fff',
		'shadow_offset_x' => -1,
		'shadow_offset_y' => 1
	);

	//overwrite defaults with custom config values
	if (is_array($config)) {
		foreach ($config as $key => $value)
			$captcha_config[$key] = $value;
	}

	//restrict certain values
	if ($captcha_config['min_length'] < 1)
		$captcha_config['min_length'] = 1;
	if ($captcha_config['angle_min'] < 0)
		$captcha_config['angle_min'] = 0;
	if ($captcha_config['angle_max'] > 10)
		$captcha_config['angle_max'] = 10;
	if ($captcha_config['angle_max'] < $captcha_config['angle_min'])
		$captcha_config['angle_max'] = $captcha_config['angle_min'];
	if ($captcha_config['min_font_size'] < 10)
		$captcha_config['min_font_size'] = 10;
	if ($captcha_config['max_font_size'] < $captcha_config['min_font_size'])
		$captcha_config['max_font_size'] = $captcha_config['min_font_size'];

	//generate captcha code if not set by user
	if (empty($captcha_config['code'])) {
		$captcha_config['code'] = '';
		$length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
		while (strlen($captcha_config['code']) < $length) {
			$captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
		}
	}

	//generate html for image src
	$_SERVER['SCRIPT_FILENAME'] = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
	$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
	$image_src = '/common/' . basename(__FILE__) . '?captcha&t=' . urlencode(microtime());

	//return image
	//$_SESSION['captcha']['config'] = serialize($captcha_config);
	return array(
		'code' => $captcha_config['code'],
		'config' => serialize($captcha_config),
		'image_src' => $image_src
	);
}

if (!function_exists('hex2rgb')) {
	function hex2rgb($hex_str, $return_string = false, $separator = ',')
	{
		$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); //Gets a proper hex string
		$rgb_array = array();
		if (strlen($hex_str) == 6) {
			$color_val = hexdec($hex_str);
			$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
			$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
			$rgb_array['b'] = 0xFF & $color_val;
		} elseif (strlen($hex_str) == 3) {
			$rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
			$rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
			$rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
		} else {
			return false;
		}
		return $return_string ? implode($separator, $rgb_array) : $rgb_array;
	}
}

//draw the image
if ($captcha_image_request) {

	//πλέων ο κοδικός θα βγένει μόλις μπει στην εικόνα και όχι ποιο πριν
	session_start();
	$captcha_config = isset($_SESSION['captcha']['config']) ? unserialize($_SESSION['captcha']['config']) : false;
	if (!$captcha_config) {

		if (!is_writable(session_save_path())) {
			echo 'Session path "' . session_save_path() . '" is not writable for PHP!';
		}

		trigger_error('captcha config variables not found');
		exit();
	}

	//unset($_SESSION['captcha']);
	session_write_close();

	//pick random background, get info, and start captcha
	$background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) - 1)];
	list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
	$captcha = imagecreatefrompng($background);
	$color = hex2rgb($captcha_config['color']);
	$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);

	//determine text angle
	$angle = mt_rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (mt_rand(0, 1) == 1 ? -1 : 1);

	//select font randomly
	$font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];

	//verify font file exists
	if (!file_exists($font)) {
		trigger_error('font file not found: ' . $font);
	}

	// Workaround for GD in Windows with Greek paths
	$temp_font_path = sys_get_temp_dir() . '/' . basename($font);
	if (!file_exists($temp_font_path)) {
		copy($font, $temp_font_path);
	}
	$font = $temp_font_path;

	//set the font size.
	$font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
	$text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);

	//determine text position
	$box_width = abs($text_box_size[6] - $text_box_size[2]);
	$box_height = abs($text_box_size[5] - $text_box_size[1]);
	$text_pos_x_min = 0;
	$text_pos_x_max = ($bg_width) - ($box_width);
	$text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
	$text_pos_y_min = $box_height;
	$text_pos_y_max = ($bg_height) - ($box_height / 2);
	if ($text_pos_y_min > $text_pos_y_max) {
		$temp_text_pos_y = $text_pos_y_min;
		$text_pos_y_min = $text_pos_y_max;
		$text_pos_y_max = $temp_text_pos_y;
	}
	$text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);

	//draw shadow
	if ($captcha_config['shadow']) {
		$shadow_color = hex2rgb($captcha_config['shadow_color']);
		$shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
		imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
	}

	//draw text
	imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);

	//output image
	header("Content-type: image/png");
	imagepng($captcha);
	exit; //να φύγει απο το αρχείο και να μην δείξει το παράδειγμα
}
