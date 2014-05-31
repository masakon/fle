if (!isset($_GET['s']))
{
	echo '<form method="GET">
	<input name="s" type="hidden" value="1" />
	<p>Part of speech : 
		
		<select name="part_of_speech">
			<option value="な形容詞">な形容詞(na adjective)</option>
		</select>
	</p>
	
	<p>Language register : 
		<select name="language_register">
			<option value="普通形">普通形 (neutral)</option>
		</select>
	</p>

	<p>Tense :
		<select name="tense">
			<option value="現在形">現在形 (present/future)</option>
			<option value="過去形">過去形 (past)</option>
		</select>
	</p>

	
	<input type="submit" value="OK">
	</form>
	
	</p>
	';
}

elseif (isset($_GET['s']) && $_GET['part_of_speech']=='な形容詞' && $_GET['s']==1) 
{
	
}

if (isset($_GET['s']) && $_GET['s']==1)
{
	echo '<hr /><p><a href="./">Retour</a></p>';
}






function verb_strip_kana($request) 
{
  $kanas = array("あ","ア","か","カ","さ","サ","た","タ","な","ナ","は","ハ","ま","マ","や","ヤ","ら","ラ","わ","ワ","い","イ","き","キ","し","シ","ち","チ","に","ニ","ひ","ヒ","み","ミ","り","リ","ゐ","ヰ","う","ウ","く","ク","す","ス","つ","ツ","ぬ","ヌ","ふ","フ","む","ム","ゆ","ユ","る","ル","え","エ","け","ケ","せ","セ","て","テ","ね","ネ","へ","ヘ","め","メ","れ","レ","ゑ","ヱ","お","オ","こ","コ","そ","ソ","と","ト","の","ノ","ほ","ホ","も","モ","よ","ヨ","ろ","ロ","を","ヲ","ん","ン");
  foreach ($kanas as $kana)
  {
    str_replace($kana, '', $request);
  }  
}   
















		if ($group == 1) {
			if ($verb_suffix == 'う')　{
				if ($tense == 'present_indicative') {};
				elseif ($tense == 'presumptive')　$verb_suffix = str_replace('う', 'おう', $verb_suffix);
				elseif ($tense == 'imperative')　$verb_suffix = str_replace('う', 'え', $verb_suffix);
				elseif ($tense == 'past_indicative')　$verb_suffix = str_replace('う', 'った', $verb_suffix);
				elseif ($tense == 'past_presumptive')　$verb_suffix = str_replace('う', 'ったろう', $verb_suffix);
				elseif ($tense == 'present_progressive') $verb_suffix = str_replace('う', 'っている', $verb_suffix);
				elseif ($tense == 'past_progressive') $verb_suffix = str_replace('う', 'っていた', $verb_suffix);
				elseif ($tense == 'provisional') $verb_suffix = str_replace('う', 'えば', $verb_suffix);
				elseif ($tense == 'conditional') $verb_suffix = str_replace('う', 'ったら', $verb_suffix);
				elseif ($tense == 'potential') $verb_suffix = str_replace('う', 'える', $verb_suffix);
				elseif ($tense == 'causative') $verb_suffix = str_replace('う', 'わせる', $verb_suffix);
				}
				elseif($affirmative == 'negative') {
					if ($tense == 'present_indicative') $verb_suffix = str_replace('う', 'わない', $verb_suffix);
					elseif ($tense == 'presumptive') $verb_suffix = str_replace('う', 'ないだろう', $verb_suffix);
					elseif ($tense == 'imperative') $verb_suffix = str_replace('う', 'うな', $verb_suffix);
					elseif ($tense == 'past_indicative') $verb_suffix = str_replace('う', 'わなかった', $verb_suffix);
					elseif ($tense == 'past_presumptive') $verb_suffix = str_replace('う', 'わなかっただろう', $verb_suffix);
					elseif ($tense == 'present_progressive') $verb_suffix = str_replace('う', 'っていない', $verb_suffix);
					elseif ($tense == 'past_progressive') $verb_suffix = str_replace('う', 'っていなかった', $verb_suffix);
					elseif ($tense == 'provisional') $verb_suffix = str_replace('う', 'わなければ', $verb_suffix);
					elseif ($tense == 'conditional') $verb_suffix = str_replace('う', 'わなかったら', $verb_suffix);
					elseif ($tense == 'potential') $verb_suffix = str_replace('う', 'えない', $verb_suffix);
					elseif ($tense == 'causative') $verb_suffix = str_replace('う', 'わせない', $verb_suffix);
				}
			}
		}
		else