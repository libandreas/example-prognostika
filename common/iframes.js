//from kost8 αυτό πάει μέσα στη σελίδα του iframe
function resizeIframePostMessage() {

	//πάει μέσα στο iframe στο body στο onload ή όπου θέλουμε να κάνουμε update το iframe
	var body = document.body,
		html = document.documentElement,
		height = Math.max(body.scrollHeight, body.offsetHeight,
			html.clientHeight, html.scrollHeight, html.offsetHeight);

	if (parent.postMessage) {
		parent.postMessage(height, "*"); //post it to any url
	}
}

//from KOST8, πάει στο iframe, όχι μέσα στη σελίδα
function resizeIframeReceiveMessage(obj) {

	//πάει στο onload του iframe
	var iframe_resize = function (event) {

		//Resize
		if (obj) {
			obj.style.height = event.data + "px";
		}
	};
	if (window.addEventListener) {

		window.addEventListener("message", iframe_resize, false);
	} else if (window.attachEvent) {

		window.attachEvent("onmessage", iframe_resize);
	}
}

//run this function after the page is loaded
window.addEventListener('load', resizeIframePostMessage);

//from kost8 αυτό πάει μέσα στη σελίδα του iframe
function resizeIframePostMessage() {

	//πάει μέσα στο iframe στο body στο onload ή όπου θέλουμε να κάνουμε update το iframe
	var body = document.body,
		html = document.documentElement,
		height = Math.max(body.scrollHeight, body.offsetHeight,
			html.clientHeight, html.scrollHeight, html.offsetHeight);

	if (parent.postMessage) {
		parent.postMessage(height, "*"); //post it to any url
	}
}

//from KOST8, πάει στο iframe, όχι μέσα στη σελίδα
function resizeIframeReceiveMessage(obj) {

	//πάει στο onload του iframe
	var iframe_resize = function (event) {

		//Resize
		if (obj) {
			obj.style.height = event.data + "px";
		}
	};
	if (window.addEventListener) {

		window.addEventListener("message", iframe_resize, false);
	} else if (window.attachEvent) {

		window.attachEvent("onmessage", iframe_resize);
	}
}

//run this function after the page is loaded
window.addEventListener('load', resizeIframePostMessage);