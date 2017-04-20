<?php
require_once 'my/defines.php';
require_once 'my/template.php';
require_once 'engine/lib/strings.php';
require_once 'engine/lib/auth.php';
require_once 'engine/lib/bd.php';
require_once 'engine/gb.php';
session_start();
require_once "captcha/simple-php-captcha.php";
db_connect(DBHOST, DBUSER, DBPASSWD, DBNAME);
	$filter = array("<", ">");
	$filt = array("cookie", "script");
	$block_ip = array(".");

 if(!$_COOKIE['lang']) {
 SetCookie('lang', 'en');
 }
 if(isset($_GET['en'])) {
SetCookie('lang', 'en');
 }
  if(isset($_GET['ua'])) {
SetCookie('lang', 'ua');
 }
if (!empty($_POST['sb']))
{
	$name =str_replace ($filter, "|",  @$_POST['name']);
	$email =str_replace ($filter, "|",  @$_POST['email']);
	$www =str_replace ($filter, "|",  @$_POST['www']);
	$message = str_replace ($filt, "|", @$_POST['message']);
	$image = @$_POST['image'];
	$captcha = @$_POST['captcha'];
	$error = '';
}
else
{
	$name = $email = $www = $message = $error = '';
}
if(is_numeric($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
};
if(@$_GET['add']) {
  gb_add($name, $email, $www, $message,$captcha, $error);
};
if(isset($_GET['del']) && auth_is_admin()) {
		$_GET['del'] = str_replace ($filter, "|", $_GET['del']);
  gb_delete(intval($_GET['del']));
}
if(isset($_GET['logout']) && auth_is_admin()) {
		$_GET['logout'] = str_replace ($filter, "|", $_GET['logout']);
 SetCookie('admin', '');
 header('Location: index.php');
}
	if(isset($_GET['block']) && auth_is_admin()) {

		$_GET['block'] = str_replace ($filter, "|", $_GET['block']);
			$_GET['block'] = str_replace ($block_ip, ".", $_GET['block']);
  gb_block(strval($_GET['block']));
	}
template_header($page);
 function block($name, $email, $www, $message, $captcha, $error) {
	$ip = $_SERVER["SERVER_ADDR"];
$result = db_query('SELECT * FROM guestbook');
$arr = array();
while($row = mysqli_fetch_array($result)) { 
	array_push($arr, $row[1]);
 }
 if(in_array($ip, $arr)) {
	 return false;
 } else {
template_form($name, $email, $www, $message, $captcha, $error);
 };
};
$_SESSION = array();
$_SESSION['captcha'] = simple_php_captcha();
block($name, $email, $www, $message, $captcha, $error);
gb_showpages($page);
sortArr($page);
gb_show($page);
gb_showpages($page);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>