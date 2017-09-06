<?php
try{
	$bdd= new PDO('mysql:host=localhost;dbname=projet-groupe;charset=utf8;','root',''); // driver de connexion

}
catch (Execption $e){
	die('Erreur :' . $e->getMessage());
}
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>