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











請う(v5u-s,vt) to ask/to request/to invite/(P)
. 訪う(v5u-s,vt) (1) to ask/to question/to inquire/(2) to charge (i.e. with a crime)/to accuse/(3) to care (about)/(4) without regard to (with negative verb)
. 問う(v5u-s,vt) (1) to ask/to question/to inquire/(2) to charge (i.e. with a crime)/to accuse/(3) to care (about)/(4) without regard to (with negative verb)/(P)
.


行く(v5k-s,vi) to go/(P)
. 行く(v5k-s,vi) to go/(P)
. 地でいく(v5k-s) to do for real/to do in real life/to carry (a story) into actual practice (practise)
. 地でゆく(v5k-s) to do for real/to do in real life/to carry (a story) into actual practice (practise)
. 地で行く(v5k-s) to do for real/to do in real life/to carry (a story) into actual practice (practise)
. 地で行く(v5k-s) to do for real/to do in real life/to carry (a story) into actual practice (practise)
. 連れて行く(v5k-s) to take someone (of lower status) along/(P)
.
いらっしゃる(v5aru,vi) (hon) to be/to come/to go/(P)
. 為さる(v5aru,vt) (hon) to do/(P)
. 下さる(v5aru) (hon) to give/to confer/(P)
. 仰っしゃる(v5aru,vt) (hon) (uk) to say/to speak/to tell/to talk/(P)
.