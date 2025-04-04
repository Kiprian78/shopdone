<?php
/**************************************************************************/
define('WEB_NAME',      'MOA.Bijoux :: Magazin Online');
/**************************************************************************/
//define('WEB_DOMENIU',  'shop.ekkoo.ro/');  
define('WEB_DOMENIU',   'shopdone.ekkoo.ro/'); 
define('WEB_BASE_URL',  'https://'.WEB_DOMENIU);
/*************************************************************************/
define("EMAIL_FROM",	'contact@ekkoo.ro');
define("EMAIL_OFFICE",  'katalina.calugar@gmail.com, ciprian.coica@gmail.com');
define("EMAIL_SUPPORT", 'katalina.calugar@gmail.com, ciprian.coica@gmail.com'); 
/**************************************************************************/
/* define("EMAIL_FROM",	'office@knss.ro');
define("EMAIL_OFFICE",  'ciprian.coica@gmail.com');
define("EMAIL_SUPPORT", 'ciprian.coica@gmail.com');*/
/**************************************************************************/
 define('DB_HOST',       'localhost');
define('DB_NAME',       'ekkoo_shopdone');
define('DB_USER',       'mysqli_user');
define('DB_PASS',       'mysqli_pass'); 
/**************************************************************************/
/* define('DB_HOST',    'localhost');
define('DB_NAME',       'ekkoo_shop');
define('DB_USER',       'root');
define('DB_PASS',       '123456');*/
/**************************************************************************/
define('INC_UTILE',     'core/utile/');
define('INC_OBIECTE',   'core/obiecte/');
define('INC_MODULE',    'core/module/');
define('INC_SABLOANE',  'core/sabloane/');
/**************************************************************************/
foreach(glob(INC_UTILE."*.php") as $filename) { include_once($filename); }
foreach(glob(INC_OBIECTE."*.php") as $filename) { include_once($filename); }
/**************************************************************************/
$xRoutes = array(); $xRoutes = @getURLRoutes(); $incTPL = 'index.tpl';
/**************************************************************************/
con();  @mysqli_query($con, "SET NAMES utf8;"); @mb_internal_encoding("UTF-8");
/**************************************************************************/