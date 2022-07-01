<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Kalkulator</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">
	<a href="<?php print(_APP_ROOT); ?>/app/protected_page.php" class="pure-button">kolejna chroniona strona</a>
	<a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
</div>

<div style="width:90%; margin: 2em auto;">
    
<form action="<?php print(_APP_ROOT); ?>/app/credit_calc.php" method="post" class="pure-form pure-form-stacked">
    <legend> Kalkulator kredytowy</legend>
	<label for="id_x">Kwota: </label>
	<input id="id_x" type="text" name="x" value="<?php out($kwota);?>" /><br />
	<label for="id_y">Lata: </label>
	<input id="id_y" type="text" name="y" value="<?php out($lata); ?>" /><br />
	<label for="id_z">Procent: </label>
	<input id="id_z" type="text" name="z" value="<?php out($procent); ?>" /><br />
        <select name="typ">	
		<option value="miesiac">koszt miesięczny</option>
		<option value="rok">koszt roczny</option>
	</select>
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)){
    if(count($messages)>0){
	echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
	foreach ( $messages	as $msg ) {
		echo '<li>'.$msg.'</li>';
	}
	echo '</ol>';
    }
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
 
<?php 
if($typ =='rok') echo 'Koszt roczny: '.$result; 
else echo 'Rata miesięczna: '.$result; 
?>
</div>
<?php } ?>
</div>
</body>
</html>