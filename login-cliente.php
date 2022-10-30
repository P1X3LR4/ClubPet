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
    <title>Login</title>
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
        if (isset($_SESSION['mensage_access'])) {
            echo $_SESSION['mensage_access'];
            unset($_SESSION['mensage_access']);
        }
        ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-warning text-bg-dark">
                    <div class="card-header text-bg-warning">

                        <h4> Login Cliente
                            <a href="http://localhost/ClubPet/registrar-cliente.php" class="btn btn-outline-dark me-2 float-end btn-sm"> Registrar-se </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 flex-column align-items-center" action="data-control.php" method="POST">
                            <div class="col-md-6">
                                <label for="inputNameClient" class="form-label">Email</label>
                                <input type="text" class="form-control" id="inputNameClient" name="cli_login_email" <?php
                                                                                                                    if (!empty($_SESSION['cli_login_email'])) {
                                                                                                                        echo "value='" . $_SESSION['cli_login_email'] . "'";
                                                                                                                        unset($_SESSION['cli_login_email']);
                                                                                                                    }
                                                                                                                    ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Senha</label>

                                <div class="input-group mb-3" id="show_hide_password">
                                    <input type="password" class="form-control" aria-describedby="button-addon2" id="inputPassword" name="cli_login_senha">
                                    <button class="btn btn-outline-warning" type="button" id="button-addon2"><i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="login_cliente" class="btn btn-success" value="sub">
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

    <script src="https://cdnjs.com/libraries/jquery.mask"></script>
    <script>
        $(document).ready(function() {

            $("#myToast").toast({
                delay: 3000
            });
            $("#myToast").toast("show");

            $("#myToastMessage").toast({
                delay: 5000
            });
            $("#myToastMessage").toast("show");

            $("#myToastMessageAcess").toast({
                delay: 20000
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