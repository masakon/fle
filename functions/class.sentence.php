<?php 
class Sentence {
	// Request : verb in dictionary form
	// Group : verb group (1 (遊ぶ), 2 (起きる), 3 (する、くる)
	// Affirmative : affirmative or negative
	// Tense   : present_indicative, presumptive, imperative, past_indicative, past_presumptive, present_progressive, past_progressive, provisional, conditional, potential, causative
	
	function Aru() {
		echo '<?xml version="1.0" encoding="UTF-8"?><jsapi>';
		$sql = "SELECT * FROM  `vocabulary` WHERE  `class` LIKE  '%n_aru%' ORDER BY RAND() LIMIT 1";
		$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error()); 
		while($data = mysql_fetch_assoc($req)) {
			if (empty($data['kanji'])) {
				echo '<kana>'. $data['kana'] .'がある。</kana>';
			}
			else {
				echo '<kanji>'. $data['kanji'] .'がある。</kanji>
				<kana>'. $data['kana'] .'がある。</kana>';
			}
			echo '<english>There is ';
			if ($data['english'][0] == 'a' || $data['english'][0] == 'e' || $data['english'][0] == 'o' || $data['english'][0] == 'a' || $data['english'][0] == 'u') echo 'an';
			else echo 'a';
			echo ' '. $data['english'] .'.</english>';
			echo '</jsapi>';
		}
	}
}
?>