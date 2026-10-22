function changeFunc() {
	var selectBox = document.getElementById("selectBox");
	var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	$(document).ajaxStart(function () {
		$("#wait").css("display", "block");
	});
	$("#result").load(selectedValue);
	$(document).ajaxComplete(function () {
		$("#wait").css("display", "none");
	});
}

function validateForm() {
	var textareas = document.forms[0].getElementsByTagName('textarea');
	for (var i = 0; i < textareas.length; i++) {
		if (textareas[i].value == "") {
			return false;
		}
	}
	return true;
}

//get the style of elem
function getStyle(oElm, strCssRule) {
	var strValue = "";
	if (document.defaultView && document.defaultView.getComputedStyle) {
		strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
	}
	else if (oElm.currentStyle) {
		strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1) {
			return p1.toUpperCase();
		});
		strValue = oElm.currentStyle[strCssRule];
	}
	return strValue;
}

// Social sharing windows
function open_facebook_window() {
	var facebook = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(window.location.href);
	window.open(facebook, '_custom', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=556,height=410,left=50,top=50,titlebar=yes');
}
function open_twitter_window() {
	var twitter = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(window.location.href);
	window.open(twitter, '_custom', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=556,height=462,left=50,top=50,titlebar=yes');
}
function open_linkedin_window() {
	var linkedin = "https://www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(window.location.href) + "&title=&summary=&source=";
	window.open(linkedin, '_custom', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=635,height=510,left=50,top=50,titlebar=yes');
}

function mySocialFunction() {
	var height = parseInt(window.innerHeight);
	var width = parseInt(window.innerWidth);
	var scroll = document.documentElement.scrollTop + document.body.scrollTop;

	//if page is scrolled down
	if (scroll > 120) {

		document.getElementById('logo').style.borderBottom = '1px solid lightgray';
	}

	//if page is scrolled up
	if (scroll < 120) {

		document.getElementById('logo').style.borderBottom = 'none';
	}
}

function tableRankingsHoldTop() {
	var width = parseInt(window.innerWidth);
	var scroll = document.documentElement.scrollTop + document.body.scrollTop;
	if (scroll > 500) {
		if (width <= 768) {
			console.log(scroll);
			document.getElementById('moveobject').style.position = "fixed";
			document.getElementById('moveobject').style.top = "0px";
		}
	}
	if (scroll < 500) {
		if (width <= 768) {
			console.log(scroll);
			document.getElementById('moveobject').style.position = "absolute";
			document.getElementById('moveobject').style.top = "auto";
		}
	}
}

function goto(form) {
	var index = form.select.selectedIndex
	if (form.select.options[index].value != "0") {
		location = form.select.options[index].value;
	}
}

//mobile menu function replacements
function open_menu() {
	open_menu_new();
}
function close_menu() {
	close_menu_new();
}

//mobile menu function replacements
function open_menu_new() {
	document.getElementById('nav').style.display = 'block';
	document.getElementById('nav').style.transform = 'translateX(0%)'; //fallback
	document.getElementById('menud').style.display = 'none';
	document.getElementById('menux').style.display = 'block';
}
function close_menu_new() {
	document.getElementById('nav').style.display = 'none';
	document.getElementById('menux').style.display = 'none';
	document.getElementById('menud').style.display = 'block';
}

function open_search() {

	//puts searchbox id to new search
	if (document.getElementsByName("search")[0]) {
		var se = document.getElementsByName("search")[0];
		se.setAttribute("id", "searchbox");
	}

	document.getElementById('searchbox').style.display = 'block';
	document.getElementById('searchd').style.display = 'none';
	document.getElementById('searchx').style.display = 'block';
	document.getElementById("searchbox").focus();

	//detect if black and white menu function
	if (isMenudFilterInverted() && isSearchboxBackgroundWhite()) {

		//make normal black
		document.getElementById('menud').style.filter = 'invert(0%)';

		//revent back to white
		var searchxElement = document.getElementById('searchx');
		if (searchxElement) {
			searchxElement.onclick = function () {
				close_search_extra();
			};
		}
	}
}

function isMenudFilterInverted() {
	var menud = document.getElementById('menud');
	if (menud) {
		var computedStyle = window.getComputedStyle(menud);
		var filterValue = computedStyle.getPropertyValue('filter');

		return filterValue.includes('invert(100%)') || filterValue.includes('invert(1)');
	}
	return false;
}

function isSearchboxBackgroundWhite() {
	var searchbox = document.getElementById('searchbox');
	if (searchbox) {
		var computedStyle = window.getComputedStyle(searchbox);
		var backgroundColor = computedStyle.getPropertyValue('background-color');

		// Check for white background in different formats
		return backgroundColor === 'rgb(255, 255, 255)' || backgroundColor === '#ffffff' || backgroundColor === 'white';
	}
	return false;
}

function open_search_extra() {

	//puts searchbox id to new search
	if (document.getElementsByName("search")[0]) {
		var se = document.getElementsByName("search")[0];
		se.setAttribute("id", "searchbox");
	}

	document.getElementById('searchbox').style.display = 'block';
	document.getElementById('searchd').style.display = 'none';
	document.getElementById('searchx').style.display = 'block';
	document.getElementById("searchbox").focus();

	//invert colors
	if (document.getElementById('menud')) {
		document.getElementById('menud').style.filter = 'invert(0%)';
	}
	if (document.getElementById('shared')) {
		document.getElementById('shared').style.filter = 'invert(0%)';
	}
	if (document.getElementById('sharex')) {
		document.getElementById('sharex').style.filter = 'invert(0%)';
	}
}
function close_search() {
	document.getElementById('searchbox').style.display = 'none';
	document.getElementById('searchx').style.display = 'none';
	document.getElementById('searchd').style.display = 'block';
	document.getElementById("searchbox").blur();
}

function close_search_extra() {

	document.getElementById('searchbox').style.display = 'none';
	document.getElementById('searchx').style.display = 'none';
	document.getElementById('searchd').style.display = 'block';
	document.getElementById("searchbox").blur();

	//invert colors
	if (document.getElementById('menud')) {
		document.getElementById('menud').style.filter = 'invert(100%)';
	}
	if (document.getElementById('shared')) {
		document.getElementById('shared').style.filter = 'invert(100%)';
	}
	if (document.getElementById('sharex')) {
		document.getElementById('sharex').style.filter = 'invert(100%)';
	}
}




function site_url_des() {
	domain = window.location.host;
	return window.location.protocol + "//" + domain;
}

//localhost check
function is_localhost() {

	if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {

		return true;
	}
	else {
		return false;
	}
}

function str_read_after(string, char) {
	return char + string.slice(string.indexOf(char) + 1);
}

function str_between(string, char1, char2) {
	return string.split(char1).pop().split(char2)[0];
}

function strip_tags(input, allowed) {

	// making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('')

	var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi
	var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi

	return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
		return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : ''
	})
}

function elemStickAtBottom(elem) {

	if (document.body.offsetHeight < screen.availHeight) {

		//sent elem to bottom
		elem.style.position = 'fixed';
		elem.style.bottom = '0';
	}
}

//παλιά
function resizeIframe(obj) {

	//πάει στο onload του iframe
	obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
}

function resizeTextarea(element) {
	element.style.height = 'auto';
	element.style.height = element.scrollHeight + 'px';
}

function resizeTextarea2(element) {
	// Create a clone of the textarea
	var clone = document.createElement('textarea');
	clone.style.visibility = 'hidden';
	clone.style.position = 'absolute';
	clone.style.zIndex = '-1';
	clone.style.top = '0';
	clone.style.left = '0';
	clone.style.height = 'auto';
	clone.style.padding = window.getComputedStyle(element).padding;
	clone.style.width = element.offsetWidth + 'px';
	clone.value = element.value;
	document.body.appendChild(clone);

	// Get the height
	var cloneScrollHeight = clone.scrollHeight;

	// Remove the clone
	document.body.removeChild(clone);

	// Set the height of the original element
	element.style.height = cloneScrollHeight + 'px';
}

//from KOST8
function loading_start() {

	//put this function on body on load tag
	if (document.getElementById("loading-screen")) {
		document.getElementById('loading-screen').style.display = 'block';
	}
}

//From KOST8
function loading_stop() {

	//put this function on body on load tag
	if (document.getElementById("loading-screen")) {
		document.getElementById('loading-screen').style.display = 'none';
	}
}

//from time series
function format_million_billion_trillion(value) {

	var visualOfIt = value.toString();
	var visualLeng = 6;
	var maxLeng = 4;
	var letterArrayIndex = 0;
	var letterArray = ["", " Million", " Billion", ' Trillion'];
	var leng = 4;
	var slic = 1;
	for (var g = 0; g < visualOfIt.length; g++) {
		if (visualOfIt.length <= visualLeng) {
			if (leng < maxLeng) {
				leng = maxLeng;
			}
			if (visualOfIt.length === leng) {
				if (slic > 2) {
					visualOfIt = value.toString().slice(0, slic) + letterArray[letterArrayIndex];
					break;
				} else {
					visualOfIt = value.toString().slice(0, slic) + "," + value.toString().slice(slic, 3) + letterArray[letterArrayIndex];
					break;
				}

			} else {
				leng++;
				slic++;
			}
		} else {
			maxLeng += 3;
			visualLeng += 3;
			letterArrayIndex++;
		}
	}
	return visualOfIt;
}

//from time series
function addCommas(value) {

	value += '';
	x = value.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1;
}

//old function found in html pages
function AddToFaves_hp() {
	var is_4up = parseInt(navigator.appVersion);
	var is_mac = navigator.userAgent.toLowerCase().indexOf("mac") != -1;
	var is_ie = navigator.userAgent.toLowerCase().indexOf("msie") != -1;
	var thePage = location.href;
	if (thePage.lastIndexOf('#') != -1)
		thePage = thePage.substring(0, thePage.lastIndexOf('#'));
	if (is_ie && is_4up && !is_mac)
		window.external.AddFavorite(thePage, document.title);
	else if (is_ie || document.images)
		booker_hp = window.open(thePage, 'booker_', 'menubar,width=325,height=100,left=140,top=60');
}

function open_window(width = 635, height = 510) {

	window.open('', '_custom', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=' + width + ',height=' + height + 'left=50,top=50,titlebar=yes');
}

function open_image_src(element) {
	var src = element.src;
	window.open(src, '_custom', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left=50,top=50,titlebar=yes');
}

function get_extension(path) {

	//src: https://stackoverflow.com/questions/190852/how-can-i-get-file-extensions-with-javascript/
	var basename = path.split(/[\\/]/).pop(),  //extract file name from full path ...
		//(supports `\\` and `/` separators)
		pos = basename.lastIndexOf(".");       //get last position of `.`

	if (basename === "" || pos < 1)            //if file name is empty or ...
		return "";                             // `.` not found (-1) or comes first (0)

	return basename.slice(pos + 1);            //extract extension ignoring `.`
}

function setUrlParam(name, value) {
	const url = new URL(window.location.href);
	const urlParams = url.searchParams;

	urlParams.set(name, value);
	window.history.pushState({}, '', url.toString());
}

//get url parameter
function getParam(param) {

	return new URLSearchParams(window.location.search).get(param);
}

function removeUrlParam(name) {
	const url = new URL(window.location.href);
	const urlParams = url.searchParams;
	urlParams.delete(name);
	window.history.pushState({}, '', url.toString());
}

// Helper function to get cookie value
function getCookie(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
	return null;
}

function get_file_path_from_url() {

	return window.location.pathname.slice(1);
}

function get_domain_from_url(url = false) {

	//note: not tested
	if (url == true) {

		url = url.replace("https://www.", "/");
		url = url.replace("http://www.", "/");
		url = url.replace("https://", "/");
		url = url.replace("http://", "/");
		domain = str_between(url, "/", "/");
		return domain;
	}
	else {
		domain = window.location.host;
		return domain;
	}
}

function url2path(url, domain_root = false, use_allways_html = false) {

	//the file path could always outputs an index.html or index.php because else will go to a directory
	//following the same method as url2path in php

	//please not put an file:/// because is a pure file path

	//remove query from url
	url = url.split("?")[0];

	//check if index is missing from url and was on dir
	if (get_file_path_from_url(url).endsWith("/")) {

		check_url = site_url_des() + "/" + get_file_path_from_url(url) + "index.php";
		if (use_allways_html == true) {

			file = get_file_path_from_url(url) + "index.html";
		}
		else if (is_working(site_url_des() + "/" + get_file_path_from_url(url) + "/index.php")) {

			file = get_file_path_from_url(url) + "index.php";
		}
		else {

			file = get_file_path_from_url(url) + "index.html";
		}
	}

	//check if index is missing from url and was domain host root
	else if (get_file_path_from_url(url) == '') {

		check_url = site_url_des() + "/index.php";
		if (use_allways_html == true) {

			file = "/index.html";
		}
		else if (is_working(check_url)) {

			file = "/index.php";
		}
		else {

			file = "/index.html";
		}
	}

	//if index is not missing then get path
	else {

		file = get_file_path_from_url(url);
	}

	var domain = get_domain_from_url(url);

	//check operated system
	let userAgent = window.navigator.userAgent;
	if (userAgent.indexOf("Win") != -1) os = "Windows";
	if (userAgent.indexOf("Mac") != -1) os = "MacOS";
	if (userAgent.indexOf("X11") != -1) os = "UNIX";
	if (userAgent.indexOf("Linux") != -1) os = "Linux";

	if (os == 'Windows') {

		if (domain_root == false) {

			domain_root = "C:/Projects";
		}
		return domain_root + "/" + domain + "/" + file;
	} else {

		if (domain_root == false) {

			domain_root = "/home/user/projects";
		}
		return domain_root + "/" + domain + "/" + file;
	}
}

function is_working(url) {

	var http = new XMLHttpRequest();
	http.open('HEAD', url, false);
	http.send();
	return http.status == 200;
}

function getElementsByAttribute(doc, tagArray, attribute, attributeValue) {
	var elementArray = new Array();
	var matchedArray = new Array();
	if (doc == null || doc == undefined) {
		var doc = document.documentElement;
	}
	else { }
	if (tagArray == null || tagArray == undefined) {
		if (doc.all) {
			elementArray = doc.all;
		}
		if (document.all) {
			elementArray = doc.all;
		}
		else {
			elementArray = document.getElementsByTagName("*");
		}
	}
	else {
		elementArray = tagArray;
	}
	for (var i = 0; i < elementArray.length; i++) {
		if (attribute == "class") {
			var pattern = new RegExp("(^| )" + attributeValue + "( |$)");
			if (pattern.test(elementArray[i].className)) {
				matchedArray[matchedArray.length] = elementArray[i];
			}
		}
		else if (attribute == "for") {
			if (elementArray[i].getAttribute("htmlFor") || elementArray[i].getAttribute("for")) {
				if (elementArray[i].htmlFor == attributeValue) {
					matchedArray[matchedArray.length] = elementArray[i];
				}
			}
		}
		else if (elementArray[i].getAttribute(attribute) == attributeValue) {
			matchedArray[matchedArray.length] = elementArray[i];
		}
	}
	return matchedArray;
}

//jquery extensions
document.addEventListener("DOMContentLoaded", function (event) {
	if (window.jQuery) {
		jQuery.fn.extend({
			toggleText: function (a, b) {
				var that = this;
				if (that.text() != a && that.text() != b) {
					that.text(a);
				}
				else
					if (that.text() == a) {
						that.text(b);
					}
					else
						if (that.text() == b) {
							that.text(a);
						}
				return this;
			}
		});
	}
});
//fix textareas after html format
window.addEventListener("load", function (event) {
	//το μετατρέψαμε σε javascript
	var arr_elms = document.body.getElementsByTagName("textarea");
	var elms_len = arr_elms.length;
	for (var i = 0; i < elms_len; i++) {
		s = arr_elms[i].value;
		s = s.replace(/(^\s*)|(\s*$)/gi, "");
		s = s.replace(/[ ]{2,}/gi, " ");
		s = s.replace(/\n /, "\n");
		arr_elms[i].value = s;
	}
	//stop loading icons if any
	loading_stop();
});

function is_image(file) {
	const imageExtensions = [
		'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp',
		'tiff', 'tif', 'raw', 'ico', 'heic', 'heif',
		'jfif', 'jp2', 'jpx', 'j2k', 'j2c', 'fpx',
		'pcd', 'avif', 'jxl', 'cr2', 'nef', 'arw',
		'dng', 'raf', 'rw2', 'orw', 'pef', 'srw'
	];
	const fileExtension = file.name.split('.').pop().toLowerCase();
	return imageExtensions.includes(fileExtension);
}

function is_text(file) {
	const textExtensions = [
		// Common text files
		'txt', 'log', 'csv', 'md', 'rtf', 'diff', 'patch', 'text',
		'asc', 'pot', 'readme', 'changes', 'changelog', 'news',
		'install', 'todo', 'license', 'authors', 'contributors',

		// Web development
		'html', 'htm', 'xhtml', 'css', 'scss', 'sass', 'less',
		'js', 'jsx', 'ts', 'tsx', 'json', 'xml', 'yaml', 'yml',
		'svg', 'php', 'phtml', 'asp', 'aspx', 'jsp', 'vue', 'twig',
		'mustache', 'handlebars', 'hbs', 'ejs', 'haml', 'jade', 'pug',
		'liquid', 'cshtml', 'razor', 'mjs', 'cjs', 'webmanifest',

		// Programming languages
		'c', 'cpp', 'h', 'hpp', 'cs', 'java', 'py', 'rb', 'pl',
		'sql', 'sh', 'bash', 'r', 'swift', 'go', 'rust', 'kt',
		'scala', 'lua', 'perl', 'vb', 'ps1', 'psm1', 'f90', 'f95',
		'f03', 'nim', 'zig', 'tcl', 'ml', 'mli', 'erl', 'ex', 'exs',
		'clj', 'cls', 'groovy', 'gvy', 'hs', 'lhs', 'pas', 'p', 'pp',
		'inc', 'm', 'mm', 'rex', 'rexx', 'raku', 'rakumod', 'rakudoc',
		'dart', 'v', 'ada', 'adb', 'ads', 'vhdl', 'vhd', 'fs', 'fsx',
		'fsi', 'fsscript', 'gradle', 'jl', 'elm', 'el', 'lisp', 'lsp',
		'scm', 'ss', 'rkt', 'rktl', 'rktd', 'scrbl', 'asm', 'nasm',

		// Operating system scripts
		'bat', 'cmd', 'ps1', 'vbs', 'sh', 'bash', 'zsh', 'fish',
		'csh', 'tcsh', 'ksh', 'rc', 'profile', 'bashrc', 'zshrc',
		'fishrc', 'inputrc', 'login', 'logout', 'cshrc', 'zlogin',
		'zlogout', 'zprofile', 'dircolors', 'minttyrc', 'curlrc',
		'wgetrc', 'npmrc', 'yarnrc', 'screenrc', 'vimrc', 'gvimrc',
		'bash_profile', 'bash_logout', 'bash_aliases', 'powershell',

		// Configuration files
		'ini', 'conf', 'config', 'cfg', 'env', 'properties',
		'htaccess', 'htpasswd', 'nginx', 'dockerignore', 'lock',
		'gitignore', 'npmrc', 'babelrc', 'eslintrc', 'passwd',
		'prettierrc', 'editorconfig', 'cnf', 'service', 'shadow',
		'desktop', 'policy', 'rules', 'path', 'exports', 'sudoers',
		'hosts', 'hostname', 'fstab', 'group', 'crontab', 'mime.types',
		'resolv.conf', 'sshd_config', 'ssh_config', 'dhcpd.conf',
		'dnsmasq.conf', 'my.cnf', 'php.ini', 'httpd.conf', 'xorg.conf',

		// Build and deployment
		'cmake', 'make', 'mak', 'mk', 'rakefile', 'dockerfile',
		'vagrantfile', 'jenkinsfile', 'gemfile', 'modulefile',
		'procfile', 'apspec', 'bzl', 'bazel', 'workflow', 'gitlab-ci',
		'travis', 'appveyor', 'azure-pipelines', 'makefile', 'ninja',
		'pom', 'build', 'gradle', 'ant', 'ivy', 'maven', 'sbt',

		// Documentation
		'tex', 'rst', 'adoc', 'textile', 'wiki', 'man',
		'markdown', 'mkd', 'mkdn', 'mdwn', 'mdown', 'mdtxt',
		'mdtext', 'pod', 'dokuwiki', 'mediawiki', 'creole',
		'org', 'rdoc', 'roff', 'asciidoc', 'texi', 'texinfo',

		// Data formats
		'csv', 'tsv', 'toml', 'properties', 'dist', 'template',
		'tml', 'raml', 'wadl', 'xaml', 'xslt', 'xsl', 'xsd',
		'dtd', 'rnc', 'rng', 'sch', 'ldif', 'graph', 'dot',
		'gql', 'graphql', 'ndjson', 'jsonl', 'geojson', 'regex',

		// System files
		'pid', 'lock', 'socket', 'device', 'mount', 'timer',
		'target', 'snapshot', 'backup', 'swp', 'tmp', 'temp',
		'state', 'cache', 'log', 'run', 'running', 'status',
		'lease', 'table', 'dat', 'local', 'opts', 'prefs'];

	// Get the file extension, handling special cases
	let fileExtension = '';
	const fileName = file.name.toLowerCase();

	// Handle files that start with a dot (like .htaccess)
	if (fileName.startsWith('.') && fileName.indexOf('.', 1) === -1) {
		// File like .htaccess (no extension after the dot)
		fileExtension = fileName.substring(1);
	} else {
		// Regular file with extension
		const parts = fileName.split('.');
		if (parts.length > 1) {
			fileExtension = parts.pop();
		} else {
			// File with no extension
			fileExtension = fileName;
		}
	}

	return textExtensions.includes(fileExtension);
}

function isSupportedFilesWhirlpool(file) {
	return is_image(file) || is_text(file) || /\.(pdf|docx?|xlsx?)$/i.test(file.name);
}

// Slugify function for tool names (general utility)
function slugify(str) {
	if (typeof str !== 'string') return '';
	return str
		.toLowerCase()
		.replace(/[^a-z0-9]+/g, '-')
		.replace(/^-+|-+$/g, '');
}

/**
 * Escape HTML special characters to prevent XSS
 * @param {string} unsafe - String to escape
 * @returns {string} Escaped string
 */
function escapeHtml(unsafe) {
	const map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	};
	return String(unsafe).replace(/[&<>"']/g, m => map[m]);
}

function removeComments(node) {
	const childNodes = Array.from(node.childNodes);
	childNodes.forEach((child) => {
		if (child.nodeType === Node.COMMENT_NODE) {
			child.remove();
		} else if (child.nodeType === Node.ELEMENT_NODE) {
			removeComments(child);
		}
	});
}

function stripParagraphTags(html) {
	if (!html || typeof html !== 'string') {
		return '';
	}

	const trimmed = html.trim();
	return trimmed.replace(/^<p[^>]*>/i, '').replace(/<\/p>$/i, '');
}

/**
 * HTML to Text Converter - Mimics browser's innerText behavior
 * This is an independent simulator that replicates what the native innerText API does:
 * - Respects CSS display rules (hidden elements are excluded)
 * - Preserves visual structure with appropriate line breaks
 * - Removes script/style tags
 * - Mimics how text appears visually on screen
 * 
 * NOTE: The actual code uses native browser innerText API (for blockquotes) 
 * and textContent API (for code blocks). This function is a standalone 
 * implementation for reference/understanding purposes only.
 * 
 * @param {string|HTMLElement} input - HTML string or DOM element
 * @returns {string} - Plain text with visual structure preserved
 */
function htmlToText(input) {
	// Parse HTML string to DOM if needed
	let element;
	if (typeof input === 'string') {
		const parser = new DOMParser();
		const doc = parser.parseFromString(input, 'text/html');
		element = doc.body;
	} else {
		element = input;
	}

	// Block-level elements that should add newlines
	const blockElements = new Set([
		'ADDRESS', 'ARTICLE', 'ASIDE', 'BLOCKQUOTE', 'DETAILS', 'DIALOG', 'DD', 'DIV',
		'DL', 'DT', 'FIELDSET', 'FIGCAPTION', 'FIGURE', 'FOOTER', 'FORM', 'H1', 'H2',
		'H3', 'H4', 'H5', 'H6', 'HEADER', 'HGROUP', 'HR', 'LI', 'MAIN', 'NAV', 'OL',
		'P', 'PRE', 'SECTION', 'TABLE', 'UL'
	]);

	// Elements that create double newlines (paragraph-like)
	const paragraphElements = new Set(['P', 'DIV', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6']);

	// Elements to completely skip (including their content)
	const skipElements = new Set(['SCRIPT', 'STYLE', 'NOSCRIPT', 'IFRAME']);

	/**
	 * Recursively extract text from DOM node
	 */
	function extractText(node, depth = 0) {
		// Skip if node doesn't exist
		if (!node) return '';

		// Handle text nodes
		if (node.nodeType === Node.TEXT_NODE) {
			return node.textContent || '';
		}

		// Skip non-element nodes (comments, etc.)
		if (node.nodeType !== Node.ELEMENT_NODE) {
			return '';
		}

		const tagName = node.tagName;

		// Skip script/style tags
		if (skipElements.has(tagName)) {
			return '';
		}

		// Check if element is hidden via CSS
		if (node.style && node.style.display === 'none') {
			return '';
		}
		if (node.style && node.style.visibility === 'hidden') {
			return '';
		}

		// Handle <br> tags - convert to newline
		if (tagName === 'BR') {
			return '\n';
		}

		// Handle <hr> tags - convert to newline
		if (tagName === 'HR') {
			return '\n';
		}

		let text = '';
		let addNewlineBefore = false;
		let addNewlineAfter = false;

		// Determine if we need newlines around this element
		if (blockElements.has(tagName)) {
			addNewlineBefore = true;
			addNewlineAfter = true;
		}

		// Add opening newline for block elements
		if (addNewlineBefore && depth > 0) {
			text += '\n';
		}

		// Process child nodes recursively
		for (let child of node.childNodes) {
			text += extractText(child, depth + 1);
		}

		// Add closing newline for block elements
		if (addNewlineAfter) {
			// Paragraph elements get double newline for spacing
			if (paragraphElements.has(tagName)) {
				text += '\n\n';
			} else if (tagName === 'LI') {
				// List items get single newline
				text += '\n';
			} else {
				text += '\n';
			}
		}

		return text;
	}

	// Extract text and clean up excessive newlines
	let result = extractText(element);

	// Clean up: collapse multiple consecutive newlines to max 2
	result = result.replace(/\n{3,}/g, '\n\n');

	// Trim leading/trailing whitespace
	result = result.trim();

	return result;
}
