<?php

/*	General TODO
	°° usare la cache
	•• controllare un po' gli errori JS
*/

require_once 'config.php';
require_once 'const.php';
require_once 'functions.php';
require_once 'pages.php';

require_once 'vendor/autoload.php';
require_once 'vendor/goblinsama/goblinsama-php/functions.php';
require_once 'vendor/goblinsama/goblinsama-php/db/pdoWrapper.php'; // TODO. wouldn’t be necessary if the dir structure was correct

require_once $LIBDIR.'var.php';
require_once $LIBDIR.'tentacoli/tentacoli.php';

// require_once $LIBDIR.'generic_outside.php';
// require_once $LIBDIR.'generic_outside_more.php';
// require_once $LIBDIR.'openid.php';

$PAGE_TYPE="";
