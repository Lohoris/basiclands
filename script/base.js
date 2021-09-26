/*	(c) 2006-2011 Lorenzo Petrone
	use as you wish, as long as you give credits
	I take no responsability for any reason
*/

function apclass (name, Class) {
	var el=document.getElementById(name);
	if (!el) return false;
	el.className=Class;
	return true;
}
function apdisp (name, disp, allowfail) {
	allowfail = typeof(allowfail) != 'undefined' ? allowfail : true;
	var el=document.getElementById(name);
	if (!el && allowfail) return false;
	el.style.display=disp;
	return true;
}
function apinner (id, text) {
	var el=document.getElementById(id);
	if (typeof(text)!='undefined') {
		el.innerHTML=text;
	}
	return el.innerHTML;		
}
function apvalue (id, value) {
	var el=document.getElementById(id);
	if (typeof(value)!='undefined') {
		el.value=value;
	}
	else if (!el) {
		return null;
	}
	return el.value;
}
function apchecked (id, value) {
	var el=document.getElementById(id);
	if (typeof(value)!='undefined') {
		el.checked=value;
	}
	return el.checked;		
}
function apfocus (id) {
	return document.getElementById(id).focus();
}

function limit (val, min, max) {
	if (val<min) return min;
	if (val>max) return max;
	return val;
}

function apheight (id, height) {
	var el=document.getElementById(id);
	if (typeof(height)=='number') {
		el.style.height=height+'px';
	}
	else if (!el) {
		return null;
	}
	if (typeof(height)=='string') {
		return parseInt(el.clientHeight);
	}
	return parseInt(el.scrollHeight);
}
function apmaxheight (id, height) {
	var el=document.getElementById(id);
	el.style.maxHeight=height+'px';
}

function apwidth (id, width) {
	var el=document.getElementById(id);
	if (typeof(width)=='number') {
		el.style.width=width+'px';
	}
	else if (!el) {
		return null;
	}
	if (typeof(width)=='string') {
		return parseInt(el.clientWidth);
	}
	return parseInt(el.scrollWidth);
}
function apmaxwidth (id, width) {
	var el=document.getElementById(id);
	el.style.maxWidth=width+'px';
}

// http://www.openjs.com/scripts/dom/class_manipulation.php
function hasClass (ele, cls) {
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}
function addClass (ele, cls) {
	if (!this.hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass (ele, cls) {
	if (hasClass(ele,cls)) {
		var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
		ele.className=ele.className.replace(reg,' ');
	}
}

function rerror (text) {
	apinner('error_text',text);
	apdisp('error','');
}
function error (prefix, text) {
	apinner('error_text',text);
	apdisp(prefix+'wait','none');
	apdisp('error','');
	if (document.getElementById(prefix+'checkb')) {
		apdisp(prefix+'checkb','');
	}
	else {
		apdisp(prefix+'button','');
		if (document.getElementById(prefix+'submit'))
			apdisp(prefix+'submit','');
	}
}
function clears (prefix) {
	apdisp('error','none');
	apdisp(prefix+'wait','none');
	if (document.getElementById(prefix+'checkb')) {
		apdisp(prefix+'button','none');
		apdisp(prefix+'checkb','');
	}
	else {
		apdisp(prefix+'button','');
	}
}

function fragment () {
	return unescape(location.href.split('#').slice(1).join('#'));
}

function kill_enter (e) {
	return;
	/* TODO° fix
	var key = e ? event.which : window.event.keyCode;
	if (!e.originalTarget) return key;
	if (e.originalTarget.tagName=='TEXTAREA') return key;
	else if (e.originalTarget.tagName=='A') return key;
	else return key!=13;
	*/
}

function button_showp (ida, idb) {
	button_none(''+ida+'');
	apdisp(ida+'_'+idb,'');
}
function button_hidep (ida, idb) {
	apdisp(ida+'_'+idb,'none');
}

function notright (event) {
	return (event.which<2 && !event.metaKey);
}

function dechex (dec) {
	return dec.toString(16);
}
function hexdec (hex) {
	return parseInt(hex,16);
}

function xnl (str) {
	return str.replace(/<br>/g,"\n");
}

function enter_submit (event, fnc, arg) {
	arg = typeof(arg) != 'undefined' ? arg : null;
	var ch=event.which;
	if (ch==13) {
		if (arg===null) {
			fnc();
		}
		else {
			fnc(arg);
		}
	}
	return true;
}
