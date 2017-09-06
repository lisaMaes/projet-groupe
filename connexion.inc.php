<?php
try{
	$link= new PDO('mysql:host=localhost;dbname=cgu;charset=utf8;','root',''); // driver de connexion

}
catch (Execption $e){
	die('Erreur :' . $e->getMessage());
}
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>