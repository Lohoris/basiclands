<?php
/*
	(c) 2009-2011 Lorenzo Petrone.
	
	NO WARRANTIES OF ANY KIND FOR ANY REASON.
	You may use this file, and this file only, as you wish, as long as you give credits.
*/

/*	
	TODO• è male che il rettangolo abbia LTWH mentre il tentacolo solo WH, e LT le debba settare via CSS
	TODO• è male che sia tutto settato in percentuale mentre il menu abbia dimensioni in pixel fissi
	TODO• rendere anche i bdiv #linkabili (muy complesso, così a naso)
*/

class germe {
	private $head,$body,$p8015,$onload,$onresize;
	private $liburl;
	private $on=TRUE;
	
	function __construct ($liburl, $title='', $cmessage='', $head='') {
		global $LIBURL;
		
		// visualizza subito gli header, a prescindere dal resto
		header('Content-Type: text/html; charset=UTF-8');

		// intestazioni e head
		// TODO• raccogliere gli onload/onresize e mostrarli tutti insieme alla fine
		$page='
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<!--
		'.$cmessage.'
		-->
		<head profile="http://www.w3.org/2005/11/profile">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="'.$liburl.'style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="'.$LIBURL.'base.js"></script>
		<script type="text/javascript" src="'.$liburl.'tentacoli.js"></script>
		<title>'.$title.'</title>
		'.$head.'
		';

		echo $page;
		
		$this->onresize="adjust_background('background_image');";
		// TODO° chiamare show_content solo in caso quel content effettivamente esista
		$this->onload="
		var frag=fragment();
		if (frag) {
			var rname=frag.split('_').slice(0,1);
			var id=frag.split('_').slice(1);
			show_content(''+rname+'',id);
		}
		";
		
		$this->liburl=$liburl;
		$this->head='';
		$this->body='';
		$this->p8015='';
	}
	function stretched_background ($image) {
		$this->add('
			<div style="position:fixed;top:0;left:0;width:100%;height:100%;text-align:center;">
			'.vertical_align('<img id="background_image" src="'.$image.'" alt="(background)" style="display:none;">').'
			</div>
		');
	}
	function add ($ax, $ay=NULL) {
		if ($ay!==NULL) {
			$body=$ax;
			$head=$ay;
		}
		else if (is_array($ax)) {
			list($body,$head)=$ax;
		}
		else if (is_object($ax)) {
			return $this->add($ax->show());
		}
		else {
			$body=$ax;
			$head='';
		}
		$this->body.=$body;
		$this->head.=$head;
	}
	function add_head ($ay) {
		$this->add("",$ay);
	}
	function onload ($commands) {
		$this->onload.=$commands;
	}
	function onresize ($commands) {
		$this->onresize.=$commands;
	}
	function p8015 ($image, $url=NULL) {
		$tx='<img src="'.$image.'" width=80 height=15 alt="">';
		$url!==NULL and $tx='<a href="'.$url.'">'.$tx.'</a>';
		$this->p8015.='<div class="p8015">'.$tx.'</div>';
	}
	function halt () {
		$this->on=FALSE;
	}
	function __destruct () {
		if (!$this->on) return;
		
		$this->head.='
		<script type="text/javascript">
		window.onload = function() {
			'.$this->onload.'
			'.$this->onresize.'
		}
		window.onresize = function() {
			'.$this->onresize.'
		}
		'."
		function button_none (ida) {
			for (var ii=1; ; ii++) {
				var el=document.getElementById(ida+'_'+ii);
				if (!el) break;
				el.style.display='none';
			}
		}
		</script>
		";
		
		$this->body.='<div id="p8015buttons">'.$this->p8015.'</div>';
		
		echo $this->head."</head><body>".$this->body;
	}
	function rettangolo ($left, $top, $width, $height, $margin, $base, $attr_main, $attr_bg, $container=NULL, $attr_cont=NULL) {
		$rect=new rettangolo($left,$top,$width,$height,$margin,$base,$attr_main,$attr_bg,$container,$attr_cont);
		$rect->set_germe($this);
		return $rect;
	}
}
class rettangolo {
	private static $count=0;
	private $attr_main,$attr_bg,$w,$h,$lrtb,$lr,$tb,$base,$margin;
	private $id;
	private $show;
	private $container,$attr_cont,$classes;
	private $germe;
	
	function __construct ($lr, $tb, $width, $height, $margin, $base, $attr_main, $attr_bg, $container=NULL, $attr_cont=NULL, $lrtb="lt", $classes="") {
		$this->attr_main=$attr_main;
		$this->attr_bg=$attr_bg;
		$this->margin=$margin;
		$this->base=$base;
		$this->w=$width;
		$this->h=$height;
		$this->lrtb=$lrtb;
		$this->lr=$lr; // left-right
		$this->tb=$tb; // top-bottom
		$this->id=++self::$count;
		$this->show=NULL;
		$this->container=$container;
		$this->attr_cont=$attr_cont;
		$this->classes=$classes;
	}
	function show () {
		if ($this->show) return $this->show;
		
		if ($this->margin!==NULL) {
			$BM='padding:'.$this->margin.'px;';
			$MM='margin:'.$this->margin.'px;';
		}
		else {
			$BM='';
			$MM='';
		}
		
		// wh
		if ($this->w!==NULL) {
			$W='width:'.$this->w.'%;';
		}
		else {
			$W='';
		}
		if ($this->h!==NULL) {
			$H='height:'.$this->h.'%;';
		}
		else {
			$H='';
		}
		
		// lrtb
		if (strpbrk($this->lrtb,"l")) {
			$LR="left:{$this->lr}%;";
		}
		else if (strpbrk($this->lrtb,"r")) {
			$LR="right:{$this->lr}%;";
		}
		if (strpbrk($this->lrtb,"t")) {
			$TB="top:{$this->tb}%;";
		}
		else if (strpbrk($this->lrtb,"b")) {
			$TB="bottom:{$this->tb}%;";
		}
		
		$head='
		<style type="text/css">
		div#'.$this->name().'_bg, div.'.$this->name().' {
			'.$W.'
			'.$H.'
			'.$LR.'
			'.$TB.'
		}
		div#'.$this->name().'_bg {
			'.$this->attr_bg.'
			'.$BM.'
		}
		div.'.$this->name().' {
			'.$this->attr_main.'
			'.$MM.'
		}
		</style>
		';
		$body='
		<div class="content_bg" id="'.$this->name().'_bg"></div>
		<div class="content '.$this->name().' '.$this->classes.'" id="'.$this->name().'_0">'.$this->base.'</div>
		';
		
		if ($this->container) {
			$head.='
			<style type="text/css">
			div#'.$this->container.' {
				'.$W.'
				'.$H.'
				'.$LR.'
				'.$TB.'
			}
			</style>
			';
			$body='<div id="'.$this->container.'" style="'.$this->attr_cont.'">'.$body.'</div>';
		}
		
		return array($body,$head);
	}
	function show_body () {
		if ($this->show) return $this->show["body"];
		$this->show=$this->show();
		return $this->show[0];
	}
	function show_head () {
		if ($this->show) return $this->show["head"];
		$this->show=$this->show();
		return $this->show[1];
	}
	function name () {
		return 'reco'.$this->id;
	}
	function jsvar ($name) {
		return "
		var $name='".$this->name()."_0';
		var {$name}_a='".$this->name()."';
		var {$name}_b='0';
		";
	}
	function tentacolo ($name, $image_base, $image_over, $width, $height, $attr_base, $attr_over, $test=FALSE) {
		return new tentacolo($name,$this,$image_base,$image_over,$width,$height,$attr_base,$attr_over,$test);
	}
	function set_germe ($germe) {
		$this->germe=$germe;
	}
	function germe () {
		return $this->germe;
	}
}
class tentacolo {
	private $ventose=array();
	private $name,$image_base,$image_over,$w,$h,$attr_base,$attr_over,$test,$rect;
	
	function __construct ($name, $rect, $image_base, $image_over, $width, $height, $attr_base, $attr_over, $test=FALSE) {
		$this->name=$name;
		$this->rect=$rect;
		$this->image_base=$image_base;
		$this->image_over=$image_over;
		$this->w=$width;
		$this->h=$height;
		$this->attr_base=$attr_base;
		$this->attr_over=$attr_over;
		$this->test=$test;
	}
	function ventosa ($left, $top, $width, $height, $title, $content) {
		array_push($this->ventose,$vent=new ventosa($left,$top,$width,$height,$title,$content,$this));
		$this->rect->germe()->add_head('<script type="text/javascript">'.$vent->jsvar($this->name.'_'.$title).'</script>');
	}
	function show () {
		$head='';
		$body='';
		
		// stile
		$head.='
		<style type="text/css">
		div#tentacolo_'.$this->name.' {
			position:fixed;
			background-image: url('.$this->image_base.');
			width:'.$this->w.'px;
			height:'.$this->h.'px;
			'.$this->attr_base.'
		}
		
		div.ventosa_'.$this->name.':hover {
			background-image: url('.$this->image_over.');
		}
		
		div.ventosa_'.$this->name.':hover div.ventosa_icon_'.$this->name.' {
			'.$this->attr_over.'
		}
		';
		$this->test and $head.='
		div.ventosa_'.$this->name.' {
			background-color:#000000;
			opacity:0.5;
		}
		';
		$head.='
		</style>
		';
		
		// base e ventose
		$body.='<div id="tentacolo_'.$this->name.'">';
		foreach ($this->ventose as $v) {
			$body.=$v->title();
		}
		$body.='</div>';
		
		// titoli
		foreach ($this->ventose as $v) {
			$body.=$v->content();
		}
		
		return array($body,$head);
	}
	function name () {
		return $this->name;
	}
	function rname () {
		return $this->rect->name();
	}
	function rettangolo () {
		return $this->rect;
	}
}
class ventosa {
	private static $count=array();
	private $l,$t,$w,$h;
	private $title,$content;
	private $id,$tentacolo;
	
	function __construct ($left, $top, $width, $height, $title, $content, $tentacolo) {
		$this->l=$left;
		$this->t=$top;
		$this->w=$width;
		$this->h=$height;
		$this->title=$title;
		$this->content=$content;
		$this->tentacolo=$tentacolo;
		if (!isset(self::$count[$tentacolo->rname()])) {
			self::$count[$tentacolo->rname()]=0;
		}
		$this->id=++self::$count[$tentacolo->rname()];
	}
	function title () {
		return '
		<div class="ventosa ventosa_'.$this->tentacolo->name().'" style="
		left:'.$this->l.'px;
		top:'.$this->t.'px;
		background-position: -'.$this->l.'px -'.$this->t.'px;
		width:'.$this->w.'px;
		height:'.$this->h.'px;
		"
		onclick="show_content(\''.$this->tentacolo->rname().'\','.$this->id.');"
		>
			<div class="ventosa_icon ventosa_icon_'.$this->tentacolo->name().'">'.$this->title.'</div>
		</div>
		';
	}
	function content () {
		return '<div id="'.$this->tentacolo->rname().'_'.$this->id.'" style="display:none;" class="content '.$this->tentacolo->rname().'">'.$this->content.'</div>';
	}
	function jsvar ($name) {
		return "
		var $name='".$this->tentacolo->rname().'_'.$this->id."';
		";
	}
}

class bdivs {
	private $name;
	private $div_count=0;
	private $div_names=array();
	
	function __construct ($name) {
		$this->name=$name;
	}
	
	function divid ($name) {
		return 'id="'.$this->name.'_'.$this->divname($name).'"';
	}
	function div ($name, $content, $flags="") {
		if (strpbrk($flags,"h")) {
			$SDN='style="display:none;"';
		}
		else {
			$SDN='';
		}
		
		return '<div '.$this->divid($name).' '.$SDN.'>'.$content.'</div>';
	}
	function divh ($name, $content) {
		return $this->div($name,$content,"h");
	}
	
	function button ($name, $text=NULL) {
		if ($text===NULL) $text=$name;
		return '<span class="button" onclick="button_showp(\''.$this->name.'\','.$this->divname($name).');">'.$text.'</span>';
	}
	function divname ($name) {
		if (isset($this->div_names[$name])) return $this->div_names[$name];
		$dc=++$this->div_count;
		$this->div_names[$name]=$dc;
		return $dc;
	}
	function precalc () {
		// TODO° non riesco a capire perché sia ancora necessaria, non ne vedo il motivo, cosa cazzo succede?
		foreach (func_get_args() as $name) {
			$this->divname($name);
		}
	}
}
