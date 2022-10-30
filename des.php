<?php 

session_start();
$_SESSION = array();
session_destroy();

switch ($_GET['test']) {
    case 'sessions':
        header('Location: http://localhost/ClubPet/test/teste.php');
        break;
    
    default:
        header('Location: http://localhost/ClubPet/login-cliente.php');
        break;
}



exit(); 

?>