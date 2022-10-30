<?php

session_start();

require './access/access-logged.php';

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar-se</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a9022c837e.js" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>

<body class="text-bg-dark" <!-- INCLUDE MENU -->
    <?php require './layout/menu.php'; ?>

    <div class="container mt-5">
        <?php
        if (isset($_SESSION['vazio_mensagem'])) {
            echo $_SESSION['vazio_mensagem'];
            unset($_SESSION['vazio_mensagem']);
        }
        require 'mensage.php';
        unset($_SESSION['mensage']);
        unset($_SESSION['mensage_access']);
        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border border-3 border-warning text-bg-dark">
                    <div class="card-header text-bg-warning">
                        <h4 class="text-center">Registrar-se</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 justify-content-evenly" action="data-control.php" method="POST">
                            <div class="col-8">
                                <label for="inputNameClient" class="form-label"> Nome Completo </label>
                                <input type="text" class="form-control" id="inputNameClient" name="cli_nome" <?php
                                                                                                                if (!empty($_SESSION['cli_nome'])) {
                                                                                                                    echo "value='" . $_SESSION['cli_nome'] . "'";
                                                                                                                    unset($_SESSION['cli_nome']);
                                                                                                                }
                                                                                                                ?>>
                            </div>
                            <div class="col-4">
                                <label for="inputCpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="inputCpf" minlength="14" maxlength="14" name="cli_cpf" <?php
                                                                                                        if (!empty($_SESSION['cli_cpf'])) {
                                                                                                            echo "value='" . $_SESSION['cli_cpf'] . "'";
                                                                                                            unset($_SESSION['cli_cpf']);
                                                                                                        }
                                                                                                        ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="inputPhone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="inputPhone" maxlength="15" name="cli_telefone" <?php
                                                                                                                            if (!empty($_SESSION['cli_telefone'])) {
                                                                                                                                echo "value='" . $_SESSION['cli_telefone'] . "'";
                                                                                                                                unset($_SESSION['cli_telefone']);
                                                                                                                            }
                                                                                                                            ?>>

                            </div>
                            <div class="col-md-8">
                                <label for="inputAddressClient" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="inputAddressClient" name="cli_endereco" <?php
                                                                                                                    if (!empty($_SESSION['cli_endereco'])) {
                                                                                                                        echo "value='" . $_SESSION['cli_endereco'] . "'";
                                                                                                                        unset($_SESSION['cli_endereco']);
                                                                                                                    }
                                                                                                                    ?>>
                            </div>
                            <div class="col-8">

                                <label for="inputEmailAddressClient" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmailAddressClient" name="cli_email" <?php
                                                                                                                        if (!empty($_SESSION['cli_email'])) {
                                                                                                                            echo "value='" . $_SESSION['cli_email'] . "'";
                                                                                                                            unset($_SESSION['cli_email']);
                                                                                                                        }
                                                                                                                        ?>>


                            </div>

                            <div class="col-4">
                                <label for="inputPass" class="form-label">Senha
                                    <a href="#" data-bs-toggle="tooltip" data-bs-title="Digite uma senha que tenha no minímo 4 e no máximo 6 caracteres"><i class="fa-solid fa-circle-question"></i></a>
                                </label>
                                <input type="password" class="form-control" maxlength="8" minlength="4" id="inputPass" name="cli_senha">
                            </div>
                            <div class="col-4">
                                <button type="reset" class="btn btn-warning">
                                    <i class="fa-solid fa-eraser"></i>
                                    Limpar
                                </button>
                                <button type="submit" name="send_register_client" class="btn btn-primary" value="send_register_client">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Registrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {


            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

            $("#inputCpf").mask("000.000.000-00");
            $("#inputPhone").mask("(00) 00000-0000");


            $("#myToast").toast({
                delay: 3000
            });
            $("#myToast").toast("show");
            $("#myToastMessage").toast({
                delay: 5000
            });
            $("#myToastMessage").toast("show");
        });
    </script>

</body>

</html>