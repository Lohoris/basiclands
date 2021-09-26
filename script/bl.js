// (c) 2010 Lorenzo Petrone, tutti i diritti riservati (all rights reserved).

function language () {
	apdisp('language_button','none');
	apdisp('language_wait','');
	
	var name=apvalue('language_name');
	var code=apvalue('language_code');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=language_handler;
	req.open("GET",AJURL+"language_new?name="+name+"&code="+code);
	req.send(null);
}
function language_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('language_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		apinner('language_div',rs[1]);
	}
	else {
		// errore
		error('language_',rs[1]);
	}
}
function toggle_active_lang (lang_id) {
	clears('language_');
	apinner("toggle_active_lang_button#"+lang_id,apinner('waiter'));
	
	req=new XMLHttpRequest();
	req.onreadystatechange=language_handler;
	req.open("GET",AJURL+"toggle_active?what=lang&lang_id="+lang_id);
	req.send(null);
}

function seth (event) {
	var ch=event.which;
	if (ch==13) {
		// invio
		setx();
		return false;
	}
	else if (ch==32) {
		// spazio
		lands_switch();
		return false;
	}
	else {
		return true;
	}
}
function setr (event) {
	var ch=event.which;
	if (ch==13) {
		// invio
		setx();
		return false;
	}
	else if (ch==32) {
		// spazio
		repeat_switch();
		return false;
	}
	else {
		return true;
	}
}
function setx () {
	apdisp('set_button','none');
	apdisp('set_wait','');
	
	var name=apvalue('name');
	var code=apvalue('code');
	var mcic=apvalue('mcic');
	var land_mode=apvalue('lands_sel');
	var land;
	
	if (land_mode=='default') {
		land="&land="+apvalue('lands_default_val');
	}
	else if (land_mode=='complex') {
		land="&repeat="+apvalue('repeat_sel')+"&repeat_lands="+apvalue('lands_complex_val')+"&repeat_amount="+apvalue('repeat_amount');
	}
	else {
		error('set_','Unknown land mode: '+land_mode);
		return false;
	}
	
	req=new XMLHttpRequest();
	req.onreadystatechange=set_handler;
	req.open("GET",AJURL+"set_new?name="+name+"&code="+code+"&mci_code="+mcic+land);
	req.send(null);
}
function set_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('set_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		apinner('set_div',rs[1]);
		apinner('checklist_div',rs[2]);
	}
	else {
		// errore
		error('set_',rs[1]);
	}
}
function lands_switch () {
	var current=apvalue('lands_sel'),other;
	if (current=='default') other='complex';
	else other='default';
	
	apdisp('lands_'+current,'none');
	apvalue('lands_sel',other);
	apdisp('lands_'+other,'');
	apfocus('lands_'+other+'_val');
}
function repeat_switch () {
	var current=apvalue('repeat_sel'),other;
	if (current=='stretch') other='copy';
	else other='stretch';
	
	apdisp('repeat_'+current,'none');
	apvalue('repeat_sel',other);
	apdisp('repeat_'+other,'');
	apfocus('repeat');
}
function lang_toggle (set_id, lang_id, new_value) {
	apinner("lang#"+set_id+"_"+lang_id,apinner('waiter'));
	
	req=new XMLHttpRequest();
	req.onreadystatechange=lang_toggle_handler;
	req.open("GET",AJURL+"lang_toggle?set_id="+set_id+"&lang_id="+lang_id+"&new_value="+new_value);
	req.send(null);
}
function lang_toggle_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('language_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		apinner('set_div',rs[1]);
		//apinner('checklist_div',rs[2]);
	}
	else {
		// errore
		error('language_',rs[1]);
	}
}
function set_langs_do_edit (set_id) {
	apdisp('set_langs_show#'+set_id,'none');
	apdisp('set_langs_edit#'+set_id,'');
}
function set_langs_do_show (set_id) {
	apdisp('set_langs_edit#'+set_id,'none');
	apdisp('set_langs_show#'+set_id,'');
}
function toggle_active_set (set_id) {
	clears('set_');
	apinner("toggle_active_set_button#"+set_id,apinner('waiter'));
	
	req=new XMLHttpRequest();
	req.onreadystatechange=set_handler;
	req.open("GET",AJURL+"toggle_active?what=set&set_id="+set_id);
	req.send(null);
}

function cane (event, chmax, land_id, next_id) {
	var submit=false;
	var ch=event.which;
	var scur; // stringa corrente (value)
	var ival; // valore finale
	var nval; // numero nuovo
	var len; // lunghezza numero totale
	
	scur=apvalue('land#'+land_id); // valore corrente ESCLUSO quello appena premuto
	ival=parseInt(scur);
	if (ch==13) {
		// invio
		submit=true;
	}
	else {
		len=scur.length;
		if (len<chmax) {
			// non è ancora al massimo, vediamo se aggiungervi un carattere
			nval=ch-48;
			if (nval>=0 && nval<=9) {
				ival=ival*10+nval;
				len++;
			}
			else {
				return false;
			}
		}
		
		if (len>=chmax) {
			submit=true;
		}
	}
	
	if (submit) {
		land_submit(parseInt(land_id),ival,next_id);
	}
}
function land_submit (land_id, number, next_id) {
	apdisp('land#'+land_id,'none');
	apdisp('land_wait#'+land_id,'');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=land_handler;
	req.open("GET",AJURL+"land?land_id="+land_id+"&number="+number+"&next_id="+next_id);
	req.send(null);
}
function spread_submit (spread_id, number, set_id, from, to) {
	apdisp('land#'+spread_id,'none');
	apdisp('land_wait#'+spread_id,'');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=land_handler;
	req.open("GET",AJURL+"land?spread_id="+spread_id+"&number="+number+"&set_id="+set_id+"&from="+from+"&to="+to);
	req.send(null);
}
function land_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		rerror('ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var ii=0;
	var status=rs[ii++];
	var land_id=rs[ii++];
	var number=rs[ii++];
	var next_id=rs[ii++];
	var content=rs[ii++];
	
	if (status=="OK") {
		apinner('checklist_div',content);
		if (next_id) {
			document.getElementById('land#'+next_id).focus();
		}
	}
	else {
		// errore
		rerror(rs[1]);
	}
}
function set_refresh () {
	apdisp('set_refresh_button','none');
	apdisp('set_refresh_wait','');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=land_handler;
	req.open("GET",AJURL+"land?refresh");
	req.send(null);
}
function own_toggle (land_id, lang_id, new_value) {
	apinner("have#"+land_id+"_"+lang_id,apinner('waiter'));
	
	req=new XMLHttpRequest();
	req.onreadystatechange=land_handler;
	req.open("GET",AJURL+"land?toggle_id="+land_id+"&lang_id="+lang_id+"&new_value="+new_value);
	req.send(null);
}

function show_land (mci_code, number) {
	apinner('show_land_image','<img src="http://magiccards.info/scans/en/'+mci_code+'/'+number+'.jpg" alt="Land preview">')
}
