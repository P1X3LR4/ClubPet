<?php

// VERIFICA SE EXISTE ALGUM USUARIO LOGADO
if (isset($_SESSION['func_logged_id']) || isset($_SESSION['cli_logged_id'])) {
    header('Location: http://localhost/ClubPet/index.php');
    exit();
}

