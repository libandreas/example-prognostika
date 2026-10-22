<?php

/********************************
Simple PHP File Manager
Copyright John Campbell (jcampbell1)
Liscense: MIT
/********************************/
function is_entry_ignored($entry, $allow_show_folders_filemanager, $hidden_patterns_filemanager)
{
	if ($entry === basename(__FILE__)) {
		return true;
	}

	if (is_dir($entry) && !$allow_show_folders_filemanager) {
		return true;
	}
	foreach ($hidden_patterns_filemanager as $pattern) {
		if (fnmatch($pattern, $entry)) {
			return true;
		}
	}
	return false;
}

function rmrf($dir)
{
	if (is_dir($dir)) {
		$files = array_diff(scandir($dir), ['.', '..']);
		foreach ($files as $file)
			rmrf("$dir/$file");
		rmdir($dir);
	} else {
		unlink($dir);
	}
}
function is_recursively_deleteable($d)
{
	$stack = [$d];
	while ($dir = array_pop($stack)) {
		if (!is_readable($dir) || !is_writable($dir))
			return false;
		$files = array_diff(scandir($dir), ['.', '..']);
		foreach ($files as $file)
			if (is_dir($file)) {
				$stack[] = "$dir/$file";
			}
	}
	return true;
}

//from: http://php.net/manual/en/function.realpath.php#84012
function get_absolute_path($path)
{
	$path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
	$parts = explode(DIRECTORY_SEPARATOR, $path);
	$absolutes = [];
	foreach ($parts as $part) {
		if ('.' == $part)
			continue;
		if ('..' == $part) {
			array_pop($absolutes);
		} else {
			$absolutes[] = $part;
		}
	}
	return implode(DIRECTORY_SEPARATOR, $absolutes);
}

function err($code, $msg)
{
	http_response_code($code);
	header("Content-Type: application/json");
	echo json_encode(['error' => ['code' => intval($code), 'msg' => $msg]]);
	exit;
}

function asBytes($ini_v)
{
	$ini_v = trim($ini_v);
	$s = ['g' => 1 << 30, 'm' => 1 << 20, 'k' => 1 << 10];
	return intval($ini_v) * ($s[strtolower(substr($ini_v, -1))] ?: 1);
}

function convertMBtoBytes($size)
{
	$size = trim($size);
	$last = strtolower($size[strlen($size) - 1]);
	$size = rtrim($size, $last);
	$size = intval($size);
	switch ($last) {
		case 'g':
			$size *= (1024 * 1024 * 1024);
			break;
		case 'm':
			$size *= (1024 * 1024);
			break;
		case 'k':
			$size *= 1024;
			break;
	}
	return $size;
}

//file manager front links is here
function setup_fm_buffer($html)
{

	// βάζει το link για να επιστρέψει στην προηγούμενη σελίδα
	if (str_contains(get_current_url(), "/" . basename(__FILE__))) {

		//pull back
		$url = urldecode($_GET['t']);
		$html = attach_admin_link($url, "Return", "Blue", $html, "↩️");
	}

	// να μην κάνει τίποτα αμα ειναι μέσα στο admin
	if (is_inside_any_admin() or is_iframe()) {
		return $html;
	}

	// preview file
	$preview_file = $_SERVER['SCRIPT_FILENAME'];

	//attach links
	if (is_user_admin_back_end() && !is_inside_any_admin()) {

		$target = path2url(__FILE__);

		//push today and user or other stuff
		$current_url = urlencode(get_current_url());
		$url = update_url_params(array('f' => $preview_file, 't' => $current_url), $target);
		$html = attach_admin_link($url, "File manager", "Orange", $html, "🗂️");
	}
	return $html;
}

// load functions
include_once __DIR__ . '/functions.php';
if (file_exists(__DIR__ . '/polyfills.php')) {
	include_once __DIR__ . '/polyfills.php';
}

if (PHP_SAPI !== 'cli' && realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME']) && !is_user_admin_back_end()) {
	header('Cache-Control: no-store');
	if ($_SERVER['REQUEST_METHOD'] !== 'GET' || isset($_GET['do']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest') {
		http_response_code(403);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['success' => false, 'error' => 'Administrator access required.']);
		exit;
	}
	$returnParams = $_GET;
	unset($returnParams['username'], $returnParams['passwd'], $returnParams['login'], $returnParams['logout'], $returnParams['delete-option'], $returnParams['reset-original']);
	$returnParams['login_return'] = '1';
	$returnUrl = path2url(__FILE__) . '?' . http_build_query($returnParams);
	$loginUrl = update_url_params(['t' => urlencode($returnUrl)], path2url(__DIR__ . '/content-0.php'));
	if (!isset($_GET['login_return'])) {
		header('Location: ' . $loginUrl, true, 302);
		exit;
	}
	http_response_code(403);
	header('Content-Type: text/html; charset=utf-8');
	echo '<p>Sign-in failed or administrator access is unavailable.</p>';
	echo '<p><a href="' . htmlspecialchars($loginUrl, ENT_QUOTES, 'UTF-8') . '">Sign in again</a></p>';
	exit;
}


ob_start("setup_fm_buffer");

//security options
$allow_delete_filemanager = true; //set to false to disable delete button and delete POST request.
$allow_delete_filemanager_folder = true; //set to false to disable delete button and delete POST request.
$allow_upload_filemanager = true; //set to true to allow upload files
$allow_create_folder_filemanager = true; //set to false to disable folder creation
$allow_show_folders_filemanager = true; //set to false to hide all subdirectories
$disallowed_patterns_filemanager = ['*.php', "*.phtml"]; //must be an array, matching files not allowed to be uploaded
//$hidden_patterns_filemanager = ['*.php', '*.sh', '*.bat', '*.phtml', '*.shtml', '*.txt', '*.pem', '*.ini', '*.map', '*.md', '.*']; //matching files hidden in directory index
$hidden_patterns_filemanager = ['*.pem', '*.ini', '.*']; //matching files hidden in directory index

//patch request get file, if this file is direct call
if (!isset($_REQUEST['file']) && isset($_GET['f'])) {

	// Switch db root
	$_REQUEST['file'] = dirname($_GET['f']);
} elseif (!isset($_REQUEST['file']) or $_REQUEST['file'] == null) {

	// Switch db root
	$_REQUEST['file'] = $_SERVER['DOCUMENT_ROOT'];
}

// Security check to ensure the path is within the document root
$requestedPath = realpath($_REQUEST['file']);
$documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);

if (strpos($requestedPath, $documentRoot) !== 0) {
	// If the requested path is outside the document root, reset it to the document root
	$_REQUEST['file'] = $_SERVER['DOCUMENT_ROOT'];
}

$_REQUEST['file'] = str_replace("//", "/", $_REQUEST['file']);
$_REQUEST['file'] = str_replace("\\", "/", $_REQUEST['file']);
$_REQUEST['file'] = str_replace("\\", "/", $_REQUEST['file']);

//must be in UTF-8 or `basename` doesn't work
setlocale(LC_ALL, 'en_US.UTF-8');

$tmp_dir = dirname($_SERVER['SCRIPT_FILENAME']);
if (DIRECTORY_SEPARATOR === '\\') {
	$tmp_dir = str_replace('/', DIRECTORY_SEPARATOR, $tmp_dir);
}

$tmp = get_absolute_path($tmp_dir . '/' . $_REQUEST['file']);
if ($tmp === false) {
	err(404, 'File or Directory Not Found');
}

$file = $_REQUEST['file'] ?: '.';
if (isset($_GET['do']) && $_GET['do'] == 'list') {
	if (is_dir($file)) {

		//continue viewing
		$directory = $file;
		$result = [];
		$files = array_diff(scandir($directory), ['.', '..']);
		foreach ($files as $entry) {

			if (!is_entry_ignored($entry, $allow_show_folders_filemanager, $hidden_patterns_filemanager)) {

				$i = $directory . '/' . $entry;
				$stat = stat($i);

				$test = is_writable($directory);
				if (is_dir($i)) {

					$result[] = [
						'mtime' => $stat['mtime'],
						'size' => $stat['size'],
						'name' => basename($i),
						'path' => preg_replace('@^\./@', '', $i),
						'url' => path2url(preg_replace('@^\./@', '', $i)), //abort
						'is_dir' => is_dir($i),
						'is_deleteable' => $allow_delete_filemanager_folder && ((!is_dir($i)) ||
							(is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
						'is_readable' => is_readable($i),
						'is_writable' => is_writable($i),
						'is_executable' => is_executable($i),
					];
				} else {

					$result[] = [
						'mtime' => $stat['mtime'],
						'size' => $stat['size'],
						'name' => basename($i),
						'path' => preg_replace('@^\./@', '', $i),
						'url' => path2url(preg_replace('@^\./@', '', $i)), //abort
						'is_dir' => is_dir($i),
						'is_deleteable' => $allow_delete_filemanager && ((!is_dir($i)) ||
							(is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
						'is_readable' => is_readable($i),
						'is_writable' => is_writable($i),
						'is_executable' => is_executable($i),
					];
				}
			}
		}

		usort($result, function ($f1, $f2) {

			$f1_key = ($f1['is_dir'] ?: 2) . $f1['name'];
			$f2_key = ($f2['is_dir'] ?: 2) . $f2['name'];
			return $f1_key <=> $f2_key; //fix php 8 was > and we put <=>
		});
	} else {

		err(412, "Not a Directory");
	}


	echo json_encode(['success' => true, 'is_writable' => is_writable($file), 'results' => $result]);
	exit;

} elseif (isset($_POST['do']) && $_POST['do'] == 'delete') {
	if ($allow_delete_filemanager) {
		rmrf($file);
	}
	exit;
} elseif (isset($_POST['do']) && $_POST['do'] == 'mkdir' && $allow_create_folder_filemanager) {

	//don't allow actions outside root. we also filter out slashes to catch args like './../outside'
	$dir = $_POST['name'];
	$dir = str_replace('/', '', $dir);
	if (substr($dir, 0, 2) === '..') {
		exit;
	}

	chdir($file);
	@mkdir($_POST['name']);
	exit;

} elseif (isset($_POST['do']) && $_POST['do'] == 'upload' && $allow_upload_filemanager) {

	foreach ($disallowed_patterns_filemanager as $pattern) {

		if (fnmatch($pattern, $_FILES['file_data']['name'])) {
			err(403, "Files of this type are not allowed.");
		}
	}

	$res = move_uploaded_file($_FILES['file_data']['tmp_name'], $file . '/' . $_FILES['file_data']['name']);
	exit;

} elseif (isset($_GET['do']) && $_GET['do'] == 'download') {

	foreach ($disallowed_patterns_filemanager as $pattern) {
		if (fnmatch($pattern, $file)) {
			err(403, "Files of this type are not allowed.");
		}
	}

	$filename = basename($file);
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	header('Content-Type: ' . finfo_file($finfo, $file));
	header('Content-Length: ' . filesize($file));
	header(
		sprintf(
			'Content-Disposition: attachment; filename=%s',
			strpos('MSIE', $_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\""
		)
	);
	ob_flush();
	readfile($file);
	exit;
}

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {

	include_once str_replace('.php', ".html", __FILE__);
}
?>
