<?php 

/*
Créer une nouvelle fonction ayant le nom createFileName.
Elle acceptera un seul parametre de type int qui contiendra le nb de caratere du nom. SI le paramètre entré n'est pas un int on créer une erreur php de type "error"
fonction native utiles:
rand(x,y); = générer une chiffre aléatoire compris entre x et y
chr(x); = permet d'afficher un caractère a partir d'un chiffre
*/
//Ceci devra retourner le nouveau nom de fichier généré


function createFileName($nameLength){

	if(!is_int($nameLength) || $nameLength <=0){

		trigger_error('entrez un entier positif', E_USER_ERROR);

	}

	for($name = NULL; strlen($name)<=$nameLength;){

		$a= rand(0,1);

		if($a == 0){

			$name = $name. rand(0,9);

		}else{

			$name = $name.chr(rand(97,122));
		}

	}
	return $name;

}
	


 ?>