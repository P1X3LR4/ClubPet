<?php
session_start();

require 'db-conn.php';


/**
 * FUNÇÃO RESPONSÁVEL PELA VALIDAÇÃO DE CAMPOS VAZIOS
 */
function receiveData($dados, $redirect, $operation)
{
    require 'db-conn.php';
    require 'functions.php';

    global $dados_array;

    $dadosT = $dados;

    $dados_array = array();

    foreach ($dadosT as $key => $value) {
        $dados_array[$key] = $dados["$key"];
    }

    foreach ($dados_array as $dado => $value) {

        if (!empty($value)) {
            $_SESSION[$dado] = $dados[$dado];
        } else {

            $_SESSION['vazio_mensagem'] = '<div class="toast align-items-center text-bg-warning border-0" role="alert" style="position: absolute; top: 20%; right: 20px; z-index: 10;" id="myToast">
            <div class="d-flex">
              <div class="toast-body">
              O Campo ' . FunctionName($dado, $operation) . ' está vazio!
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>';
            header("Location: $redirect");
            exit();
        }
    }
}

/**
 * FUNÇÃO RESPONSÁVEL PELA PROCESSAMENTO DE ENVIO DE IMAGENS
 */
function uploadImage($error, $size, $name, $tmp_name, $redirect_i)
{
    require 'db-conn.php';

    if (!isset($_POST['editar_agendamento'])) {

        if ($error) {

            $_SESSION['message_img'] = '<div class="toast align-items-center text-bg-' . setColor('alert') . ' border-0" role="alert" style="position: absolute; top: 20%; right: 20px; z-index: 10;" id="myToast">
        <div class="d-flex">
          <div class="toast-body">
            Selecione uma image para envio!!
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>';
            header("Location: $redirect_i");
            exit();
        }
    }

    if ($size > 5242880) {
        $_SESSION['message_img'] = '<div class="toast align-items-center text-bg-' . setColor('alert') . ' border-0" role="alert" style="position: absolute; top: 20%; right: 20px; z-index: 10;" id="myToast">
        <div class="d-flex">
          <div class="toast-body">
          A imagem excede o limite de tamanho de <b>5MB</b>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>';
        header("Location: $redirect_i");
        exit();
    }

    $pasta          = 'uploads/';
    $name_file      = $name;
    $name_new_file  = uniqid();
    $extension_file = strtolower(pathinfo($name_file, PATHINFO_EXTENSION));

    if ($extension_file != 'jpg' && $extension_file != 'jpeg' && $extension_file != 'png') {
        $_SESSION['message_img'] = '<div class="toast align-items-center text-bg-' . setColor('alert') . ' border-0" role="alert" style="position: absolute; top: 20%; right: 20px; z-index: 10;" id="myToast">
        <div class="d-flex">
          <div class="toast-body">
            É somente possível o envio de arquivos de imagem (*jpg, *jpeg, *png)
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>';
        header("Location: $redirect_i");
        exit();
    }

    // continue file env
    $path = $pasta . $name_new_file . '.' . $extension_file;

    if (move_uploaded_file($tmp_name, $path)) {

        return array(
            'name_file' =>  $name_file,
            'path' =>  $path
        );
    } else
        return false;
}

/** 
 * DADOS RECEBIDOS DO FORMULARIO DE AGENDAMENTO
 */
if (isset($_POST['salvar_agendamento'])) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $redirect = "http://localhost/ClubPet/registrar-agendamento.php";



    ((!isset($_POST['agen_servico'])) ? $dados['agen_servico'] = '' : '');

    receiveData($dados, $redirect, 'agendamento');

    if (isset($_SESSION['func_logged_id'])) {
        $agen_cli_id   = mysqli_real_escape_string($conn, $_SESSION['func_logged_id']);
    } else {
        $agen_cli_id  = mysqli_real_escape_string($conn, $_SESSION['cli_logged_id']);
    }
    $agen_nome_pet  = mysqli_real_escape_string($conn, $_SESSION['agen_nome_pet']);
    $agen_raca      = mysqli_real_escape_string($conn, $_SESSION['agen_raca']);
    $agen_sexo      = mysqli_real_escape_string($conn, $_SESSION['agen_sexo']);
    $agen_servico   = mysqli_real_escape_string($conn, implode(" - ", $_SESSION['agen_servico']));
    $agen_pagamento = mysqli_real_escape_string($conn, $_SESSION['agen_pagamento']);
    $agen_horario   = mysqli_real_escape_string($conn, $_SESSION['agen_horario']);
    $agen_data      = mysqli_real_escape_string($conn, $_SESSION['agen_data']);

    if (isset($_FILES['agen_image'])) {
        $image = $_FILES['agen_image'];

        $upload_image = uploadImage($image['error'], $image['size'], $image['name'], $image['tmp_name'], $redirect);
    }

    $agen_upload_name = $upload_image['name_file'];
    $agen_upload_path = $upload_image['path'];

    $query = " INSERT INTO `clubpet`.`agendamentos` (agen_data, agen_horario, agen_nome_pet, agen_raca, agen_sexo, agen_servico, agen_pagamento, agen_cli_id, agen_upload_name, agen_upload_path, agen_creation) VALUES ('$agen_data', '$agen_horario', '$agen_nome_pet', '$agen_raca', '$agen_sexo', '$agen_servico', '$agen_pagamento', '$agen_cli_id', '$agen_upload_name', '$agen_upload_path', NOW())";

    if (@mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Agendamento cadastrado com sucesso!";

        // RESETA AS SESSÕES QUE CONTÉM OS DADOS RECEIDOS DO FORMULÁRIO
        resetDadosSessions($_POST['salvar_agendamento'], $dados_array);

        header("Location: $redirect");
        exit();
    } else {
        $_SESSION['message'] = "Agendamento não cadastrado";
        header("Location: $redirect");
        exit();
    }
}

/** 
 * DADOS RECEBIDOS DO FORMULARIO DE CADASTRO DO CLIENTE
 */
if (isset($_POST['send_register_client'])) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $redirect = "http://localhost/ClubPet/registrar-cliente.php";

    receiveData($dados, $redirect, 'registrar-cliente');

    $cli_nome     = mysqli_real_escape_string($conn, $_SESSION['cli_nome']);
    $cli_cpf      = mysqli_real_escape_string($conn, $_SESSION['cli_cpf']);
    $cli_telefone = mysqli_real_escape_string($conn, $_SESSION['cli_telefone']);
    $cli_endereco = mysqli_real_escape_string($conn, $_SESSION['cli_endereco']);
    $cli_email    = mysqli_real_escape_string($conn, $_SESSION['cli_email']);
    $cli_senha    = mysqli_real_escape_string($conn, $_SESSION['cli_senha']);
    $cli_senha = password_hash($cli_senha, PASSWORD_DEFAULT);

    $query_select = " SELECT * FROM `clubpet`.`clientes` WHERE email = '$cli_email' OR cpf = '$cli_cpf'";
    $exec_query = mysqli_query($conn, $query_select);
    $result = mysqli_num_rows($exec_query);

    if ($result > 0) {

        $_SESSION['message'] = "Você já está cadastrado !!";
        header("Location: $redirect");
        exit();
    }

    $query = " INSERT INTO `clubpet`.`clientes` (nome, cpf, telefone, endereco, email, senha) VALUES ('$cli_nome','$cli_cpf','$cli_telefone','$cli_endereco','$cli_email','$cli_senha')";

    if (@mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Cadastrado realizado com sucesso!";

        // RESETA AS SESSÕES QUE CONTÉM OS DADOS RECEIDOS DO FORMULÁRIO
        resetDadosSessions($_POST['send_register_client'], $dados_array);

        header("Location: $redirect");
        exit();
    } else {
        $_SESSION['message'] = "Registros não cadastrados";
        header("Location: $redirect");
        exit();
    }
}

/** 
 * DADOS RECEBIDOS DO FORMULARIO DE CADASTRO DO FUNCIONARIO
 */
if (isset($_POST['send_register_func'])) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $redirect = "http://localhost/ClubPet/registrar-funcionario.php";


    receiveData($dados, $redirect, 'registrar-funcionario');

    $func_nome     = mysqli_real_escape_string($conn, $_SESSION['func_nome']);
    $func_telefone = mysqli_real_escape_string($conn, $_SESSION['func_telefone']);
    $func_email    = mysqli_real_escape_string($conn, $_SESSION['func_email']);
    $func_cpf      = mysqli_real_escape_string($conn, $_SESSION['func_cpf']);
    $func_cargo    = mysqli_real_escape_string($conn, $_SESSION['func_cargo']);
    $func_senha    = mysqli_real_escape_string($conn, $_SESSION['func_senha']);
    $func_senha    = password_hash($func_senha, PASSWORD_DEFAULT);

    $query_select = " SELECT * FROM `clubpet`.`funcionarios` WHERE func_email = '$func_email' OR func_cpf = '$func_cpf'";
    $exec_query = mysqli_query($conn, $query_select);
    $result = mysqli_num_rows($exec_query);

    if ($result > 0) {

        $_SESSION['message'] = "Você já está cadastrado !!";
        header("Location: $redirect");
        exit();
    }

    $query = " INSERT INTO `clubpet`.`funcionarios` (func_nome, func_tel, func_email, func_cpf, func_cargo, func_access_master, func_senha, func_created) VALUES ('$func_nome','$func_telefone','$func_email','$func_cpf','$func_cargo', 0,'$func_senha', NOW())";

    if (@mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Funcionário Cadastrado com sucesso!";

        // RESETA AS SESSÕES QUE CONTÉM OS DADOS RECEIDOS DO FORMULÁRIO
        if (isset($_POST['send_register_func'])) {

            foreach ($dados_array as $dado => $value) {
                unset($_SESSION[$dado]);
            }
        }
        header("Location: $redirect");
        exit();
    } else {
        $_SESSION['message'] = "Funcionário não cadastrado";
        header("Location: $redirect");
        exit();
    }
}

/** 
 * PROCESSO DE LOGIN DO CLIENTE
 */
if (isset($_POST['login_cliente'])) {
    $login_dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $login_redirect = "http://localhost/ClubPet/login-cliente.php";

    receiveData($login_dados, $login_redirect, 'login-cliente');

    $cli_login_email     = mysqli_real_escape_string($conn, $_SESSION['cli_login_email']);
    $cli_login_senha     = mysqli_real_escape_string($conn, $_SESSION['cli_login_senha']);

    resetDadosSessions($_POST['login_cliente'], $dados_array);

    $query_select = " SELECT * FROM `clubpet`.`clientes` WHERE email = '$cli_login_email'";
    $exec_query = mysqli_query($conn, $query_select);
    $result = mysqli_num_rows($exec_query);
    if ($result > 0) {

        while ($row = @mysqli_fetch_assoc($exec_query)) {

            if (password_verify($cli_login_senha, $row['senha'])) {

                $_SESSION['cli_logged_nome'] = $row['nome'];
                $_SESSION['cli_logged_id'] = $row['idCliente'];

                header('Location: http://localhost/ClubPet/listar-agendamentos.php');
                exit();
            } else {
                $_SESSION['message'] = "EMAIL ou SENHA INCORRETO(S)!";
                header("Location: $login_redirect");
                exit();
            }
        }
    } else {
        $_SESSION['message'] = "EMAIL ou SENHA incorreto(s)!";
        header("Location: $login_redirect");
        exit();
    }
}

/** 
 * PROCESSO DE LOGIN DO FUNCIONARIO
 */
if (isset($_POST['login_funcionario'])) {
    $login_dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $login_func_redirect = "http://localhost/ClubPet/login-funcionario.php";

    receiveData($login_dados, $login_func_redirect, 'login-funcionario');

    $func_login_cpf     = mysqli_real_escape_string($conn, $_SESSION['func_login_cpf']);
    $func_login_senha   = mysqli_real_escape_string($conn, $_SESSION['func_login_senha']);

    $query_select = " SELECT * FROM `clubpet`.`funcionarios` WHERE func_cpf = '$func_login_cpf'";

    $exec_query = mysqli_query($conn, $query_select);
    $result = mysqli_num_rows($exec_query);
    if ($result == 1) {

        while ($row = @mysqli_fetch_assoc($exec_query)) {
            if (password_verify($func_login_senha, $row['func_senha'])) {

                $_SESSION['func_logged_nome'] = $row['func_nome'];
                $_SESSION['func_logged_id'] = $row['func_id'];
                $_SESSION['func_logged_cargo'] = $row['func_cargo'];

                resetDadosSessions($_POST['login_funcionario'], $dados_array);

                header('Location: http://localhost/ClubPet/listar-agendamentos.php');
                exit();
            } else {
                $_SESSION['message'] = "EMAIL ou SENHA incorreto(s)";
                header("Location: $login_func_redirect");
                exit();
            }
        }
    } else {
        $_SESSION['message'] = "EMAIL ou SENHA incorreto(s)";
        header("Location: $login_func_redirect");
        exit();
    }
}

/** 
 * PROCESSO DE DELETAR AGENDAMENTOS
 */
if (isset($_POST['delete_agenda'])) {

    $id = mysqli_real_escape_string($conn, $_POST['delete_agenda']);

    $query = " SELECT agen_upload_path FROM `clubpet`.`agendamentos` WHERE agen_id = '$id'";
    $dados = (mysqli_query($conn, $query))->fetch_assoc();

    if (unlink($dados['agen_upload_path'])) {

        $query = " DELETE FROM `clubpet`.`agendamentos` WHERE agen_id = '$id'";

        if (mysqli_query($conn, $query)) {

            $_SESSION['message'] = "Agendamento EXCLUIDO com sucesso";
            header("Location: http://localhost/ClubPet/listar-agendamentos.php");
            exit();
        } else {

            $_SESSION['message'] = "Não foi possivel EXCLUIR o agendamento";
            header("Location: http://localhost/ClubPet/listar-agendamentos.php");
            exit();
        }
    }
}

/** 
 * PROCESSO DE DELETAR FUNCIONARIOS
 */
if (isset($_POST['delete_funcionario'])) {

    $id = mysqli_real_escape_string($conn, $_POST['delete_funcionario']);

    $query = " DELETE FROM `clubpet`.`funcionarios` WHERE func_id = '$id'";

    if (mysqli_query($conn, $query)) {

        $_SESSION['message'] = "Funcionário EXCLUIDO com sucesso";
        header("Location: http://localhost/ClubPet/listar-funcionarios.php");
        exit();
    } else {

        $_SESSION['message'] = "Não foi possivel EXCLUIR o Funcionário";
        header("Location: http://localhost/ClubPet/listar-funcionarios.php");
        exit();
    }
}

/** 
 * PROCESSO DE EDITAR AGENDAMENTOS
 */
if (isset($_POST['editar_agendamento'])) {


    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $redirect = "http://localhost/ClubPet/editar-agendamento.php";

    $_SESSION['editar_agendamento'] = $_POST['editar_agendamento'];

    ((!isset($_POST['agen_servico'])) ? $dados['agen_servico'] = '' : '');

    receiveData($dados, $redirect, 'agendamento');

    $id             = mysqli_real_escape_string($conn, $_POST['editar_agendamento']);
    $agen_nome_pet  = mysqli_real_escape_string($conn, $_SESSION['agen_nome_pet']);
    $agen_raca      = mysqli_real_escape_string($conn, $_SESSION['agen_raca']);
    $agen_sexo      = mysqli_real_escape_string($conn, $_SESSION['agen_sexo']);
    $agen_servico   = mysqli_real_escape_string($conn, implode(" - ", $_SESSION['agen_servico']));
    $agen_pagamento = mysqli_real_escape_string($conn, $_SESSION['agen_pagamento']);
    $agen_horario   = mysqli_real_escape_string($conn, $_SESSION['agen_horario']);
    $agen_data      = mysqli_real_escape_string($conn, $_SESSION['agen_data']);

    if (isset($_FILES['agen_image']) && $_FILES['agen_image']['name'] != '') {

        $query = " SELECT * FROM `clubpet`.`agendamentos` WHERE agen_id = '$id'";
        $dados = (mysqli_query($conn, $query))->fetch_assoc();

        $exec_query = mysqli_query($conn, $query);
        $result = mysqli_num_rows($exec_query);

        if ($result > 0) {
            if (unlink($dados['agen_upload_path'])) {

                $image = $_FILES['agen_image'];
                $upload_image = uploadImage($image['error'], $image['size'], $image['name'], $image['tmp_name'], $redirect);
                $agen_upload_name = $upload_image['name_file'];
                $agen_upload_path = $upload_image['path'];
            }
        }
    }

    if (isset($agen_upload_name) && isset($agen_upload_path)) {
        $query = " UPDATE `clubpet`.`agendamentos` SET agen_data = '$agen_data', agen_horario = '$agen_horario', agen_nome_pet = '$agen_nome_pet', agen_raca = '$agen_raca', agen_sexo = '$agen_sexo', agen_servico = '$agen_servico', agen_pagamento = '$agen_pagamento', agen_upload_name = '$agen_upload_name', agen_upload_path ='$agen_upload_path' WHERE agen_id = '$id'";
    } else {

        $query = " UPDATE `clubpet`.`agendamentos` SET agen_data = '$agen_data', agen_horario = '$agen_horario', agen_nome_pet = '$agen_nome_pet', agen_raca = '$agen_raca', agen_sexo = '$agen_sexo', agen_servico = '$agen_servico', agen_pagamento = '$agen_pagamento' WHERE agen_id = '$id'";
    }


    if (@mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Agendamento EDITADO com sucesso!";

        // RESETA AS SESSÕES QUE CONTÉM OS DADOS RECEIDOS DO FORMULÁRIO
        resetDadosSessions($_POST['editar_agendamento'], $dados_array);

        header("Location: http://localhost/ClubPet/listar-agendamentos.php");
        exit();
    } else {
        $_SESSION['message'] = "Erro ao EDITAR agendamento!";
        header("Location: $redirect");
        exit();
    }
}

/** 
 * PROCESSO DE EDITAR FUNCIONARIOS
 */
if (isset($_POST['editar_funcionario'])) {


    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $redirect = "http://localhost/ClubPet/editar-funcionario.php";


    $_SESSION['editar_funcionario'] = $_POST['editar_funcionario'];

    receiveData($dados, $redirect, 'registrar-funcionario');

    $id           = mysqli_real_escape_string($conn, $_POST['editar_funcionario']);
    $func_nome     = mysqli_real_escape_string($conn, $_SESSION['func_nome']);
    $func_telefone = mysqli_real_escape_string($conn, $_SESSION['func_telefone']);
    $func_email    = mysqli_real_escape_string($conn, $_SESSION['func_email']);
    $func_cpf      = mysqli_real_escape_string($conn, $_SESSION['func_cpf']);
    $func_cargo    = mysqli_real_escape_string($conn, $_SESSION['func_cargo']);


    $query_select = " SELECT * FROM `clubpet`.`funcionarios` WHERE (func_email = '$func_email' OR func_cpf = '$func_cpf') AND func_id != '$id'";
    $exec_query = mysqli_query($conn, $query_select);
    $result = mysqli_num_rows($exec_query);

    if ($result > 0) {

        $_SESSION['message'] = "E-mail e/ou CPF já está cadastrado !!";

        $_SESSION['reset'] = $dados_array;

        header("Location: $redirect");

        exit();
    }

    $query = " UPDATE `clubpet`.`funcionarios` SET func_nome = '$func_nome', func_tel = '$func_telefone', func_email = '$func_email', func_cpf = '$func_cpf', func_cargo = '$func_cargo'WHERE func_id = '$id'";


    if (@mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Funcionário EDITADO com sucesso!";

        // RESETA AS SESSÕES QUE CONTÉM OS DADOS RECEIDOS DO FORMULÁRIO
        resetDadosSessions($_POST['editar_funcionario'], $dados_array);
        header("Location: http://localhost/ClubPet/listar-funcionarios.php");
        exit();
    } else {
        $_SESSION['message'] = "Erro ao EDITAR Funcionário!";
        header("Location: $redirect");
        exit();
    }
}
