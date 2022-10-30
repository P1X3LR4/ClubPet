<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">

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

<body>

    <?php require './layout/menu.php'; ?>

    <?php 
    
    if (isset($_SESSION['mensage_access_login_fun'])) {
        echo $_SESSION['mensage_access_login_fun'];
        unset($_SESSION['mensage_access_login_fun']);
    } 
    
    ?>

    <div class="container mt-5 ">

        <div class="py-5 text-center d-flex flex-column">
            <div class="container my-auto">
                <div class="row">
                    <div class="mx-auto col-lg-6 col-md-8">
                        <img src="http://localhost/ClubPet/image/logo.svg" alt="Club Pet" width="200">
                        <h3 class="mb-4 text-warning bg-dark p-2"><b>PetSohp de Serviços</b></h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="container my-auto text-bg-warning" id="sobre">
            <div class="">
                <div class="position-relative p-3 text-center">
                    <h3 class="display-3 text-orange"> QUEM SOMOS ?<br></h3>
                    <p class="lead">
                        Somos uma empresa global que cuida de seu animal de estimação da melhor forma possivel. Nosso time é composto por talentos de diversas culturas, habilidades e experiências. Buscamos oferecer a melhor experiência possível aos nossos clientes e aos animais
                    </p>
                </div>
            </div>
        </div>

        <section class="py-3 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-bold pb-2 border-bottom border-2 border-dark text-center">Variedade de Serviços</h1>
                    <p class="lead text-muted">Temos uma equipe altamente qualificada e apaixonada por pets pronta para proporcionar o melhor de nossos serviços.</p>
                </div>
            </div>
        </section>

        <div class="album pb-5" id="servicos">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-header text-center text-bg-dark">
                                <h4>Dog Walker/Passeador</h4>
                            </div>

                            <img class="card-img-top" src="http://localhost/ClubPet/image/img02.png" alt="">

                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header text-center text-bg-dark">
                                <h4>Banho e Tosa</h4>
                            </div>

                            <img class="card-img-top" src="http://localhost/ClubPet/image/banho-tosa.png" alt="">

                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-header text-center text-bg-dark">
                                <h4>Serviços Veterinários</h4>
                            </div>

                            <img class="card-img-top" src="http://localhost/ClubPet/image/img03.png" alt="">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5 px-4 py-4 text-bg-dark" id="valores">

            <h2 class="pb-2 border-bottom border-warning text-center">
                Valores da Empresa
            </h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-2 g-4 py-3">
                <?php
                $array = array(
                    'fa-shield-heart' => 'Amor e dedicação aos pets',
                    'fa-award' => 'Higiene e qualidade de serviços',
                    'fa-handshake-simple' => 'Comprometimento',
                    'fa-comments' => 'Atendimento personalizado',
                    'fa-shield-dog' => 'Competência na segurança',
                    'fa-thumbs-up' => 'Credibilidade '
                );
                foreach ($array as $icon => $value) :

                ?>
                    <div class="col d-flex align-items-start">
                        <div class="me-2 flex-shrink-0">
                            <i class="fa-solid <?= $icon ?> fa-xl text-warning mt-3"></i>
                        </div>
                        <div class="">
                            <h1 class="mb-0 fs-4"><?= $value ?></h1>
                        </div>
                    </div>
                <?php endforeach; ?>
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