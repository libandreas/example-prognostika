//this file will make inline styles for desktop and mobile, the script will be activate style-mobile and style-desktop attributes, the style-mobile will merged to style when a mobile screen found, and same with style-desktop

//the core function, clean styles from desktop and mobile and re generate
function setup_inline_styles(mobile, desktop) {

	var arr_elms = [];
	var arr_elms = document.getElementsByTagName("*");
	var elms_len = arr_elms.length;
	var style_new;
	var style_desktop;
	var style_mobile;
	for (var i = 0; i < elms_len; i++) {

		//read mobile styles
		if (arr_elms[i].hasAttribute('style-mobile')) {

			style_mobile = arr_elms[i].getAttribute("style-mobile");
		}
		else {

			style_mobile = null;
		}

		//read desktop styles
		if (arr_elms[i].hasAttribute('style-desktop')) {

			style_desktop = arr_elms[i].getAttribute("style-desktop");
		}
		else {

			style_desktop = null;
		}

		//read styles generic
		if (arr_elms[i].hasAttribute('style')) {

			//read styles
			style = arr_elms[i].getAttribute("style");
		}
		else {
			style = null;
		}

		//add desktop styles if they exists
		if (mobile == true) {

			if (arr_elms[i].hasAttribute('style-mobile')) {

				style_new = style_new + ";" + style_mobile;
				style_new = style_new.replace(";;", ';');

				//edo ta vazei gamoto
				arr_elms[i].setAttribute("style", style_new);
			}
		}

		//add mobile styles if they exists
		else if (desktop == true) {

			if (arr_elms[i].hasAttribute('style-desktop')) {

				style_new = style_new + ";" + style_desktop;
				style_new = style_new.replace(";;", ';');

				//edo ta vazei gamoto
				arr_elms[i].setAttribute("style", style_new);
			}
		}
	}
}

//process inline responsive styles
//note: μόνο αυτό θα τρέχει με DOMContentLoaded και θα τρέχει χωρίς async ή defer
document.addEventListener("DOMContentLoaded", function (event) {

	if (window.screen.availWidth <= 600) {

		//mobile emulates @media screen and (max-width: 600px) {
		setup_inline_styles(true, false);
	}

	else {

		//desktop emulates the @media screen and (min-width: 601px) {
		setup_inline_styles(false, true);
	}
});

//check if use resize window and re fire up styles
window.addEventListener("resize", function (event) {

	if (window.screen.availWidth <= 600) {

		//mobile emulates @media screen and (max-width: 600px) {
		setup_inline_styles(true, false);
	}

	else {

		//desktop emulates the @media screen and (min-width: 601px) {
		setup_inline_styles(false, true);
	}
});