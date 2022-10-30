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
    <title>Registrar Agendamento</title>
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
            <div class="col-md-8 mb-5">
                <div class="card border border-3 border-warning">
                    <div class="card-header text-bg-warning">
                        <h4>Cria Novo Agendamento </h4>
                    </div>
                    <div class="card-body text-bg-dark">
                        <form class="row g-3 justify-content-evenly" enctype="multipart/form-data" action="data-control.php" method="POST">

                            <div class="col-6">
                                <label for="inputNamePet" class="form-label">Nome do Pet </label>
                                <input type="text" class="form-control" id="inputNamePet" name="agen_nome_pet" <?php
                                                                                                                if (!empty($_SESSION['agen_nome_pet'])) {
                                                                                                                    echo "value='" . $_SESSION['agen_nome_pet'] . "'";
                                                                                                                    unset($_SESSION['agen_nome_pet']);
                                                                                                                }
                                                                                                                ?>>
                            </div>
                            <div class="col-6">
                                <label for="inputImage" class="form-label">Imagem do Pet</label> <span class="ms-2"><small>5MB (*jpg, *jpeg, *png)</small></span>
                                <input type="file" class="form-control" id="inputImage" accept=".png, .jpg, .jpeg" name="agen_image" <?php
                                                                                                                                        if (!empty($_SESSION['agen_image'])) {
                                                                                                                                            echo "value='" . $_SESSION['agen_image'] . "'";
                                                                                                                                            unset($_SESSION['agen_image']);
                                                                                                                                        }
                                                                                                                                        ?>>
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
                                        <option value="<?= $key ?>" <?php if (isset($_SESSION['agen_raca']) && $_SESSION['agen_raca'] == "$key") {
                                                                        echo "selected";
                                                                    } ?>> <?= $key ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php unset($_SESSION['agen_raca']); ?>
                            </div>
                            <div class="col-6">
                                <label for="inputSexo" class="form-label">Sexo </label>
                                <select id="inputSexo" class="form-select" name="agen_sexo">
                                    <option value=""></option>
                                    <option value="Fêmea" <?php if (isset($_SESSION['agen_sexo']) && $_SESSION['agen_sexo'] == 'Fêmea') {
                                                                echo "selected";
                                                            } ?>> Fêmea </option>

                                    <option value="Macho" <?php if (isset($_SESSION['agen_sexo']) && $_SESSION['agen_sexo'] == 'Macho') {
                                                                echo "selected";
                                                            } ?>> Macho </option>
                                </select>

                                <?php unset($_SESSION['agen_sexo']); ?>
                            </div>

                            <div class="col-12">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <label class="form-label">Selecione os Serviços</label>
                                    </div>
                                    <?php foreach ($dados_checkbox as $dado) : ?>
                                        <div class="col-6">
                                            <input class="form-check-input" type="checkbox" name="agen_servico[]" value="<?= $dado ?>" <?= (isset($_SESSION['agen_servico'])) ? ((in_array($dado, $agenda_checkbox_formate)) ? "checked" : '') : ''; ?>>
                                            <label class="form-check-label">
                                                <?= $dado ?>
                                            </label>
                                        </div>
                                    <?php endforeach;
                                    unset($_SESSION['agen_servico']); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="inputState" class="form-label">Forma de Pagamento</label>
                                <select id="inputState" class="form-select" name="agen_pagamento">
                                    <option value=""></option>
                                    <option value="Cartão de Crédito" <?php if (isset($_SESSION['agen_pagamento']) && $_SESSION['agen_pagamento'] == 'Cartão de Crédito') {
                                                                            echo "selected";
                                                                        } ?>> Cartão de Crédito </option>

                                    <option value="Cartão de Débito" <?php if (isset($_SESSION['agen_pagamento']) && $_SESSION['agen_pagamento'] == 'Cartão de Débito') {
                                                                            echo "selected";
                                                                        } ?>> Cartão de Débito </option>

                                    <option value="Pix" <?php if (isset($_SESSION['agen_pagamento']) && $_SESSION['agen_pagamento'] == 'Pix') {
                                                            echo "selected";
                                                        } ?>> Pix </option>

                                    <option value="Dinheiro" <?php if (isset($_SESSION['agen_pagamento']) && $_SESSION['agen_pagamento'] == 'Dinheiro') {
                                                                    echo "selected";
                                                                } ?>> Dinheiro </option>
                                </select>

                                <?php unset($_SESSION['agen_pagamento']); ?>
                            </div>

                            <div class="col-4">
                                <label for="inputHor" class="form-label">Horário</label>
                                <input type="time" class="form-control" id="inputHor" name="agen_horario" <?php
                                                                                                            if (!empty($_SESSION['agen_horario'])) {
                                                                                                                echo "value='" . $_SESSION['agen_horario'] . "'";
                                                                                                                unset($_SESSION['agen_horario']);
                                                                                                            }
                                                                                                            ?>>
                            </div>
                            <div class="col-4">
                                <label for="inputDate" class="form-label">Data</label>
                                <input type="date" class="form-control" id="inputDate" name="agen_data" value='<?php
                                                                                                                if (!empty($_SESSION['agen_data'])) {
                                                                                                                    echo  $_SESSION['agen_data'];
                                                                                                                    unset($_SESSION['agen_data']);
                                                                                                                }
                                                                                                                ?>'>
                            </div>
                            <div class="col-auto">
                                <button type="reset" class="btn btn-warning">
                                    <i class="fa-solid fa-eraser"></i>
                                    Limpar
                                </button>
                                <button type="submit" name="salvar_agendamento" id="subm" class="btn btn-success" value="salvar_agendamento">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script>
        $(document).ready(function() {

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