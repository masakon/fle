<?php 
class Verb {
	// Request : verb in dictionary form
	// Group : verb group (1 (遊ぶ), 2 (起きる), 3 (する、くる)
	// Affirmative : affirmative or negative
	// Tense   : present_indicative, presumptive, imperative, past_indicative, past_presumptive, present_progressive, past_progressive, provisional, conditional, potential, causative
	
	function Conjugate($request, $affirmative, $tense) {
		$sql = 'SELECT * FROM verbs WHERE verb_name LIKE "'. $request .'" LIMIT 1';
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
		while($data = mysql_fetch_assoc($req)) {
			if ($affirmative == 1) {
				if ($tense == 'present_indicative') $return = $data['aff_present_indicative'];
				elseif ($tense == 'past_indicative') $return = $data['aff_past_indicative'];
				elseif ($tense == 'presumptive') $return = $data['aff_presumptive'];
				elseif ($tense == 'past_presumptive') $return = $data['aff_past_presumptive'];
				elseif ($tense == 'imperative') $return = $data['aff_imperative'];
				elseif ($tense == 'present_progressive') $return = $data['aff_present_progressive'];
				elseif ($tense == 'past_progressive') $return = $data['aff_past_progressive'];
				elseif ($tense == 'provisional') $return = $data['aff_provisional'];
				elseif ($tense == 'conditional') $return = $data['aff_conditional'];
				elseif ($tense == 'potential') $return = $data['aff_potential'];
				elseif ($tense == 'causative') $return = $data['aff_causative'];
			}
			elseif ($affirmative == 0) {
				if ($tense == 'present_indicative') $return = $data['neg_present_indicative'];
				elseif ($tense == 'past_indicative') $return = $data['neg_past_indicative'];
				elseif ($tense == 'presumptive') $return = $data['neg_presumptive'];
				elseif ($tense == 'past_presumptive') $return = $data['neg_past_presumptive'];
				elseif ($tense == 'imperative') $return = $data['neg_imperative'];
				elseif ($tense == 'present_progressive') $return = $data['neg_present_progressive'];
				elseif ($tense == 'past_progressive') $return = $data['neg_past_progressive'];
				elseif ($tense == 'provisional') $return = $data['neg_provisional'];
				elseif ($tense == 'conditional') $return = $data['neg_conditional'];
				elseif ($tense == 'potential') $return = $data['neg_potential'];
				elseif ($tense == 'causative') $return = $data['neg_causative'];
			}
			return($return);
		}
	}
}
?>