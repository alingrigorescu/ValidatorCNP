<?php

function form($value){

//daca valoarea variabilei $value este 1 atunci se afiseaza campul cnp - gol
    if ($value == 1){
		$cnp = '';
	}
// se genereaza variabila cu tabelul care contine formularul

    $form = '<div align="center">
        <form method="post" action="'.$_SERVER['PHP_SELF'].'">
        <input name="cnp" type="text" value="'.$cnp.'" size="20">
        <input type="submit" name="Submit" value="Verifica CNP!" size="25"><br>
        </form>
        </div>';
    return $form;
}

function get_data($v) {
    // Preluare cnp prin post
    if($v=1){
        $p_cnp = trim($_POST['cnp']);
        return $p_cnp;
	}

}

function isCnpValid($a) {
    // se verifica daca cnp-ul este format din 13 caractere
    if(strlen($a) != 13) {
        return false;
    }
    $cnp = str_split($a);
    $hashTable = array( 2 , 7 , 9 , 1 , 4 , 6 , 3 , 5 , 8 , 2 , 7 , 9 );
    $hashResult = 0;
    // se verifica daca cnp-ul este numeric
    for($i=0 ; $i<13 ; $i++) {
        if(!is_numeric($cnp[$i])) {
            return false;
        }
        $cnp[$i] = (int)$cnp[$i];
        if($i < 12) {
            $hashResult += (int)$cnp[$i] * (int)$hashTable[$i];
        }
    }
    unset($hashTable, $i);
    // se verifica daca numarul de control este corect
    $hashResult = $hashResult % 11;
    if($hashResult == 10) {
        $hashResult = 1;
    }
    // se verifica daca prima cifra a cnp-ului este corecta
    if ($cnp[0] > 9 || $cnp[0] == 0){
        return false;
	}
    else{
        return true;
	}
}

// daca utilizatorul este pentru prima data pe pagina i se afiseaza campul cnp - gol
if(!isset($_POST['cnp'])) {

    echo form(1);
}
// daca s-a trimis ceva prin post, se preiau datele si se verifica
else{
    $r_cnp = get_data(1);
    $result = isCnpValid($r_cnp);
    // se afiseaza rezultatul dupa verificarea cnp-ului
    if ($result == false) {
        echo 'CNP-ul nu este valid!<br>';
	}
    else{
        echo 'CNP-ul este valid!<br>';
	}
}

?>