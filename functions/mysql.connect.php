<?php
$link = mysql_connect("sql5.freesqldatabase.com", "sql542077", "nY9*kA7*") or die("Impossible de se connecter : " . mysql_error()); # Connexion locale
mysql_select_db('sql542077');
mysql_query("SET NAMES 'utf8'");
?>