// (c) 2009 Lorenzo Petrone, tutti i diritti riservati (all rights reserved).

function login () {
	apdisp('login_button','none');
	apdisp('login_waiter','');
	
	var user=apvalue('user');
	var pass=apvalue('pass');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=login_handler;
	req.open("GET",AJURL+"login?user="+user+"&pass="+pass);
	req.send(null);
}
function login_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('login_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		apinner(''+bodi+'',rs[1]);
		apinner(''+menu_Queue+'',rs[2]);
		apinner(''+menu_Create+'',rs[3]);
		apinner(''+menu_Options+'',rs[4]);
		apdisp('tentacolo_menu','');
	}
	else {
		// errore
		error('login_',rs[1]);
	}
}

function logout () {
	apdisp('logout_button','none');
	apdisp('logout_waiter','');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=logout_handler;
	req.open("GET",AJURL+"login?logout");
	req.send(null);
}
function logout_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('logout_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		apdisp('tentacolo_menu','none');
		apinner(''+bodi+'',rs[1]);
		show_content(''+bodi_a+'',''+bodi_b+'');
	}
	else {
		// errore
		error('logout_',rs[1]);
	}
}

function email_change () {
	apdisp('email_button','none');
	apdisp('email_waiter','');
	
	var pass=apvalue('email_pass');
	var email=apvalue('email');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=email_change_handler;
	req.open("GET",AJURL+"email_change?email="+email+'&pass='+pass);
	req.send(null);
}
function email_change_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('email_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('options',apinner('options_done_id'));
		clears('email_');
	}
	else {
		// errore
		error('email_',rs[1]);
	}
}

function pass_change () {
	apdisp('pass_button','none');
	apdisp('pass_waiter','');
	
	var oldp=apvalue('pass_old');
	var newp=apvalue('pass_new');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=pass_change_handler;
	req.open("GET",AJURL+"pass_change?old="+oldp+'&new='+newp);
	req.send(null);
}
function pass_change_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('pass_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('options',apinner('options_done_id'));
		clears('pass_');
	}
	else {
		// errore
		error('pass_',rs[1]);
	}
}

function values_change () {
	apdisp('values_button','none');
	apdisp('values_waiter','');
	
	var hours=apvalue('hours');
	var hour_min=apvalue('hour_min');
	var hour_max=apvalue('hour_max');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=values_change_handler;
	req.open("GET",AJURL+"values_change?hours="+hours+"&hour_min="+hour_min+"&hour_max="+hour_max);
	req.send(null);
}
function values_change_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('values_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('options',apinner('options_done_id'));
		apvalue('hours',rs[1]);
		apvalue('hour_min',rs[2]);
		apvalue('hour_max',rs[3]);
		clears('values_');
	}
	else {
		// errore
		error('values_',rs[1]);
	}
}

function twitter_change () {
	apdisp('twitter_button','none');
	apdisp('twitter_waiter','');
	
	var user=apvalue('twitter_usr');
	var pass=apvalue('twitter_pwd');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=twitter_change_handler;
	req.open("GET",AJURL+"twitter_change?user="+user+'&pass='+pass);
	req.send(null);
}
function twitter_change_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('twitter_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('options',apinner('options_done_id'));
		clears('twitter_');
	}
	else {
		// errore
		error('twitter_',rs[1]);
	}
}

function bitly_change () {
	apdisp('bitly_button','none');
	apdisp('bitly_waiter','');
	
	var usr=apvalue('bitly_usr');
	var key=apvalue('bitly_key');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=bitly_change_handler;
	req.open("GET",AJURL+"bitly_change?usr="+usr+'&key='+key);
	req.send(null);
}
function bitly_change_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('bitly_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('options',apinner('options_done_id'));
		clears('bitly_');
	}
	else {
		// errore
		error('bitly_',rs[1]);
	}
}

function create_user () {
	apdisp('create_user_button','none');
	apdisp('create_user_wait','');
	
	var user=apvalue('create_user');
	var pass=apvalue('create_pass');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=create_user_handler;
	req.open("GET",AJURL+"create_user?user="+user+"&pass="+pass);
	req.send(null);
}
function create_user_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('create_user_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('create',apinner('create_done_id'));
		apinner('create_user_div',rs[1]);
	}
	else {
		// errore
		error('create_user_',rs[1]);
	}
}

function create_post_check () {
	apdisp('create_post_checkb','none');
	apdisp('create_post_wait','');
	count_chars();
	
	var text=apvalue('post_text');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=create_post_check_handler;
	req.open("GET",AJURL+"create_post?check="+encodeURIComponent(text));
	req.send(null);
	/*
	var url=AJURL+"create_post";
	var par="?check="+text;
	req=new XMLHttpRequest();
	req.onreadystatechange=create_post_check_handler;
	req.open("POST",url,true);
	http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length",par.length);
	http.setRequestHeader("Connection","close");
	req.send(par);
	*/
}
function create_post_check_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('create_post_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		apvalue('post_text',rs[1]);
		apdisp('create_post_wait','none');
		apdisp('create_post_button','');
	}
	else {
		// errore
		error('create_post_',rs[1]);
	}
}

function create_post_submit () {
	apdisp('create_post_button','none');
	apdisp('create_post_wait','');
	count_chars();
	
	var text=apvalue('post_text');
	
	req=new XMLHttpRequest();
	req.onreadystatechange=create_post_submit_handler;
	req.open("GET",AJURL+"create_post?post="+encodeURIComponent(text));
	req.send(null);
}
function create_post_submit_handler () {
	if (req.readyState!=4) return;
	
	if (req.status!=200) {
		error('create_post_','ERROR '+req.status);
		return;
	}
	
	var rrt=req.responseText;
	var rs=new Array();
	rs=rrt.split("\n");
	var status=rs[0];
	
	if (status=="OK") {
		button_showp('create',apinner('create_done_id'));
		apinner('create_post_div',rs[1]);
		apinner('queue_div',rs[2]);
	}
	else {
		// errore
		error('create_post_',rs[1]);
	}
}

function count_chars () {
	var max=140;
	var act=document.getElementById('post_text').value.length;
	var diff=max-act;
	var amt=Math.floor(Math.log(Math.abs(diff))/Math.log(10));
	if (diff>=0) {
		apclass('thead','texthead');
	}
	else {
		apclass('thead','texthead texthead_red');
		amt++;
	}
	var inn=diff;
	var ii;
	if (diff==0) {
		ii=3;
	}
	else {
		ii=3-amt;
	}
	for (; ii>0; ii--) {
		inn='&nbsp;'+inn;
	}
	apinner('charcount',inn);
}
