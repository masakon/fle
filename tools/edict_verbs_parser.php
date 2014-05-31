<?php
require_once("mysql.connect.php");
mb_internal_encoding("UTF-8");
$time_start = microtime(true);

mysql_query("TRUNCATE TABLE `verbs`");
$sql = 'SELECT * FROM edict WHERE english LIKE "%v1%" OR english LIKE "%v5%" OR english LIKE "%(vi%" OR english LIKE "%(,vi%" OR english LIKE "%(vs%" OR english LIKE "%,vs%" OR english LIKE "%vz%" OR english LIKE "%vk%" OR english LIKE "%vt%" ';
#$sql = 'SELECT * FROM edict WHERE kanji LIKE "買う" OR kanji LIKE "書く" OR kanji LIKE "貸す" OR kanji LIKE "待つ" OR kanji LIKE "死ぬ" OR kanji LIKE "読む" OR kanji LIKE "送る" OR kanji LIKE "飛ぶ" OR kanji LIKE "泳ぐ" OR kanji LIKE "来る" OR kanji LIKE "する" OR kanji LIKE "連れて来る"';
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
while($data = mysql_fetch_assoc($req)) {
	
	// Double entries for verbs usually written in kana
	if (empty($data['kanji'])) $entry = $data['kana'];
	else $entry = $data['kanji'];
	
	// Verb Groups
	if (substr_count($data['english'], 'v1') >= 1) $verb_group = 2;
	elseif (substr_count($data['english'], 'v5') >= 1) $verb_group = 1;
	elseif (substr_count($data['english'], 'vs') >= 1) $verb_group = 3;
	else $verb_group = 9;

	// Transitive or intransitive verb ? 9 are exceptions
	if (substr_count($data['english'], '(vi') >= 1) $verb_transitive = 0;
	elseif (substr_count($data['english'], ',vi') >= 1) $verb_transitive = 0;
	elseif (substr_count($data['english'], 'vt') >= 1) $verb_transitive = 1;
	else $verb_transitive = 9;

	// Verb class, mostly exceptions that need to be evaluated individually
	if (substr_count($data['english'], 'v5u-s') >= 1) $verb_class = 'v5u-s';
	elseif (substr_count($data['english'], 'v5k-s') >= 1) $verb_class = 'v5k-s';
	elseif (substr_count($data['english'], 'v5aru') >= 1) $verb_class = 'v5aru';
	elseif (substr_count($data['english'], 'v5uru') >= 1) $verb_class = 'v5uru';
	elseif (substr_count($data['english'], 'vs-i') >= 1) $verb_class = 'vs-i';
	elseif (substr_count($data['english'], 'vs-s') >= 1) $verb_class = 'vs-s';
	elseif (substr_count($data['english'], 'vz') >= 1) $verb_class = 'vz';
	elseif (substr_count($data['english'], 'vk') >= 1) $verb_class = 'vk';
	else $verb_class = NULL;


	// First verb group (weak verbs)
	if (isset($verb_group) && $verb_group == 1) {
		$verb_prefix = substr($entry, 0, -3);
		$verb_suffix = substr($entry, -3);
		if ($verb_suffix == 'う') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'おう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'え', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'った', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'ったろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'っている', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'っていた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'えば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'ったら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'える', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'わせる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'わない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'ないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'うな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'わなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'わなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'っていない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'っていなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'わなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'わなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'えない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'わせない', $verb_suffix);
			$te = str_replace($verb_suffix, 'って', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'い', $verb_suffix);
		}
		if ($verb_suffix == 'く') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'こう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'け', $verb_suffix);
			if ($data['kana'] == 'いく') { // Exception いく
				$aff_past_indicative = str_replace($verb_suffix, 'った', $verb_suffix); 
				$aff_past_presumptive = str_replace($verb_suffix, 'った', $verb_suffix);
				$aff_present_progressive = str_replace($verb_suffix, 'っている', $verb_suffix);
				$aff_past_progressive = str_replace($verb_suffix, 'っていた', $verb_suffix);
				$neg_past_progressive = str_replace($verb_suffix, 'っていなかった', $verb_suffix);
				$te = str_replace($verb_suffix, 'って', $verb_suffix);
			}
			else {
				$aff_past_indicative = str_replace($verb_suffix, 'いた', $verb_suffix);
				$aff_past_presumptive = str_replace($verb_suffix, 'いたろう', $verb_suffix);
				$aff_present_progressive = str_replace($verb_suffix, 'いている', $verb_suffix);
				$aff_past_progressive = str_replace($verb_suffix, 'いていた', $verb_suffix);
				$neg_past_progressive = str_replace($verb_suffix, 'いていなかった', $verb_suffix);
				$te = str_replace($verb_suffix, 'いて', $verb_suffix);
			}
			$aff_provisional = str_replace($verb_suffix, 'けば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'いたら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'ける', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'かせる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'かない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'かないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'くな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'かなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'かなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'いていない', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'かなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'かなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'けない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'かせない', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'き', $verb_suffix);
		}
		if ($verb_suffix == 'す') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'そう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'せ', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'した', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'したろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'している', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'していた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'せば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'したら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'せる', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'させる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'さない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'さないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'すな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'さなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'さなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'していない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'していなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'さなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'さなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'せない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'させない', $verb_suffix);
			$te = str_replace($verb_suffix, 'して', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'し', $verb_suffix);
		}
		if ($verb_suffix == 'つ') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'とう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'て', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'った', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'ったろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'っている', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'っていた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'てば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'ったら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'てる', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'たせる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'たない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'たないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'つな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'たなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'たなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'っていない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'っていなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'たなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'たなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'てない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'たせない', $verb_suffix);
			$te = str_replace($verb_suffix, 'って', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'ち', $verb_suffix);
		}
		if ($verb_suffix == 'ぬ') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'のう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'ね', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'んだ', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'んだろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'んでいる', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'んでいた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'ねば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'んだら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'ねる', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'なせる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'なない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'なないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'ぬな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'ななかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'ななかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'んでいない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'んでいなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'ななければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'ななかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'ねない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'なせない', $verb_suffix);
			$te = str_replace($verb_suffix, 'んで', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'に', $verb_suffix);
		}
		if ($verb_suffix == 'む') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'もう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'め', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'んだ', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'んだろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'んでいる', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'んでいた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'めば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'んだら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'める', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'ませる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'まない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'まないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'むな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'まなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'まなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'んでいない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'んでいなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'まなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'まなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'めない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'ませない', $verb_suffix);
			$te = str_replace($verb_suffix, 'んで', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'み', $verb_suffix);
		}
		if ($verb_suffix == 'る') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'ろう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'れ', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'った', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'ったろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'っている', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'っていた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'れば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'ったら', $verb_suffix);
			if ($data['kana'] == 'ある') { // Exception ある
				$aff_potential = str_replace($verb_suffix, 'りえる', $verb_suffix); 
				$neg_present_indicative = str_replace($verb_suffix, 'ない', $verb_suffix);
				$neg_presumptive = str_replace($verb_suffix, 'ないだろう', $verb_suffix);
				$neg_past_indicative = str_replace($verb_suffix, 'なかった', $verb_suffix);
				$neg_past_presumptive = str_replace($verb_suffix, 'なかっただろう', $verb_suffix);
				$neg_provisional = str_replace($verb_suffix, 'なければ', $verb_suffix);
				$neg_conditional = str_replace($verb_suffix, 'なかったら', $verb_suffix);
				$neg_potential = str_replace($verb_suffix, 'りえない', $verb_suffix);
			}
			else {
				$aff_potential = str_replace($verb_suffix, 'れる', $verb_suffix);
				$neg_present_indicative = str_replace($verb_suffix, 'らない', $verb_suffix);
				$neg_presumptive = str_replace($verb_suffix, 'らないだろう', $verb_suffix);
				$neg_past_indicative = str_replace($verb_suffix, 'らなかった', $verb_suffix);
				$neg_past_presumptive = str_replace($verb_suffix, 'らなかっただろう', $verb_suffix);
				$neg_provisional = str_replace($verb_suffix, 'らなければ', $verb_suffix);
				$neg_conditional = str_replace($verb_suffix, 'らなかったら', $verb_suffix);
				$neg_potential = str_replace($verb_suffix, 'れない', $verb_suffix);
			}
			$aff_causative = str_replace($verb_suffix, 'らせる', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'るな', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'っていない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'っていなかった', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'らせない', $verb_suffix);
			$te = str_replace($verb_suffix, 'って', $verb_suffix);			
			$renyou = $verb_prefix . str_replace($verb_suffix, 'り', $verb_suffix);
		}
		if ($verb_suffix == 'ぐ') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'ごう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'げ', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'いだ', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'いだろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'いでいる', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'いでいた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'げば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'いだら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'げる', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'がせる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'がない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'がないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'ぐな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'がなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'がなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'いでいない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'いでいなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'がなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'がなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'げない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'がせない', $verb_suffix);
			$te = str_replace($verb_suffix, 'いで', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'ぎ', $verb_suffix);
		}
		if ($verb_suffix == 'ぶ') {
			$aff_present_indicative = $verb_suffix;
			$aff_presumptive = str_replace($verb_suffix, 'ぼう', $verb_suffix);
			$aff_imperative = str_replace($verb_suffix, 'べ', $verb_suffix);
			$aff_past_indicative = str_replace($verb_suffix, 'んだ', $verb_suffix);
			$aff_past_presumptive = str_replace($verb_suffix, 'んだろう', $verb_suffix);
			$aff_present_progressive = str_replace($verb_suffix, 'んでいる', $verb_suffix);
			$aff_past_progressive = str_replace($verb_suffix, 'んでいた', $verb_suffix);
			$aff_provisional = str_replace($verb_suffix, 'べば', $verb_suffix);
			$aff_conditional = str_replace($verb_suffix, 'んだら', $verb_suffix);
			$aff_potential = str_replace($verb_suffix, 'べる', $verb_suffix);
			$aff_causative = str_replace($verb_suffix, 'ばせる', $verb_suffix);
			$neg_present_indicative = str_replace($verb_suffix, 'ばない', $verb_suffix);
			$neg_presumptive = str_replace($verb_suffix, 'ばないだろう', $verb_suffix);
			$neg_imperative = str_replace($verb_suffix, 'ぶな', $verb_suffix);
			$neg_past_indicative = str_replace($verb_suffix, 'ばなかった', $verb_suffix);
			$neg_past_presumptive = str_replace($verb_suffix, 'ばなかっただろう', $verb_suffix);
			$neg_present_progressive = str_replace($verb_suffix, 'んでいない', $verb_suffix);
			$neg_past_progressive = str_replace($verb_suffix, 'んでいなかった', $verb_suffix);
			$neg_provisional = str_replace($verb_suffix, 'ばなければ', $verb_suffix);
			$neg_conditional = str_replace($verb_suffix, 'ばなかったら', $verb_suffix);
			$neg_potential = str_replace($verb_suffix, 'べない', $verb_suffix);
			$neg_causative = str_replace($verb_suffix, 'ばせない', $verb_suffix);
			$te = str_replace($verb_suffix, 'んで', $verb_suffix);
			$renyou = $verb_prefix . str_replace($verb_suffix, 'び', $verb_suffix);
		}
		$nasai = $renyou . 'なさい';
	}
	elseif (isset($verb_group) && $verb_group == 2) {
		$verb_prefix = substr($entry, 0, -3);
		$verb_suffix = substr($entry, -3);
		$aff_present_indicative = $verb_suffix;
		$aff_presumptive = str_replace($verb_suffix, 'よう', $verb_suffix);
		if ($data['kana'] == 'くれる') $aff_imperative = str_replace($verb_suffix, 'れ', $verb_suffix); // Exception くれる
		else $aff_imperative = str_replace($verb_suffix, 'ろ', $verb_suffix);
		$aff_past_indicative = str_replace($verb_suffix, 'た', $verb_suffix);
		$aff_past_presumptive = str_replace($verb_suffix, 'たろう', $verb_suffix);
		$aff_present_progressive = str_replace($verb_suffix, 'ている', $verb_suffix);
		$aff_past_progressive = str_replace($verb_suffix, 'ていた', $verb_suffix);
		$aff_provisional = str_replace($verb_suffix, 'れば', $verb_suffix);
		$aff_conditional = str_replace($verb_suffix, 'たら', $verb_suffix);
		$aff_potential = str_replace($verb_suffix, 'られる', $verb_suffix);
		$aff_causative = str_replace($verb_suffix, 'させる', $verb_suffix);
		$neg_present_indicative = str_replace($verb_suffix, 'ない', $verb_suffix);
		$neg_presumptive = str_replace($verb_suffix, 'ないだろう', $verb_suffix);
		$neg_imperative = str_replace($verb_suffix, 'るな', $verb_suffix);
		$neg_past_indicative = str_replace($verb_suffix, 'なかった', $verb_suffix);
		$neg_past_presumptive = str_replace($verb_suffix, 'なかっただろう', $verb_suffix);
		$neg_present_progressive = str_replace($verb_suffix, 'ていない', $verb_suffix);
		$neg_past_progressive = str_replace($verb_suffix, 'ていなかった', $verb_suffix);
		$neg_provisional = str_replace($verb_suffix, 'なければ', $verb_suffix);
		$neg_conditional = str_replace($verb_suffix, 'なかったら', $verb_suffix);
		$neg_potential = str_replace($verb_suffix, 'られない', $verb_suffix);
		$neg_causative = str_replace($verb_suffix, 'させない', $verb_suffix);
		$te = str_replace($verb_suffix, 'させない', $verb_suffix);
		$renyou = $verb_prefix;
		$nasai = $renyou . 'なさい';
	}
	
	// Finalize entry
	$aff_present_indicative = $verb_prefix . $aff_present_indicative;
	$neg_present_indicative = $verb_prefix . $neg_present_indicative;
	$aff_presumptive = $verb_prefix . $aff_presumptive;
	$neg_presumptive = $verb_prefix . $neg_presumptive;
	$aff_imperative = $verb_prefix . $aff_imperative;
	$neg_imperative = $verb_prefix . $neg_imperative;
	$aff_past_indicative = $verb_prefix . $aff_past_indicative;
	$neg_past_indicative = $verb_prefix . $neg_past_indicative;
	$aff_past_presumptive = $verb_prefix . $aff_past_presumptive;
	$neg_past_presumptive = $verb_prefix . $neg_past_presumptive;
	$aff_present_progressive = $verb_prefix . $aff_present_progressive;
	$neg_present_progressive = $verb_prefix . $neg_present_progressive;
	$aff_past_progressive = $verb_prefix . $aff_past_progressive;
	$neg_past_progressive = $verb_prefix . $neg_past_progressive;
	$aff_provisional = $verb_prefix . $aff_provisional;
	$neg_provisional = $verb_prefix . $neg_provisional;
	$aff_conditional = $verb_prefix . $aff_conditional;
	$neg_conditional = $verb_prefix . $neg_conditional;
	$aff_potential = $verb_prefix . $aff_potential;
	$neg_potential = $verb_prefix . $neg_potential;
	$aff_causative = $verb_prefix . $aff_causative;
	$neg_causative = $verb_prefix . $neg_causative;
	$te = $verb_prefix . $te;


	if ($entry == '来る') {
		$aff_present_indicative = '来る';
		$aff_presumptive = '来よう';
		$aff_imperative = '来い';
		$aff_past_indicative = '来た';
		$aff_past_presumptive = '来たろう';
		$aff_present_progressive = '来ている';
		$aff_past_progressive = '来ていた';
		$aff_provisional = '来れば';
		$aff_conditional = '来たら';
		$aff_potential = '来られる';
		$aff_causative = '来させる';
		$neg_present_indicative = '来ない';
		$neg_presumptive = '来ないだろう';
		$neg_imperative = '来るな';
		$neg_past_indicative = '来なかった';
		$neg_past_presumptive = '来なかっただろう';
		$neg_present_progressive = '来ていない';
		$neg_past_progressive = '来ていなかった';
		$neg_provisional = '来なければ';
		$neg_conditional = '来なかったら';
		$neg_potential = '来られない';
		$neg_causative = '来させない';
		$te = '来て';
		$renyou = '来';
		$nasai = '来なさい';
	}
	if (isset($verb_class) && $verb_class == 'vk') {
		$verb_prefix = substr($data['kana'], 0, -6);
		$verb_suffix = substr($entry, -6);
		$aff_present_indicative = $verb_prefix .'来る';
		$aff_presumptive = $verb_prefix .'来よう';
		$aff_imperative = $verb_prefix .'来い';
		$aff_past_indicative = $verb_prefix .'来た';
		$aff_past_presumptive = $verb_prefix .'来たろう';
		$aff_present_progressive = $verb_prefix .'来ている';
		$aff_past_progressive = $verb_prefix .'来ていた';
		$aff_provisional = $verb_prefix .'来れば';
		$aff_conditional = $verb_prefix .'来たら';
		$aff_potential = $verb_prefix .'来られる';
		$aff_causative = $verb_prefix .'来させる';
		$neg_present_indicative = $verb_prefix .'来ない';
		$neg_presumptive = $verb_prefix .'来ないだろう';
		$neg_imperative = $verb_prefix .'来るな';
		$neg_past_indicative = $verb_prefix .'来なかった';
		$neg_past_presumptive = $verb_prefix .'来なかっただろう';
		$neg_present_progressive = $verb_prefix .'来ていない';
		$neg_past_progressive = $verb_prefix .'来ていなかった';
		$neg_provisional = $verb_prefix .'来なければ';
		$neg_conditional = $verb_prefix .'来なかったら';
		$neg_potential = $verb_prefix .'来られない';
		$net_causative = $verb_prefix .'来させない';
		$te = $verb_prefix .'来て';
		$renyou = $verb_prefix .'来';
		$nasai = $verb_prefix .'来なさい';		
	}
	if ($entry == 'する') {
		$aff_present_indicative = $verb_suffix;
		$aff_presumptive = str_replace($verb_suffix, 'しよう', $verb_suffix);
		$aff_imperative = str_replace($verb_suffix, 'しろ', $verb_suffix);
		$aff_past_indicative = str_replace($verb_suffix, 'した', $verb_suffix);
		$aff_past_presumptive = str_replace($verb_suffix, 'したろう', $verb_suffix);
		$aff_present_progressive = str_replace($verb_suffix, 'している', $verb_suffix);
		$aff_past_progressive = str_replace($verb_suffix, 'していた', $verb_suffix);
		$aff_provisional = str_replace($verb_suffix, 'すれば', $verb_suffix);
		$aff_conditional = str_replace($verb_suffix, 'したら', $verb_suffix);
		$aff_potential = str_replace($verb_suffix, 'できる', $verb_suffix);
		$aff_causative = str_replace($verb_suffix, 'させる', $verb_suffix);
		$neg_present_indicative = str_replace($verb_suffix, 'しない', $verb_suffix);
		$neg_presumptive = str_replace($verb_suffix, 'しないだろう', $verb_suffix);
		$neg_imperative = str_replace($verb_suffix, 'するな', $verb_suffix);
		$neg_past_indicative = str_replace($verb_suffix, 'しなかった', $verb_suffix);
		$neg_past_presumptive = str_replace($verb_suffix, 'しなかっただろう', $verb_suffix);
		$neg_present_progressive = str_replace($verb_suffix, 'していない', $verb_suffix);
		$neg_past_progressive = str_replace($verb_suffix, 'していなかった', $verb_suffix);
		$neg_provisional = str_replace($verb_suffix, 'しなければ', $verb_suffix);
		$neg_conditional = str_replace($verb_suffix, 'しなかったら', $verb_suffix);
		$neg_potential = str_replace($verb_suffix, 'できない', $verb_suffix);
		$neg_causative = str_replace($verb_suffix, 'させない', $verb_suffix);
		$te = str_replace($verb_suffix, 'して', $verb_suffix);
		$renyou = 'し';
		$nasai = $renyou . 'なさい';
	}
	if (isset($verb_class) && $verb_class == 'vs-s') {
		$verb_prefix = substr($data['kana'], 0, -6);
		$verb_suffix = substr($entry, -6);
		$aff_present_indicative = $verb_suffix;
		$aff_presumptive = str_replace($verb_suffix, 'しよう', $verb_suffix);
		$aff_imperative = str_replace($verb_suffix, 'しろ', $verb_suffix);
		$aff_past_indicative = str_replace($verb_suffix, 'した', $verb_suffix);
		$aff_past_presumptive = str_replace($verb_suffix, 'したろう', $verb_suffix);
		$aff_present_progressive = str_replace($verb_suffix, 'している', $verb_suffix);
		$aff_past_progressive = str_replace($verb_suffix, 'していた', $verb_suffix);
		$aff_provisional = str_replace($verb_suffix, 'すれば', $verb_suffix);
		$aff_conditional = str_replace($verb_suffix, 'したら', $verb_suffix);
		$aff_potential = str_replace($verb_suffix, 'できる', $verb_suffix);
		$aff_causative = str_replace($verb_suffix, 'させる', $verb_suffix);
		$neg_present_indicative = str_replace($verb_suffix, 'しない', $verb_suffix);
		$neg_presumptive = str_replace($verb_suffix, 'しないだろう', $verb_suffix);
		$neg_imperative = str_replace($verb_suffix, 'するな', $verb_suffix);
		$neg_past_indicative = str_replace($verb_suffix, 'しなかった', $verb_suffix);
		$neg_past_presumptive = str_replace($verb_suffix, 'しなかっただろう', $verb_suffix);
		$neg_present_progressive = str_replace($verb_suffix, 'していない', $verb_suffix);
		$neg_past_progressive = str_replace($verb_suffix, 'していなかった', $verb_suffix);
		$neg_provisional = str_replace($verb_suffix, 'しなければ', $verb_suffix);
		$neg_conditional = str_replace($verb_suffix, 'しなかったら', $verb_suffix);
		$neg_potential = str_replace($verb_suffix, 'できない', $verb_suffix);
		$neg_causative = str_replace($verb_suffix, 'させない', $verb_suffix);
		$te = str_replace($verb_suffix, 'して', $verb_suffix);	
		$renyou = str_replace($verb_suffix, 'し', $verb_suffix);	
		$nasai = $renyou . 'なさい';
	}
	
	
	$sqlreq = "INSERT INTO `japansensei`.`verbs` (`verb_id`, `verb_name`, `verb_group`, `verb_transitive`, `verb_class`, `aff_present_indicative`, `neg_present_indicative`, `aff_presumptive`, `neg_presumptive`, `aff_imperative`, `neg_imperative`, `aff_past_indicative`, `neg_past_indicative`, `aff_past_presumptive`, `neg_past_presumptive`, `aff_present_progressive`, `neg_present_progressive`, `aff_past_progressive`, `neg_past_progressive`, `aff_provisional`, `neg_provisional`, `aff_conditional`, `neg_conditional`, `aff_potential`, `neg_potential`, `aff_causative`, `neg_causative`, `te`, `renyou`, `nasai`) VALUES (NULL, '". $entry ."', ". $verb_group .", ". $verb_transitive .", '". $verb_class ."', '". $aff_present_indicative ."', '".  $neg_present_indicative ."', '". $aff_presumptive ."', '". $neg_presumptive ."', '". $aff_imperative ."', '". $neg_imperative ."', '". $aff_past_indicative ."', '". $neg_past_indicative ."', '". $aff_past_presumptive ."', '". $neg_past_presumptive ."', '". $aff_present_progressive ."', '". $neg_present_progressive ."', '".  $aff_past_progressive ."', '". $neg_past_progressive ."', '". $aff_provisional ."', '". $neg_provisional ."', '". $aff_conditional ."', '". $neg_conditional ."', '". $aff_potential ."', '". $neg_potential ."', '". $aff_causative ."', '". $neg_causative ."', '". $te ."', '". $renyou ."', '". $nasai ."');";
	mysql_query($sqlreq);
	echo ".";

	// Duplicate entries for verbs usually in kana
	if (substr_count($data['english'], '(uk') >= 1) $uk = 1;
	elseif (substr_count($data['english'], ',uk') >= 1) $uk = 1;
	else $uk = 0;
	if ($uk == 1) {
		$sqlreq = "INSERT INTO `japansensei`.`verbs` (`verb_id`, `verb_name`, `verb_group`, `verb_transitive`, `verb_class`, `aff_present_indicative`, `neg_present_indicative`, `aff_presumptive`, `neg_presumptive`, `aff_imperative`, `neg_imperative`, `aff_past_indicative`, `neg_past_indicative`, `aff_past_presumptive`, `neg_past_presumptive`, `aff_present_progressive`, `neg_present_progressive`, `aff_past_progressive`, `neg_past_progressive`, `aff_provisional`, `neg_provisional`, `aff_conditional`, `neg_conditional`, `aff_potential`, `neg_potential`, `aff_causative`, `neg_causative`, `te`, `renyou`, `nasai`) VALUES (NULL, '". $data['kana'] ."', ". $verb_group .", ". $verb_transitive .", '". $verb_class ."', '". $aff_present_indicative ."', '". $neg_present_indicative ."', '". $aff_presumptive ."', '". $neg_presumptive ."', '". $aff_imperative ."', '". $neg_imperative ."', '". $aff_past_indicative ."', '". $neg_past_indicative ."', '". $aff_past_presumptive ."', '". $neg_past_presumptive ."', '". $aff_present_progressive ."', '". $neg_present_progressive ."', '". $aff_past_progressive ."', '". $neg_past_progressive ."', '". $aff_provisional ."', '". $neg_provisional ."', '". $aff_conditional ."', '". $neg_conditional ."', '". $aff_potential ."', '". $neg_potential ."', '". $aff_causative ."', '". $neg_causative ."', '". $te ."', '". $renyou ."', '". $nasai ."');";
		mysql_query($sqlreq);
	}
}
$time_end = microtime(true);
$time = round($time_end - $time_start,0);
echo "done in ". $time ."s\n";
mysql_close();
?>