<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Fiado do jeito certo 2</title>
        <link rel="stylesheet" type="text/css" href="<?= $_SERVER["BASE_URL"] ?>css/main.css">
    </head>

    <body>
        <header id="main-header">
            <div class="content-wrapper">
                <div class="header-box">
                    <div class="logo-box">
                        <a href="<?= $_SERVER["BASE_URL"] ?>">
                            <img src="<?= $_SERVER["BASE_URL"] ?>img/fiado-logo.png" alt="" class="logo">
                        </a>
                        <a href="<?= $_SERVER["BASE_URL"] ?>">
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
                    <form method="POST" action="<?= $_SERVER["BASE_URL"] ?>cliente">
                        <label for="ipt_email">Email:</label>
                        <input type="email" name="ipt_email" id="ipt_email" />

                        <label for="ipt_senha">Senha:</label>
                        <input type="password" name="ipt_senha" id="ipt_senha" />

                        <input type="submit" value="Entrar" class="btn-enviar" />
                        <input type="submit" value="Entrar Empresa" class="btn-enviar"
                            formaction="<?= $_SERVER["BASE_URL"] ?>loja" />
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