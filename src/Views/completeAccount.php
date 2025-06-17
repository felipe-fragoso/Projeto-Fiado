<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Fiado do jeito certo</title>
        <link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/main.css">
        <script src="<?=$_SERVER["BASE_URL"]?>js/main.js"></script>
    </head>

    <body>
        <header id="main-header">
            <div class="content-wrapper">
                <div class="header-box">
                    <div class="logo-box">
                        <a href="<?=$_SERVER["BASE_URL"]?>">
                            <img src="<?=$_SERVER["BASE_URL"]?>img/fiado-logo.png" alt="" class="logo">
                        </a>
                        <a href="<?=$_SERVER["BASE_URL"]?>">
                            <h3>
                                FiadoFacil
                            </h3>
                            <span>Fiado do jeito certo</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="main-box content-wrapper">
            <main class="main-content">
                <div id="login-signup-box" class="form-box">
                    <?php if ($data->tokenInvalido): ?>
                    <header>
                        <h1 class="login-signup-title">Link inválido</h1>
                    </header>
                    <div class="text-center">
                        <p>Parece que seu link não é mais válido.</p>
                        <?php if (!$data->tokenUsed): ?>
                        <p>Clique abaixo para solicitar um novo.</p>
                        <form method="POST" action="<?=$_SERVER['BASE_URL']?>cadastro/reenviar">
                            <input type="hidden" name="hidden-email-token" value="<?=$data->tokenEmail?>" />
                            <input type="hidden" name="hidden-token" value="<?=$token?>" />
                            <input type="submit" value="Reenviar email" class="btn-enviar" />
                        </form>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <header>
                        <h1 class="login-signup-title">Completar Cadastro</h1>
                    </header>
                    <div class="selecao-form-box">
                        <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
                        <div>
                            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>cadastro/completa">
                                <label for="ipt-senha">Senha:</label>
                                <input type="password" name="ipt-senha" id="ipt-senha" />

                                <label for="ipt-con-senha">Confirmar Senha:</label>
                                <input type="password" name="ipt-con-senha" id="ipt-con-senha" />

                                <input type="hidden" name="hidden-email-token" value="<?=$data->tokenEmail?>" />
                                <input type="hidden" name="hidden-token" value="<?=$token?>" />
                                <input type="submit" value="Cadastrar" class="btn-enviar" />
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
        <footer id="footer-box">
            <div class="content-wrapper">
                <div class="footer-notes">
                    <p>All Right Reserved</p>
                    <p>Trademark - 2024</p>
                </div>
            </div>
        </footer>
    </body>
</html>