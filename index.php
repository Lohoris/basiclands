<?php

require_once 'includes.php';

try {
	// base
	$germ=base_germe();
	
	// login e sessione
	$db=connect() or diesql("Couldn't connect to database");
	$logged=get_logged_user();
	
	// sfondo
	$germ->stretched_background($IMG.'Bamboo Forest_less.jpeg');
	
	// main
	$rect=$germ->rettangolo(
		25,10,40,64,4,
		page_main($logged,$germ),
		'color:#000000;overflow:auto;',
		'border: 1px solid #226622; background: #ccccee; opacity: 0.7;'
	);
	$germ->add_head('<script type="text/javascript">'.$rect->jsvar('bodi').'</script>'); // serve per i login e logout handler
	$germ->add($rect);
	
	// show land
	$germ->add(new rettangolo (75,20,NULL,NULL,4,'<div id="show_land"><div id="show_land_image"></div></div>','',''));
	
	// error
	$germ->add(
		new rettangolo(
			32,78,36,10,4,
			'<div id="error_text" class="small center"></div>',
			'color:#dddddd;',
			'border:2px dotted #eeeeee; background:#dd3333; opacity:0.7;',
			'error',
			'display:none;'
		)
	);
	
	// waiter
	$germ->add('<span class="hidden" id="waiter">'.$S["processing"].'</span>');
	
	// menu
	$menu=$rect->tentacolo(
		'menu',
		$IMG."bamboo_black_sm.png",
		$IMG."bamboo_green_sm.png",
		150,200,
		"bottom:0;left:18%;",
		"
		font-size:0.95em;
		height:1.25em;
		padding-bottom:0.3em;
		color:#eeeeee;
		background:#256025;
		width:125px;
		bottom:50px;
		left:23%;
		border:1px solid #222222;
		"
	);
	if ($logged) {
		$LTX="Logout";
	}
	else {
		$LTX="Login";
	}
	$menu->ventosa(114,25,35,42, "Checklist", page_checklist($logged,$germ));
	$menu->ventosa(50,42,65,55,  "Sets",      page_set($logged,$germ));
	$menu->ventosa(7,75,44,43,   "Languages", page_language($logged,$germ));
	$menu->ventosa(8,140,67,47,  $LTX,        page_login_logout($logged,$germ));
	$germ->add($menu);
	
	// logo
	$germ->add(new rettangolo (0,0,NULL,NULL,0,'<a href="'.$URL.'"><img src="'.$IMG.'河童.png" alt="'.$PROGNAME.'"></a>','opacity:0.1;',''));
	
	// w3c
	$germ->p8015($LIBURL.'html401.gif','http://validator.w3.org/check?uri=referer');
	$germ->p8015($LIBURL.'css.gif','http://jigsaw.w3.org/css-validator/check/referer?profile=css3');
}
catch ( Exception $ex ) {
	print_re($ex);
}
