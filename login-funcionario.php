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
    <title>Login Funcionário</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a9022c837e.js" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>

<body class="text-bg-dark">

    <!-- INCLUDE MENU -->
    <?php require './layout/menu.php'; ?>

    <div class="container mt-5">
    <?php require 'mensage.php'; ?>

        <?php
        if (isset($_SESSION['vazio_mensagem'])) {
            echo $_SESSION['vazio_mensagem'];
            unset($_SESSION['vazio_mensagem']);
        }
        if (isset($_SESSION['mensage_access_login_fun'])) {
            echo $_SESSION['mensage_access_login_fun'];
            unset($_SESSION['mensage_access_login_fun']);
        }
        ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-warning text-bg-dark">
                    <div class="card-header text-bg-warning">
                        <h4 class="text-center "><i class="fa-solid fa-user"></i> Login Funcionário </h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 flex-column align-items-center" action="data-control.php" method="POST">
                            <div class="col-md-6">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" maxlength="14" name="func_login_cpf" <?php
                                                                                                                    if (!empty($_SESSION['func_login_cpf'])) {
                                                                                                                        echo "value='" . $_SESSION['func_login_cpf'] . "'";
                                                                                                                        unset($_SESSION['func_login_cpf']);
                                                                                                                    }
                                                                                                                    ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Senha</label>

                                <div class="input-group mb-3" id="show_hide_password">
                                    <input type="password" class="form-control" maxlength="12" aria-describedby="button-addon2" id="inputPassword" name="func_login_senha">
                                    <button class="btn btn-outline-warning" type="button" id="button-addon2"><i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="login_funcionario" class="btn btn-success" value="sub">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                    Entrar
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

            $('#cpf').mask('000.000.000-00');

            $("#myToast").toast({
                delay: 3000
            });
            $("#myToast").toast("show");
            $("#myToastMessage").toast({
                delay: 5000
            });
            $("#myToastMessage").toast("show");

            $("#myToastMessageAcess").toast({
                delay: 8000
            });
            $("#myToastMessageAcess").toast("show");


            $("#show_hide_password button").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').removeClass("fa-solid fa-eye");
                    $('#show_hide_password i').addClass("fa-solid fa-eye-slash");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-solid fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-solid fa-eye");
                }
            });

        });
    </script>

</body>

</html>