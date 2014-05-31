<?php
require_once("./functions/mysql.connect.php");
require_once("./functions/class.verb.php");
require_once("./functions/class.sentence.php");


// Verb Conjugator
if (isset($_GET['tool']) && $_GET['tool'] == 'sentence') {
    $result = Sentence::Aru();
    echo $result;
}

// JLPT N5 - ARU
elseif (isset($_GET['tool']) && $_GET['tool'] == 'verb_conjugator') {
    $result = Verb::Conjugate($_GET['verb_name'], $_GET['affirmative'], $_GET['tense']);
    echo $result;
}

else {
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>JS API</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="cache-control" content="no-cache, must-revalidate" />
	<style type="text/css">
	<!-- body {font-family:Consolas; font-size: 20px; } -->
</style>

	</head>
	<body>
	<h1>Conjugate a verb</h1>
	<form action="?" method="get">
	<p>
	<input type="hidden" name="tool" value="verb_conjugator" />
	Verb in kanji or kana: <input type="text" name="verb_name" value="" /><br />
	Affirmative or negative: <select name="affirmative">
	<option value="1">Affirmative</option>
	<option value="0">Negative</option>
	</select><br />
	Tense: <select name="tense">
	<option value="present_indicative">Present Indicative</option>
	<option value="past_indicative">Past Indicative</option>
	<option value="presumptive">Presumptive</option>
	<option value="past_presumptive">Past Presumptive</option>
	<option value="imperative">Imperative</option>
	<option value="present_progressive">Present Progressive</option>
	<option value="past_progressive">Past Progressive</option>
	<option value="provisional">Provisional</option>
	<option value="conditional">Conditional</option>
	<option value="potential">Potential</option>
	<option value="causative">Causative</option>
	</select>
	<input type="submit" value="OK" onclick="validate" />
	</p>
	</form>

	<h1>Generate a sentence</h1>
	<h2>JLPT N5 Grammar</h2>';

    $count = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM  `vocabulary` WHERE  `class` LIKE  '%n_aru%'" ));
    echo '<p><a href="?tool=sentence&product=aru">～がある</a> ('. $count[0] .' possible sentences)</h1>




	<hr />
	<p><a href="about.php">About JS API</a></p></body></html>';
}

mysql_close();
?>