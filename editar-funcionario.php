<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a9022c837e.js" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>

<body>

    <!-- INCLUDE MENU -->
    <?php require './layout/menu.php'; ?>

    <div class="container mt-5">

        <?php require './mensage.php'; ?>


        <?php

        if (isset($_SESSION['vazio_mensagem'])) {
            echo $_SESSION['vazio_mensagem'];
            unset($_SESSION['vazio_mensagem']);
        }

        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <?php
                    if (isset($_POST['edit_func']) || isset($_SESSION['editar_funcionario'])) :

                        require 'db-conn.php';

                        $id = mysqli_real_escape_string($conn, (isset($_POST['edit_func'])) ? $_POST['edit_func'] : $_SESSION['editar_funcionario']);
                        $query = " SELECT * FROM  `clubpet`.`funcionarios` WHERE func_id =' $id'";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) :
                            $func = mysqli_fetch_array($query_run);
                    ?>

                            <div class="card-header text-bg-warning">
                                <h4>Alterar Funcionário de id <?= $func['func_id']; ?>
                                    <a href="listar-funcionarios.php" class="btn btn-primary float-end"><i class="fa-solid fa-caret-left"></i> Voltar</a>
                                </h4>
                            </div>

                            <div class="card-body text-bg-dark">
                                <form class="row g-3 justify-content-evenly" action="data-control.php" method="POST">
                                    <div class="col-8">
                                        <label for="inputNameClient" class="form-label"> Nome do Funcionário </label>
                                        <input type="text" class="form-control" id="inputNameClient" name="func_nome" value="<?= $func['func_nome']; ?>">
                                    </div>

                                    <div class="col-4">
                                        <label for="inputCpf" class="form-label">CPF</label>
                                        <input type="text" class="form-control" minlength="14" maxlength="14" id="inputCpf" name="func_cpf" value="<?= $func['func_cpf']; ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="inputPhone" class="form-label">Telefone</label>
                                        <input type="tel" class="form-control" id="inputPhone" maxlength="15" name="func_telefone" value="<?= $func['func_tel']; ?>">

                                    </div>

                                    <div class="col-6">

                                        <label for="inputEmailAddressClient" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputEmailAddressClient" name="func_email" value="<?= $func['func_email']; ?>">

                                    </div>

                                    <div class="col-3">
                                        <label for="inputState" class="form-label">Cargo</label>
                                        <select id="inputState" class="form-select" name="func_cargo">
                                            <option value=""></option>

                                            <?php

                                            $array_cargo = array(
                                                'Banhista',
                                                'Veterinário',
                                                'Adestrador',
                                                'Tosador',
                                                'Administrador'
                                            );

                                            foreach ($array_cargo as $key) :
                                            ?>

                                                <option value="<?= $key ?>" value="<?= $key ?>" <?= ($func['func_cargo'] == "$key") ? 'selected' : ''; ?>> <?= $key ?> </option>

                                            <?php endforeach; ?>

                                        </select>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" name="editar_funcionario" class="btn btn-success" value="<?= $func['func_id']; ?>">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Salvar Alterações
                                        </button>
                                    </div>
                                </form>
                            </div>
                    <?php
                        endif;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {

            $("#inputCpf").mask("000.000.000-00");
            $("#inputPhone").mask("(00) 00000-0000");

            $('#btnTroca').on('click', function() {

                $("#showModal").modal('hide');
                $("#click").click();

            });

            $("form").submit(function() {

                var inputData = document.getElementById('inputDate').value;

                if (inputData != '' || inputData != null) {
                    var data_atual = moment().format('yy-MM-DD');
                    if (moment(inputData).isBefore(data_atual)) {
                        $("#myToastMessageInput").toast({
                            delay: 10000
                        });
                        $("#myToastMessageInput").toast("show");
                        return false;
                    } else
                        return true;
                } else
                    return true;

            });


            $("#myToast").toast({
                delay: 3000
            });
            $("#myToast").toast("show");
            $("#myToastMessage").toast({
                delay: 10000
            });
            $("#myToastMessage").toast("show");
        });
    </script>

</body>

</html>