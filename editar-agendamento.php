<?php

session_start();

require './access/access-login.php';

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
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
        <div class="toast align-items-center text-bg-warning border-0" role="alert" style="position: absolute; top: 90%; right: 20px; z-index: 10;" id="myToastMessageInput">
            <div class="d-flex">
                <div class="toast-body">
                    Coloque datas posteriores ao dia atual
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <?php


        $dados_checkbox = array(
            "Banho",
            "Tosa",
            "Tingimento dos pelos",
            "Escovação de dentes",
            "Corte de Unhas",
            "Fitoterápicos",
            "Acupuntura",
            "Dog Walker/Passeador"
        );

        if (isset($_SESSION['agen_servico'])) {

            $agenda_checkbox_formate_imp = implode(" - ", $_SESSION['agen_servico']);

            $agenda_checkbox_formate = explode(" - ", $agenda_checkbox_formate_imp);
        }


        if (isset($_SESSION['vazio_mensagem'])) {
            echo $_SESSION['vazio_mensagem'];
            unset($_SESSION['vazio_mensagem']);
        }

        if (isset($_SESSION['message_img'])) {
            echo $_SESSION['message_img'];
            unset($_SESSION['message_img']);
        }

        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <?php
                    if (isset($_POST['edit-agenda']) || isset($_SESSION['editar_agendamento'])) :

                        require 'db-conn.php';

                        $id = mysqli_real_escape_string($conn, (isset($_POST['edit-agenda'])) ? $_POST['edit-agenda'] : $_SESSION['editar_agendamento']);
                        $query = " SELECT * FROM  clubpet.Agendamentos WHERE agen_id =' $id'";
                        $query_run = mysqli_query($conn, $query);

                        $dados_checkbox = array(
                            "Banho",
                            "Tosa",
                            "Tingimento dos pelos",
                            "Escovação de dentes",
                            "Corte de Unhas",
                            "Fitoterápicos",
                            "Acupuntura",
                            "Dog Walker/Passeador"
                        );


                        if (mysqli_num_rows($query_run) > 0) :
                            $agenda = mysqli_fetch_array($query_run);
                            $agenda_checkbox_formate = explode(" - ", $agenda['agen_servico']);
                    ?>

                            <div class="card-header text-bg-warning">
                                <h4>Alterar Agendamento de id <?= $agenda['agen_id']; ?>
                                    <a href="listar-agendamentos.php" class="btn btn-primary float-end"><i class="fa-solid fa-caret-left"></i> Voltar</a>
                                </h4>
                            </div>
                            <div class="card-body text-bg-dark">
                                <form class="row g-3 justify-content-evenly" enctype="multipart/form-data" action="data-control.php" method="POST">

                                    <div class="col-3">
                                        <label for="inputNamePet" class="form-label">Nome do Pet </label>
                                        <input type="text" class="form-control" id="inputNamePet" name="agen_nome_pet" value="<?= $agenda['agen_nome_pet']; ?>">
                                    </div>
                                    <div class="col-6">
                                        <label for="inputImage" id="click" class="form-label">Imagem do Pet</label> <span class="ms-2"><small>5MB (*jpg, *jpeg, *png)</small></span>
                                        <input type="file" class="form-control" id="inputImage" accept=".png, .jpg, .jpeg" name="agen_image" <?php
                                                                                                                                                if (!empty($_SESSION['agen_image'])) {
                                                                                                                                                    echo "value='" . $_SESSION['agen_image'] . "'";
                                                                                                                                                    unset($_SESSION['agen_image']);
                                                                                                                                                }
                                                                                                                                                ?>>
                                    </div>
                                    <div class="col-3 text-center">
                                        <label for="ImageViwer" id="label" class="form-label"><span><small>Imagem já cadastrada</small></span></label>
                                        <a class="btn btn-info btn-sm" href="#modalviwer" data-confirm data-bs-toggle="modal" data-bs-target="#showModal">Visualizar</a>
                                    </div>

                                    <div class="col-6">
                                        <label for="inputRacaPet" class="form-label">Espécie/Raça</label>

                                        <select id="inputRacaPet" class="form-select" name="agen_raca">
                                            <option value=""></option>
                                            <?php

                                            $array_raca = array(
                                                'Cachorro/Pastor Alemão',
                                                'Cachorro/Pastor Australiano',
                                                'Cachorro/Husky',
                                                'Cachorro/Golden',
                                                'Cachorro/Chihuahua',
                                                'Cachorro/Boxer',
                                                'Cachorro/SRD',
                                                'Gato/Siamês',
                                                'Gato/Maine Coon',
                                                'Gato/Angorá',
                                                'Gato/Sphynx',
                                                'Gato/SRD',
                                            );

                                            foreach ($array_raca as $key) :
                                            ?>

                                                <option value="<?= $key ?>" value="<?= $key ?>" <?= ($agenda['agen_raca'] == "$key") ? 'selected' : ''; ?>> <?= $key ?> </option>

                                            <?php endforeach; ?>


                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputSexo" class="form-label">Sexo </label>
                                        <select id="inputSexo" class="form-select" name="agen_sexo">
                                            <option value=""></option>
                                            <option value="Fêmea" <?= ($agenda['agen_sexo'] == 'Fêmea') ? 'selected' : ''; ?>> Fêmea </option>

                                            <option value="Macho" <?= ($agenda['agen_sexo'] == 'Macho') ? 'selected' : ''; ?>> Macho </option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <label class="form-label">Selecione os Serviços</label>
                                            </div>
                                            <?php foreach ($dados_checkbox as $dado) : ?>
                                                <div class="col-6">
                                                    <input class="form-check-input" type="checkbox" name="agen_servico[]" value="<?= $dado ?>" <?= (in_array($dado, $agenda_checkbox_formate)) ? "checked" : '' ?>>
                                                    <label class="form-check-label">
                                                        <?= $dado ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputState" class="form-label">Forma de Pagamento</label>
                                        <select id="inputState" class="form-select" name="agen_pagamento">
                                            <option value=""></option>
                                            <option value="Cartão de Crédito" <?= ($agenda['agen_pagamento'] == 'Cartão de Crédito') ? 'selected' : ''; ?>> Cartão de Crédito </option>

                                            <option value="Cartão de Débito" <?= ($agenda['agen_pagamento'] == 'Cartão de Débito') ? 'selected' : ''; ?>> Cartão de Débito </option>

                                            <option value="Pix" <?= ($agenda['agen_pagamento'] == 'Pix') ? 'selected' : ''; ?>> Pix </option>

                                            <option value="Dinheiro" <?= ($agenda['agen_pagamento'] == 'Dinheiro') ? 'selected' : ''; ?>> Dinheiro </option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="inputHor" class="form-label">Horário</label>
                                        <input type="time" class="form-control" id="inputHor" name="agen_horario" value="<?= $agenda['agen_horario']; ?>">
                                    </div>
                                    <div class="col-4">
                                        <label for="inputDate" class="form-label">Data</label>
                                        <input type="date" class="form-control" id="inputDate" name="agen_data" value="<?= $agenda['agen_data']; ?>">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-success" name="editar_agendamento" value="<?= $agenda['agen_id']; ?>">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Salvar Alterações
                                        </button>
                                    </div>
                                </form>

                                <div class="modal fade text-dark" id="showModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-bg-warning">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel"> Imagem Cadastrada </h1> <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="<?= $agenda['agen_upload_path'] ?>" alt="erorr" width="460">
                                            </div>
                                            <div class="modal-footer justify-content-center text-bg-dark">
                                                <button type="button" id="btnTroca" class="btn btn-primary btn-sm text-center"><i class="fa-solid fa-rotate"></i> Trocar Imagem </button>
                                            </div>
                                        </div>
                                    </div>
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
    <script>
        $(document).ready(function() {

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