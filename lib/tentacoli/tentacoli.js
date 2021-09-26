// (c) 2009-2011 Lorenzo Petrone, tutti i diritti riservati (all rights reserved).

var hide_calls=new Array();
function show_content (rname, id) {
	var div,disp,dsh;
	
	// nasconde i tentacoli
	for (var ii=0; ; ii++) {
		div=document.getElementById(rname+'_'+ii);
		if (!div) break;
		if (ii==id) {
			dsh=div;
			continue;
		}
		div.style.display='none';
	}
	
	// nascondini addizionali
	for (var cb in hide_calls) {
		hide_calls[cb]();
	}
	
	if (!dsh) return;
	location.replace('#'+rname+'_'+id);
	
	dsh.style.display='';
}

function adjust_background (image) {
	var img=document.getElementById(image);
	if (!img) return;
	
	var img_w=img.width;
	var img_h=img.height;
	
	var win_w=window.innerWidth;
	var win_h=window.innerHeight;
	
	var dw=win_w/img_w;
	var dh=win_h/img_h;
	
	var new_w,new_h;
	if (dw>dh) {
		// il lato corto è la larghezza
		new_h=win_h;
		new_w=img_w*dh;
	}
	else {
		new_w=win_w;
		new_h=img_h*dw;
	}
	
	img.width=new_w;
	img.height=new_h;
	document.getElementById(image).style.display='';
}

function adjust_image (image, div, scale) {
	scale = typeof(scale) != 'undefined' ? scale : 1;
	
	var img=document.getElementById(image);
	if (!img) return;
	
	var img_w=img.width;
	var img_h=img.height;
	
	var win=document.getElementById(''+div+'');
	var win_w=win.offsetWidth;
	var win_h=win.offsetHeight;
	
	var dw=win_w/img_w;
	var dh=win_h/img_h;
	
	var new_w,new_h;
	if (dw>dh) {
		// il lato corto è la larghezza
		new_h=win_h;
		new_w=img_w*dh;
	}
	else {
		new_w=win_w;
		new_h=img_h*dw;
	}
	
	img.width=new_w*scale;
	img.height=new_h*scale;
	document.getElementById(image).style.display='';
}
