<header class="p-3 text-bg-dark border-bottom border-warning">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <a href="http://localhost/ClubPet/index.php" class="d-flex align-items-center me-lg-4 mb-2 mb-lg-0 text-white text-decoration-none border border-warning p-2 rounded rounded-3">
                <img src="http://localhost/ClubPet/image/logo v2.svg" alt="Club Pet" width="30" height="30">
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="http://localhost/ClubPet/index.php" class="nav-link px-2 text-warning">Página Inicial</a></li>
                <li><a href="http://localhost/ClubPet/index.php#servicos" class="nav-link px-2 text-warning">Serviços</a></li>
                <li><a href="http://localhost/ClubPet/index.php#sobre" class="nav-link px-2 text-warning">Sobre</a></li>
                <li><a href="http://localhost/ClubPet/index.php#valores" class="nav-link px-2 text-warning">Valores da Empresa</a></li>
            </ul>
            <div class="text-end">

                <?php if (!isset($_SESSION['cli_logged_id']) && !isset($_SESSION['func_logged_id'])) : ?>

                    <a href="http://localhost/ClubPet/registrar-cliente.php" class="btn btn-sm btn-warning">Resgistrar-se</a>
                    <a href="http://localhost/ClubPet/login-cliente.php" class="btn btn-sm btn-outline-light me-2">Login</a>
                    <a href="http://localhost/ClubPet/login-funcionario.php" class="btn btn-sm btn-outline-warning">Colaborador</a>

                <?php endif ?>
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <?php if (isset($_SESSION['cli_logged_id']) || isset($_SESSION['func_logged_id'])) : ?>
                        <button type="button" class="btn btn-sm btn-warning fw-bold"><?= (isset($_SESSION['cli_logged_id'])) ? $_SESSION['cli_logged_nome'] : $_SESSION['func_logged_nome'] . ' <i class="fa-solid fa-hammer"></i>' ?> </button>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="http://localhost/ClubPet/registrar-agendamento.php"><i class="fa-regular fa-calendar-plus"></i> Criar Novo Agendamento</a></li>
                                <li><a class="dropdown-item" href="http://localhost/ClubPet/listar-agendamentos.php"><i class="fa-solid fa-list"></i> Listar Agendamentos </a></li>
                                <?php if (isset($_SESSION['func_logged_id']) && $_SESSION['func_logged_cargo'] == 'Administrador') : ?>
                                    <li><a class="dropdown-item" href="http://localhost/ClubPet/listar-funcionarios.php"><i class="fa-solid fa-address-book"></i> Listar Funcionário </a></li>
                                    <li><a class="dropdown-item" href="http://localhost/ClubPet/registrar-funcionario.php"><i class="fa-solid fa-user-plus"></i> Cadastrar Novo Funcionário</a></li>
                                <?php endif ?>
                                <li><a class="dropdown-item fw-bold text-danger" href="http://localhost/ClubPet/des.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair </a></li>
                            </ul>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>