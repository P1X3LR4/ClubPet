<?php

require './functions.php';

// VERIFICAÇÃO DE CLIENTE NÃO LOGADO

if (!isset($_SESSION['cli_logged_id']) && !isset($_SESSION['func_logged_id'])) {

    $_SESSION['mensage_access'] = '<div class="toast align-items-center text-bg-' . setColor('info') . ' border-0" role="alert" style="position: absolute; top: 60%; right: 20px; z-index: 10;" id="myToastMessageAcess">
    <div class="d-flex">
      <div class="toast-body">
      Realize o Login para acessar a função!!
       </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>';
    header('Location: http://localhost/ClubPet/login-cliente.php');
}