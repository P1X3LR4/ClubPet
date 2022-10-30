<?php

session_start();

require 'access/access-func.php';

if (isset($_SESSION['reset'])) {
    resetDadosSessions($_SESSION['reset'], $_SESSION['reset']);
    unset($_SESSION['reset']);
}

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
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
        <?php
        if (isset($_SESSION['vazio_mensagem'])) {
            echo $_SESSION['vazio_mensagem'];
            unset($_SESSION['vazio_mensagem']);
        }

        require 'mensage.php';
        unset($_SESSION['mensage'])

        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border border-3 border-warning">
                    <div class="card-header text-bg-warning">
                        <h4><i class="fa-solid fa-user-plus me-3"></i>  Cadastrar Funcionário</h4>
                    </div>
                    <div class="card-body text-bg-dark">
                        <form class="row g-3 justify-content-evenly" action="data-control.php" method="POST">
                            <div class="col-12">
                                <label for="inputNameClient" class="form-label"> Nome do Funcionário </label>
                                <input type="text" class="form-control" id="inputNameClient" name="func_nome" <?php
                                                                                                                if (!empty($_SESSION['func_nome'])) {
                                                                                                                    echo "value='" . $_SESSION['func_nome'] . "'";
                                                                                                                    unset($_SESSION['func_nome']);
                                                                                                                }
                                                                                                                ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="inputPhone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="inputPhone" maxlength="15" name="func_telefone" <?php
                                                                                                            if (!empty($_SESSION['func_telefone'])) {
                                                                                                                echo "value='" . $_SESSION['func_telefone'] . "'";
                                                                                                                unset($_SESSION['func_telefone']);
                                                                                                            }
                                                                                                            ?>>

                            </div>

                            <div class="col-md-8">

                                <label for="inputEmailAddressClient" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmailAddressClient" name="func_email" <?php
                                                                                                                        if (!empty($_SESSION['func_email'])) {
                                                                                                                            echo "value='" . $_SESSION['func_email'] . "'";
                                                                                                                            unset($_SESSION['func_email']);
                                                                                                                        }
                                                                                                                        ?>>


                            </div>

                            <div class="col-md-4">
                                <label for="inputCpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" minlength="14" maxlength="14" id="inputCpf" name="func_cpf" <?php
                                                                                                        if (!empty($_SESSION['func_cpf'])) {
                                                                                                            echo "value='" . $_SESSION['func_cpf'] . "'";
                                                                                                            unset($_SESSION['func_cpf']);
                                                                                                        }
                                                                                                        ?>>
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label">Cargo</label>
                                <select id="inputState" class="form-select" name="func_cargo">
                                    <option value=""></option>
                                    <option value="Banhista" <?php if (isset($_SESSION['func_cargo']) && $_SESSION['func_cargo'] == 'Banhista') {
                                                                    echo "selected";
                                                                } ?>> Banhista </option>

                                    <option value="Veterinário" <?php if (isset($_SESSION['func_cargo']) && $_SESSION['func_cargo'] == 'Veterinário') {
                                                                    echo "selected";
                                                                } ?>> Veterinário </option>

                                    <option value="Adestrador" <?php if (isset($_SESSION['func_cargo']) && $_SESSION['func_cargo'] == 'Adestrador') {
                                                                    echo "selected";
                                                                } ?>> Adestrador </option>

                                    <option value="Tosador" <?php if (isset($_SESSION['func_cargo']) && $_SESSION['func_cargo'] == 'Tosador') {
                                                                echo "selected";
                                                            } ?>> Tosador </option>
                                    <option value="Administrador" <?php if (isset($_SESSION['func_cargo']) && $_SESSION['func_cargo'] == 'Administrador') {
                                                                        echo "selected";
                                                                    } ?>> Administrador </option>
                                </select>

                                <?php unset($_SESSION['func_cargo']); ?>
                            </div>
                            <div class="col-md-4">
                                <label for="inputPass" class="form-label">Senha</label>
                                <div class="input-group mb-3" id="show_hide_password">

                                    <input type="password" class="form-control" aria-describedby="button-addon2" id="inputPass" name="func_senha" readonly>

                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" name="pass"><i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>


                            <div class="col-6">
                                <button type="reset" class="btn btn-warning">
                                    <i class="fa-solid fa-eraser"></i>
                                    Limpar
                                </button>
                                <button type="submit" name="send_register_func" class="btn btn-success" value="send_register_func">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Cadastrar Funcionário
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

            var chars = "0123456789";
            var passwordLength = 4;
            var password = "";

            for (var i = 0; i < passwordLength; i++) {
                var randomNumber = Math.floor(Math.random() * chars.length);
                password += chars.substring(randomNumber, randomNumber + 1);
            }

            $("#inputPass").attr('value', 'clubpet.' + password);
        });
    </script>

</body>

</html>