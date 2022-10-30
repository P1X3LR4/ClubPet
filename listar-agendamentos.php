<?php

session_start();

require './access/access-login.php';
require 'db-conn.php';

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Agendamentos</title>
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

        if (isset($_SESSION['mensage_access_admin'])) {
            echo $_SESSION['mensage_access_admin'];
            unset($_SESSION['mensage_access_admin']);
        }
        ?>

        <div class="row text-dark">
            <div class="col-md-12">
                <div class="card border-warning">
                    <div class="card-header text-bg-warning">
                        <h4>Lista de Agendamentos
                            <a href="registrar-agendamento.php" class="btn btn-primary float-end"><i class="fa-solid fa-calendar-plus me-1"></i> Novo
                                Agendamento
                            </a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table id="listar-usuario" class="table table-striped table-hover display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto</th>
                                    <th>Nome do Pet</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_SESSION['cli_logged_id'])) {
                                    $id_cliente   = mysqli_real_escape_string($conn, $_SESSION['cli_logged_id']);
                                    $query = " SELECT * FROM `clubpet`.`agendamentos` WHERE agen_cli_id = '$id_cliente'";
                                } else {
                                    $query = " SELECT * FROM `clubpet`.`agendamentos`";
                                }
                                $query_run = mysqli_query($conn, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $agenda) {
                                ?>
                                        <tr>
                                            <td><?= $agenda['agen_id']; ?></td>
                                            <td><img class="rounded-circle" src="<?= $agenda['agen_upload_path']; ?>" alt="broken" width="60px" height="60"></td>
                                            <td><?= $agenda['agen_nome_pet']; ?></td>
                                            <td><?= $agenda['agen_data']; ?></td>
                                            <td><?= $agenda['agen_horario']; ?></td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showModal<?= $agenda['agen_id']; ?>"><i class="fa-solid fa-eye"></i></button>

                                                <?php if (isset($_SESSION['cli_logged_id'])) : ?>
                                                    <form action="editar-agendamento.php" method="POST" class="d-inline">
                                                        <button type="submit" name="edit-agenda" value="<?= $agenda['agen_id']; ?>" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></button>
                                                    </form>
                                                <?php endif ?>

                                                <a data-confirm="<?= $agenda['agen_id']; ?>" class="btn btn-xs btn-<?= (isset($_SESSION['func_logged_id'])) ? 'success' : 'danger'; ?> btn-sm"><?= (isset($_SESSION['func_logged_id'])) ? '<i class="fa-solid fa-check"></i>' : '<i class="fas fa-trash-alt"></i>'; ?></a>
                                            </td>
                                        </tr>

                                        <!-- MODALS -->
                                        <div class="modal fade" id="showModal<?= $agenda['agen_id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header text-bg-warning">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel"> DETALHES DO
                                                            REGISTRO <?= $agenda['agen_id']; ?> </h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <img class="rounded-2 mx-auto d-block mb-2" src="<?= $agenda['agen_upload_path']; ?>" alt="broken" width="100">
                                                        <div class="row row-cols-2">

                                                            <div class="col text-end"><strong>Nome do Pet:</strong></div>
                                                            <div class="col"><?= $agenda['agen_nome_pet']; ?></div>

                                                            <div class="col text-end"><strong>Data agendada:</strong></div>
                                                            <div class="col"><?= $agenda['agen_data']; ?></div>

                                                            <div class="col text-end"><strong>Horário agendado</strong></div>
                                                            <div class="col"><?= $agenda['agen_horario']; ?></div>

                                                            <div class="col text-end"><strong>Espécie/Raça</strong></div>
                                                            <div class="col"><?= $agenda['agen_raca']; ?></div>

                                                            <div class="col text-end"><strong>Sexo</strong></div>
                                                            <div class="col"><?= $agenda['agen_sexo']; ?></div>

                                                            <div class="col text-end"><strong>Serviço(s) contratado(s):</strong></div>
                                                            <div class="col"><?= $agenda['agen_servico']; ?></div>

                                                            <div class="col text-end"><strong>Forma de Pagamento </strong></div>
                                                            <div class="col"><?= $agenda['agen_pagamento']; ?></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                            <button type="submit" name="delete_agenda" id="confirmDelete" class="btn btn-danger btn-sm">Deletar</button>
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

            $('#listar-usuario').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
                },
            });

            $('input[type="search"]').on('change keyup', function() {
                $('#listar-usuario').DataTable().column(2).search($(this).val()).draw();
            });

            $('a[data-confirm]').click(function() {
                var id = $(this).attr('data-confirm');
                // if (!$('#showModal').length) {
                //     $('body').append(
                //         '<div class="modal fade text-dark" id="showModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header bg-danger"> <h1 class="modal-title fs-5" id="exampleModalLabel">EXCLUIR REGISTRO </h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button> </div> <div class="modal-body"> Tem certeza de que deseja excluir o item selecionado? </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Não </button> <a id="confirmDelete" class="btn btn-danger">Excluir</a> </div> </div> </div> </div>'
                //     );
                // }
            
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