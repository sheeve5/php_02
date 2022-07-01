<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';
//ochrona kontrolera - poniższy skrypt przerwie przetwarzanie w tym punkcie gdy użytkownik jest niezalogowany
include _ROOT_PATH.'/app/security/check.php';

function getParams(&$kwota, &$lata, &$procent, &$typ){
    $kwota = isset($_REQUEST ['x']) ? $_REQUEST ['x'] : null;
    $lata = isset($_REQUEST ['y']) ? $_REQUEST ['y'] : null;
    $procent = isset($_REQUEST ['z']) ? $_REQUEST ['z'] : null;
    $typ = isset($_REQUEST ['typ']) ? $_REQUEST ['typ'] : null;
}

function validate(&$kwota, &$lata, &$procent, &$typ, &$messages){
    
    	if ( ! (isset($kwota) && isset($lata) && isset($procent) && isset($typ))) {
		return false;
	}
    	if ( $kwota == "") {
		$messages [] = 'Nie podano liczby 1';
	}
	if ( $lata == "") {
		$messages [] = 'Nie podano liczby 2';
	}
	if ( $procent == "") {
		$messages [] = 'Nie podano liczby 3';
	}
        
        if ( $typ == "") {
		$messages [] = 'ta wiadomość nie powinna się pojawić';
	}
        
        if(count($messages)!=0) return false;

        	// sprawdzenie, czy $kwota, $lata i $procent są liczbami
	if (! is_numeric( $kwota )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $lata )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	

	if (! is_numeric( $procent )) {
		$messages [] = 'Trzecia wartość nie jest liczbą';
	}
    
        if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$kwota, &$lata, &$procent, &$typ, &$messages, &$result){
    
    global $role;
    	//konwersja parametrów na int
	$kwota = intval($kwota);
	$lata = intval($lata);

	//konwersja parametru na float
	$procent = floatval($procent);
	
	//wykonanie operacji        
        switch ($typ){
            case 'rok':
                if ($role == 'admin'){
			$result = ($kwota + $kwota*($procent/100)) / $lata;
		} else {
			$messages [] = 'Operacja obliczenia kosztu rocznego jest dostępna tylko dla administratora!';
		}
                break;
            default:
                $result = ($kwota + $kwota*($procent/100)) / ($lata*12);
                break;
        }

        
}



//definicja zmiennych kontrolera
$kwota = null;
$lata = null;
$procent = null;
$typ = null;
$result = null;
$messages = array();

//pobierz parametry i wykonaj zadanie jeśli wszystko w porządku
getParams($kwota,$lata ,$procent, $typ);
if ( validate($kwota,$lata ,$procent, $typ, $messages) ) { // gdy brak błędów
	process($kwota,$lata ,$procent, $typ, $messages, $result);
}

include 'credit_calc_view.php';