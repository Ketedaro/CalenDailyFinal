<?php

require('/../view/login.html');
// on se connecte à MySQL
include('/../modele/connectDB.php');

//On ouvre la page pour s'inscrire
if(isset($_POST['register'])) {
  header("Location: /CalenDailyProject/controller/register.php");
}

//On vérifie que les données sont correctes puis on redirige vers le calendrier
if(isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {
$_POST['password'] = hash("sha256", $_POST['password']);
  extract($_POST);
  $sql = "select password from membre where login='".$login."'";
  $request = mysqli_query($db, $sql) or die('SQL error !<br>'.$sql.'<br>'.mysql_error());
  $data = mysqli_fetch_assoc($request);
  if($data['password'] != $password) {
    echo 'Wrong login or password';
  }
  else {
    session_start();
    $_SESSION['login'] = $login;
    header("Location: /CalenDailyProject/controller/calendar.php");
  }
}

?>
