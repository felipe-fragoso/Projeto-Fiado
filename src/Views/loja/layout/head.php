<header id="main-header">
    <div class="content-wrapper">
        <div class="header-box">
            <div class="logo-box">
                <a href="<?= $_SERVER["BASE_URL"] ?>dashboard">
                    <img src="<?= $_SERVER["BASE_URL"] ?>img/fiado-logo.png" alt="" class="logo">
                </a>
                <a href="<?= $_SERVER["BASE_URL"] ?>dashboard">
                    <h3>
                        FiadoFacil
                    </h3>
                    <span>Fiado do jeito certo</span>
                </a>
            </div>
            <div class="login-signup-box">
                <div class="perfil">
                    <span>E</span>
                    <div class="opcoes-perfil">
                        <a href="<?= $_SERVER["BASE_URL"] ?>perfil">Meu Perfil</a>
                        <a href="<?= $_SERVER["BASE_URL"] ?>perfil/editar">Editar Perfil</a>
                        <a href="<?= $_SERVER["BASE_URL"] ?>config">Configurações</a>
                    </div>
                </div>
                <a href="<?= $_SERVER["BASE_URL"] ?>auth/logout" class="btn-logout">Sair</a>
            </div>
        </div>
    </div>
</header>