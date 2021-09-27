<?php

function base_germe () {
	global $LIBURL,$PROGNAME,$CSS,$IMG,$JSURL,$AJURL;
	start_session();
	return new germe(
		$LIBURL.'tentacoli/',
		ucfirst($PROGNAME),
		'(c) 2010 Lorenzo Petrone, tutti i diritti riservati (all rights reserved).',
		'
		<link href="'.$CSS.'base.css" rel="stylesheet" type="text/css">
		<link href="'.$CSS.'ppk.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/png" href="'.$IMG.'河童.png">
		<script type="text/javascript" src="'.$JSURL.'ppk.js"></script>
		<script type="text/javascript" src="'.$JSURL.'bl.js"></script>
		<script type="text/javascript">AJURL=\''.$AJURL.'\';</script>
		'
	);
}

function page_login () {
	global $OPENID_URL,$OPENID_REQUIRED,$URL;
	
	/*
	$openid=new LightOpenID;
	$openid->identity=$OPENID_URL;
	$openid->required=$OPENID_REQUIRED;
	$openid->returnUrl=$URL."login";
	*/
	
	// TODO…… eventualmente supportare anche un login classico con password
	return '
	'.vertical_align('<center>
		<table cellpadding=4 cellspacing=0 border=0>
			<tr><td colspan=2 class="center">
				<a class="button" href="'.str_replace("&","&amp;",/*$openid->authUrl()*/'').'">Login with Google</a>
		</table>
	</center>').'
	';
}
function page_logout () {
	return '
	'.vertical_align('<center>
		<a class="button" href="login?logout">Logout</a>
	</center>').'
	';
}
function page_login_logout ($user, $germe) {
	if ($user) return page_logout();
	else return page_login();
}

function page_main ($user, $germe) {
	global $IMG;
	
	return '
	'.vertical_align('<center>
		clicca una foglia
	</center>').'
	';
}

// TODO°° fare in modo di avere una funzione e non due
function page_set ($user, $germe) {
	return vertical_align('<center><div id="set_div">'.div_set().'</div></center>');
}
function page_language ($user, $germe) {
	return vertical_align('<center><div id="language_div">'.div_language().'</div></center>');
}
function page_checklist ($user, $germe) {
	return vertical_align('<center><div id="checklist_div">'.div_checklist().'</div></center>');
}

// $newid serve a illuminare quello appena aggiunto
function div_language ($newid=NULL) {
	global $S;
	
	if (($langs=get_languages())===NULL) return NULL;
	
	// titolo
	$ret='
	<p>
	<div class="center fixed u">Languages</div>
	';
	
	// lista
	$ret.='
	<p>
	<table cellpadding=4 cellspacing=0 border=0 class="tabl fixed">
	';
	foreach ($langs as $lang) {
		if ($newid==$lang["id"]) $CLX=' class="shine"';
		else $CLX='';
		$ret.='
		<tr'.$CLX.'>
		<td>'.$lang["name"].'
		<td>'.lang_image($lang).'
		<td class="center">
		';
		if (am_admin()) {
			$action="toggle_active_lang({$lang["id"]});";
			if ($lang["active"]) {
				$SY=$S["chok"];
			}
			else {
				$SY=$S["chno"];
			}
			$ret.='<span id="toggle_active_lang_button#'.$lang["id"].'" onclick="'.$action.'" class="cur">'.$SY.'</span>';
		}
		else {
			if ($lang["active"]) $ret.=$S["chok"];
			else $ret.=$S["chno"];
		}
	}
	$ret.='
	</table>
	';
	
	// aggiungi
	if (am_admin()) {
		$ret.='
		<p>
		<table cellpadding=4 cellspacing=0 border=0>
			<tr>
			<td class="texthead fixed" id="language_do_text">new
			<td class="textline"><input onfocus="clears(\'language_\');" id="language_name" class="textmagic" size=16 maxlength=32 type="text">
			<td>
			<td class="texthead fixed" id="language_do_text">code
			<td class="textline"><input onfocus="clears(\'language_\');" id="language_code" class="textmagic" size=2 maxlength=2 type="text">
			<td>
			<span id="language_button" class="button" onclick="language();">add</span>
			<span id="language_wait" style="display:none;">'.$S["wait"].'</span>
		</table>
		';
	}
	
	return $ret;
}
function div_set ($newid=NULL) {
	global $Land_r,$S;
	
	if (($sets=get_sets(NULL))===NULL) return NULL;
	if (($langs=get_languages())===NULL) return NULL;
	
	$ret=''; // TODO°° trovare il modo di centrare il tutto anche se floating
	
	// titolo
	$ret.='
	<div class="flm">
	<div class="title">Sets</div>
	';
	
	// lista
	$ret.='
	<div class="sep"></div>
	<table cellpadding=4 cellspacing=0 border=0 class="tabl">
		<tr>
		<th>Name
		<th>#
		<th>lang
		<th>
	';
	foreach ($sets as $set) {
		if ($newid==$set["id"]) $CLX=' class="shine"';
		else $CLX='';
		// TODO°° trovare il modo di linkare i set nella collezione
		$LSH='';
		$LED='';
		foreach ($langs as $lang) {
			$LA=((int)$set["language"])&((int)$lang["id"]);
			if (am_admin()) {
				if ($LA) {
					$CL="cur lla";
					$nval=0;
				}
				else {
					$CL="cur lla sk";
					$nval=1;
				}
				$onclick="lang_toggle({$set["id"]},{$lang["id"]},$nval);";
				$LED.='<span id="lang#'.$set["id"].'_'.$lang["id"].'" onclick="'.$onclick.'" class="'.$CL.'">'.$lang["code"].'</span> ';
			}
			if ($LA) {
				$LSH.='<span class="lla">'.$lang["code"].'</span> ';
			}
		}
		if (am_admin()) {
			$LSHE='
			<div id="set_langs_show#'.$set["id"].'">
				<span class="smallbutton fixed" onclick="set_langs_do_edit('.$set["id"].');"><s>edit</s></span>
				'.$LSH.'
			</div>
			<div id="set_langs_edit#'.$set["id"].'" style="display:none;">
				<span class="smallbutton fixed" onclick="set_langs_do_show('.$set["id"].');">edit</span>
				'.$LED.'
			</div>
			';
		}
		else {
			$LSHE=$LSH;
		}
		$ret.='
		<tr'.$CLX.'>
		<td><a href="http://magiccards.info/'.$set["mci_code"].'/en.html" target="_blank">'.$set["name"].'</a>
		<td class="right fixed">'.count_set_lands($set).'
		<td class="left fixed">'.$LSHE.'
		<td class="center">
		';
		if (am_admin()) {
			$action="toggle_active_set({$set["id"]});";
			if ($set["active"]) {
				$SY=$S["chok"];
			}
			else {
				$SY=$S["chno"];
			}
			$ret.='<span id="toggle_active_set_button#'.$set["id"].'" onclick="'.$action.'" class="cur">'.$SY.'</span>';
		}
		else {
			if ($set["active"]) $ret.=$S["chok"];
			else $ret.=$S["chno"];
		}
	}
	$ret.='
	</table>
	</div>
	';
	
	// aggiungi
	if (am_admin()) {
		$ret.='
		<div class="mage flm">
			<div class="title">New</div>
			<div class="sep"></div>
			<div class="line">
				<span class="th">name</span
				><span class="td"><input id="name" onfocus="clears(\'set_\');" size=16 maxlength=32 type="text"></span>
			</div>
			<div class="line">
				<span class="th">code</span
				><span class="td"><input id="code" onfocus="clears(\'set_\');" class="fixed" size=3 maxlength=3 type="text"></span>
			</div>
			<div class="line">
				<span class="th">mci code</span
				><span class="td"><input id="mcic" onfocus="clears(\'set_\');" class="fixed" size=3 maxlength=4 type="text"></span>
			</div>
		
			<input type="hidden" id="lands_sel" value="default">
			<input type="hidden" id="repeat_sel" value="stretch">
			<div id="lands_default">
				<div class="line">
					<span class="th" onclick="lands_switch();">lands</span
					><span class="td"><input id="lands_default_val" onfocus="clears(\'set_\');" size=1 maxlength=1 type="text" onkeypress="return seth(event);"></span>
				</div>
			</div>
			<div id="lands_complex" style="display:none;">
				<div class="line">
					<span class="th" onclick="lands_switch();">lands</span
					><span class="td"><input id="lands_complex_val" onfocus="clears(\'set_\');" size=10 maxlength=64 type="text" onkeypress="return seth(event);"></span>
				</div>
				<div class="line">
					<span class="th" id="repeat_stretch" onclick="repeat_switch();">stretch</span
					><span class="th" id="repeat_copy" onclick="repeat_switch();" style="display:none;">copy</span
					><span class="td"><input id="repeat_amount" onfocus="clears(\'set_\');" size=1 maxlength=1 type="text" onkeypress="return setr(event);"></span>
				</div>
			</div>
		
			<div class="longline">
				<span id="set_button" class="button" onclick="setx();">add</span>
				<span id="set_wait" style="display:none;">'.$S["wait"].'</span>
			</div>
		</div>
		';
	}
	
	return $ret;
}
function div_checklist ($newid=NULL) {
	global $Land,$S,$GC;
	
	if (($sets=get_sets(TRUE))===NULL) return NULL;
	if (($lands=get_lands())===NULL) return NULL;
	if (($langs=get_languages())===NULL) return NULL;
	
	$ret = '';
	
	$lls=sets_lands($sets,$lands);
	$lan=active_languages($langs);
	
	$pref_lang_id = 0;
	if ( $GC['pref_lang']??FALSE ) {
		foreach ( $langs as $lang ) {
			if ( $lang['code'] == $GC['pref_lang'] ) {
				$pref_lang_id = $lang['id'];
				break;
			}
		}
	}
	
	// crea indici utili
	$next_empty_land=array(); // mette in fila le terre il cui numero è mancante (per passare il focus)
	$spread_from=array();
	$spread_to=array();
	$spreading=NULL; // precedente numerata, se stesso set
	$eprev=NULL;     // precedente vuota (solo per le vuote)
	$aprev=NULL;     // precedente, se numerata
	$apset=NULL;     // set della $aprev
	foreach ($lls as $set) {
		foreach ($set["lands"] as $land) {
			if ($land["number"]) {
				$aprev=$land["id"];
				$apset=$land["set_id"];
				continue;
			}
			
			if ($aprev) {
				// questa non ha il numero ma la precedente sì
				if ($apset==$land["set_id"]) {
					$spread_from[$aprev]=$land["id"];
					$spreading=$aprev;
				}
				else {
					// sono di due set diversi, dunque niente
					$spreading=NULL;
				}
				$aprev=NULL;
			}
			
			if ($spreading) {
				$spread_to[$spreading]=$land["id"];
			}
			
			if ($eprev) {
				$next_empty_land[$eprev]=$land["id"];
			}
			$eprev=$land["id"];
		}
	}
	$next_empty_land[$eprev]=0;
	
	// titolo
	$ret.='
	<p>
	<div>
		<span class="title">Lands</span>
		<span class="button" id="set_refresh_button" onclick="set_refresh();">'.$S["refresh"].'</span>
		<span id="set_refresh_wait" style="display:none;">'.$S["processing"].'</span>
	</div>
	';
	
	// lista
	$colspan=4;
	$total_amount=0;
	$total_count_all=0;
	$total_count_any=0;
	foreach ($lls as $set) {
		$TAB='';
		$set_langs=set_langs($set,$lan);
		$langf=language_filter($set_langs);
		$count_all=0;
		$count_any=0;
		
		foreach ($set["lands"] as $land) {
			if ($land["got"]==0) {
				$CL="zero";
			}
			else {
				if ( $pref_lang_id ) {
					$HAVE = $land['got']&$pref_lang_id;
				}
				else {
					$HAVE = ($land["got"]&$langf)==$langf;
				}
				
				if ( $HAVE ) {
					$CL="have";
					$count_any++;
					$count_all++;
				}
				else {
					$CL="some";
					$count_any++;
				}
			}
			
			$MOAR='';
			if ($land["number"]) {
				$action="show_land('{$set["mci_code"]}','{$land["number"]}');";
				$NUM='<span class="link" onmouseover="'.$action.'">'.$land["number"].'</span>';
				if ($spread_from[$land["id"]] && am_admin()) {
					$action="spread_submit({$land["id"]},{$land["number"]},{$land["set_id"]},".$spread_from[$land["id"]].",".$spread_to[$land["id"]].");";
					$MOAR='
					<span id="land#'.$land["id"].'" class="button" onclick="'.$action.'">'.$S["going down"].'</span>
					<span id="land_wait#'.$land["id"].'" class="center" style="display:none;">'.$S["processing"].'</span>
					';
				}
			}
			else if (am_admin()) {
				$action="return cane(event,3,{$land["id"]},".(int)$next_empty_land[$land["id"]].");";
				$NUM='
				<input id="land#'.$land["id"].'" type="text" size=3 maxlength=3 class="fixed" onkeypress="'.$action.'">
				<span id="land_wait#'.$land["id"].'" class="center" style="display:none;">'.$S["processing"].'</span>
				';
			}
			
			$TAB.='
			<tr class="'.$CL.'">
			<td>'.$Land[$land["type"]].'
			<td class="right cur">'.$NUM.'
			<td>'.$MOAR.'
			<td>
			';
			foreach ($set_langs as $lla) {
				$HAVE=((int)$land["got"])&((int)$lla["id"]);
				if ($HAVE) {
					$CL="cur lla";
					$nval=0;
				}
				else {
					$CL="cur lla sk";
					$nval=1;
				}
				if (am_admin()) {
					$onclick="own_toggle({$land["id"]},{$lla["id"]},$nval);";
					$TAB.='<span class="'.$CL.'" id="have#'.$land["id"].'_'.$lla["id"].'" onclick="'.$onclick.'">'.$lla["code"].'</span> ';
				}
				else {
					$TAB.='<span class="'.$CL.'">'.$lla["code"].'</span> ';
				}
			}
		}
		
		// TODO°° onef (completa di una singola lingua)
		$total_count_all+=$count_all;
		$total_count_any+=$count_any;
		$total_amount+=$amount=count($set["lands"]);
		if ($count_any==0) $CL="zero";
		else if ($count_all==$amount) $CL="allf";
		else if ($count_any==$amount) $CL="anyf";
		else $CL="some";
		$ret.='
		<div class="flm">
		<table cellpadding=4 cellspacing=0 border=0 class="tabl fixed">
		<tr class="sep">
		<td colspan='.$colspan.'>
		<tr class="'.$CL.'">
		<th colspan='.$colspan.' class="center">'.$set["name"].'
		'.$TAB.'
		<tr class="tot">
		<th colspan='.$colspan.'>'.$count_any.'/'.$amount.'
		</table>
		</div>
		';
	}
	$ret.='
	<div class="flm">
	<table cellpadding=4 cellspacing=0 border=0 class="tabl fixed">
	<tr class="sep">
	<td colspan='.$colspan.'>
	<tr class="tot">
	<th colspan='.$colspan.'><b>Total</b> '.$total_count_any.'/'.$total_amount.'
	</table>
	</div>
	';
	
	return $ret;
}
