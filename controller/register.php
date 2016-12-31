<?php

require('/../view/register.html');

//Connexion à la BDD avec utilisation de PDO
  try {
   $bdd = new PDO ('mysql:host=localhost;dbname=calendaily', 'root', '');
  }
  catch(Exception $e) {
   die('Error :'.$e->getMessage());
  }

//On insère les valeurs des champs dans la BDD
if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {
  $login =   $_POST['login'];
  $password = $_POST['password'];
  $password = hash("sha256", $password);
  $request = $bdd->prepare('INSERT INTO membre(login, password) VALUES (:login, :password)');
  $request->execute(array("login" => $login, "password" => $password));
  session_start();
  $_SESSION['login'] = $_POST['login'];
  header('Location: /CalenDailyProject/controller/calendar.php');
}

?>
