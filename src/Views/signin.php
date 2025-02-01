<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Fiado do jeito certo 2</title>
        <link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/main.css">
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
        <div class="main-box">
            <main class="main-content">
                <div id="login-signup-box" class="form-box">
                    <header>
                        <h1 class="login-signup-title">Entrar</h1>
                    </header>
                    <?php $this->loadComponent('flashBar', ['message' => $flash?->message, 'error' => $flash?->error])?>
                    <form method="POST" action="<?=$_SERVER["BASE_URL"]?>auth/entrar">
                        <label for="ipt-email">Email:</label>
                        <input type="email" name="ipt-email" id="ipt-email"
                            value="<?=$flash?->form?->{'ipt-email'}?>" />

                        <label for="ipt-senha">Senha:</label>
                        <input type="password" name="ipt-senha" id="ipt-senha" />

                        <input type="submit" value="Entrar" class="btn-enviar" />
                    </form>
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