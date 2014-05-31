<?php
require_once("./functions/mysql.connect.php");


echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>FLE-API : 日本人へのフランス語の勉強のツール</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache" /> 
	<meta http-equiv="cache-control" content="no-cache, must-revalidate" /> 
	<style type="text/css">
	<!-- body {font-family:Consolas; font-size: 20px; } -->
</style>
	
	</head>
	<body>
	<h1>FLE-API : 日本人へのフランス語の勉強のツール</h1>';

include("about.php");
mysql_close();
?>