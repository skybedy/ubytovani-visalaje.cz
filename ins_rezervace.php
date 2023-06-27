<?php
$over = md5(strtolower($over));
//echo $over.' - '.$test;
if (($akce=="odeslat") AND ($test==$over))
{
	$hlaska = " je povinný údaj, prosíme, <font color=#FF0000>vraťte se tlačítkem zpět ve vašem prohlížeči a vyplňte jej.</font><p>";
	if ($nick=='') echo "<b>Jméno/firma</b>".$hlaska;
	elseif ($email=='') echo "<b>Email</b>".$hlaska;
//	elseif (strstr($email,'@')=='') echo "<b>Email</b> byl nesprávně vyplněn. <font color=#FF0000>Vraťte se tlačítkem zpět ve vašem prohlížeči a vyplňte jej.</font><p>";
	elseif (!ereg("^.+@.+\\..+$", $email)) echo "<b>Email</b> byl nesprávně vyplněn. <font color=#FF0000>Vraťte se tlačítkem zpět ve vašem prohlížeči a vyplňte jej.</font><p>";
	elseif ($vlozeny_text=='') echo "<b>Váš dotaz</b>".$hlaska;
	else 
	{
		// udelat kontrolu vkladaneho obsahu htmlenties()
		
		$nick = htmlspecialchars($nick);
		$email = htmlspecialchars($email);
		$telefon = htmlspecialchars($telefon);
		$vlozeny_text = htmlspecialchars($vlozeny_text);
		
		$predmet="UBYTOVANI: Rezervace";
		$zprava="Bylo zadáno do formuláře\n";
		$zprava.="------------------------\n";
		$zprava.="Jméno: ".$nick."\n";
		$zprava.="Email: ".$email."\n";
		$zprava.="Telefon: ".$telefon."\n";
		$zprava.="------------------------\n";
		$zprava.="Termín: ".$od." - ".$do."\n";
		$zprava.="Počet osob: ".$osob."\n";
		$zprava.="Poznámka: ".$vlozeny_text;
		$zprava.="\n\n";
		$header="From: $email\n";
		$header .= "bcc: poptavka@b7.cz\n";
		$header.="Content-Type: text/plain; charset=\"windows-1250\"";
		if (
			Mail(
				"b.hrckova@seznam.cz",
				$predmet,
				$zprava,
				$header
				)) echo "<h3>Požadavek byl úspěšně odeslán.</h3><p>Děkujeme.";
		else "<h3>Požadavek se nepodařilo odeslat!</h3><p>Omlouváme se za potíže, kontaktujte nás e-mailem<p>";
	}
}
elseif (($akce=="odeslat") AND ($test!=$over)) echo "<font color=#FF0000>Je nutné vyplnit kontrolní text, abychom ověřili, že nejste spam.</font>";
?>
<p>
<form action="" method="post">
	<table cellspacing="2" cellpadding="2" class="view">
	<tr>
	    <td><b>Jméno a příjmení: </b></td>
	    <td><input type="text" name="nick" size="45" maxlength="255"> *</td>
	</tr>
	<tr>
	    <td><b>Telefon: </b></td>
	    <td><input type="text" name="telefon" size="45" maxlength="255"></td>
	</tr>
	<tr>
	    <td><b>Email: </b></td>
	    <td><input type="text" name="email" size="45" maxlength="255"> *</td>
	</tr>
	<tr>
	    <td><b>Termín: </b></td>
	    <td>Od <input type="text" name="od" size="15" maxlength="255"> do <input type="text" name="do" size="15" maxlength="255"></td>
	</tr>
	<tr>
	    <td><b>Počet osob: </b></td>
	    <td><input type="text" name="osob" size="5" maxlength="255"></td>
	</tr>
	<tr>
		<td colspan="2">
			<b>Poznámka:</b><br>
			<textarea cols="83" rows="5" name="vlozeny_text"></textarea>
		</td>
	</tr>
	<tr>
		<td>kontrolní text : </td>
			<td>
			<?
			$max_length_reg_key = 5;
			
			function gen_reg_key()
			{
				$key = "";
				$max_length_reg_key = 5;
				$chars = array(
//					"A","B","c","d","e","f","G","h","i","j","k","L","m",
//					"N","o","p","Q","r","s","T","u","V","w","x","y","z",
					"1","2","3","4","5","6","7","8","9");
			
				$count = count($chars) - 1;
			
				srand((double)microtime()*1000000);
			
				for($i = 0; $i < $max_length_reg_key; $i++)
				{
					$key .= $chars[rand(0, $count)];
				}
			
				return($key);
			}
			$reg_key = gen_reg_key();
			
	
			$test = md5(strtolower($reg_key));
			
			echo $reg_key;
			?>
			</td>
		</tr>
	<tr>
		<td><b>kontrola</b> : </td>
		<td><input type="text" name="over" size="5" maxlength="5"><input type="hidden" name="test" value="<? echo $test ?>"> <input type="submit" name="akce" value="odeslat"></td>
	</tr>
	</table>
</form>