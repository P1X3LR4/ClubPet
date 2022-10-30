<?php

session_start();

require 'access/access-func.php';
require 'db-conn.php';

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Funcionários</title>
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
</head>

<body class="text-bg-dark">

    <!-- INCLUDE MENU -->
    <?php require './layout/menu.php'; ?>

    <div class="container mt-4">

        <?php
        require 'mensage.php';
        unset($_SESSION['mensage']);

        $key = (isset($key)) ? $key : '';
        unset($_SESSION["$key"]);
        ?>

        <div class="row text-dark">
            <div class="col-14">
                <div class="card border-warning">
                    <div class="card-header text-bg-warning">
                        <h4>Listagem de Funcionários Cadastrados
                            <a href="registrar-funcionario.php" class="btn btn-primary float-end"><i class="fa-solid fa-calendar-plus me-1"></i>
                                Novo Funcionário
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table id="listar-func" class="table table-striped table-hover display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>Email</th>
                                    <th>CPF</th>
                                    <th>Cargo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $func_id   = mysqli_real_escape_string($conn, $_SESSION['func_logged_id']);
                                $query = " SELECT * FROM `clubpet`.`funcionarios` WHERE func_id != '$func_id'";
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $func) {
                                ?>
                                        <tr>
                                            <td><?= $func['func_id']; ?></td>
                                            <td><?= $func['func_nome']; ?></td>
                                            <td><?= $func['func_tel']; ?></td>
                                            <td><?= $func['func_email']; ?></td>
                                            <td><?= $func['func_cpf']; ?></td>
                                            <td><?= $func['func_cargo']; ?></td>
                                            <td>
                                                <form action="editar-funcionario.php" method="POST" class="d-inline">
                                                    <button type="submit" name="edit_func" value="<?= $func['func_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></button>
                                                </form>

                                                <a data-confirm="<?= $func['func_id']; ?>" class="btn btn-xs btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                        <div class="modal fade text-dark" id="showModalDelete" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header text-bg-danger">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">EXCLUIR REGISTRO </h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body"> Tem certeza de que deseja excluir o item selecionado? </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"> Não </button>
                                        <form id="formID" action="data-control.php" method="POST" class="d-inline">
                                            <button type="submit" name="delete_funcionario" id="confirmDelete" class="btn btn-danger btn-sm">Deletar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a9022c837e.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

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
            $("#myToastMessageAccess").toast({
                delay: 5000
            });
            $("#myToastMessageAccess").toast("show");

            $('#listar-func').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
                },
            });

            $('input[type="search"]').on('change keyup', function() {
                $('#listar-func').DataTable().column(4).search($(this).val()).draw();
            });

            $('a[data-confirm]').click(function() {
                var id = $(this).attr('data-confirm');

                $('#confirmDelete').attr('value', id);

                $("#showModalDelete").modal('show');

                $("#formID").submit(function() {
                    return true;
                });
            });
        });
    </script>

</body>

</html>