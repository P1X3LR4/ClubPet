<?php

require './functions.php';

// VERIFICAÇÃO DE CLIENTE NÃO LOGADO
if (!isset($_SESSION['func_logged_id'])) {

    $_SESSION['mensage_access_login_fun'] = '<div class="toast align-items-center text-bg-' . setColor('error') . ' border-0" role="alert" style="position: absolute; top: 60%; right: 20px; z-index: 10;" id="myToastMessageAcess">
    <div class="d-flex">
      <div class="toast-body">
      Área Restrita
       </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>';
    header('Location: http://localhost/ClubPet/login-funcionario.php');

}

if (isset($_SESSION['func_logged_id']) && $_SESSION['func_logged_cargo'] != 'Administrador') {
    $_SESSION['mensage_access_admin'] = '<div class="toast align-items-center text-bg-' . setColor('error') . ' border-0" role="alert" style="position: absolute; top: 60%; right: 20px; z-index: 10;" id="myToastMessageAccess">
    <div class="d-flex">
      <div class="toast-body">
      Função exclusiva do Administrador !!
       </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>';

    header('Location: http://localhost/ClubPet/listar-agendamentos.php');
}
