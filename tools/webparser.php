<?php	
$argument="食べる";
$url = "http://127.0.0.1:8080/japansensei.org/?tool=verb_conjugator&verb=食べる&affirmative=1&tense=past_indicative&Submit=OK";
$str = file_get_contents($url);
#SendCommand("PRIVMSG ".$users[2]." :". chr(03) ."02". $str . chr(15) ."\r\n");
echo $str;

?>