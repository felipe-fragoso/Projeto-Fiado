<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Fiado do jeito certo 2</title>
        <link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/main.css">
        <link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/selecao-um-dois.css">
        <script src="<?=$_SERVER["BASE_URL"]?>js/selecao-um-dois.js"></script>
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
                <div id="login-signup-box" class="selecao-um-dois form-box">
                    <header>
                        <h1 class="login-signup-title">Cadastrar</h1>
                    </header>
                    <div class="selecao-header-box">
                        <div class="selecao-header">
                            <label for="tipo-conta-cliente">Cliente</label>
                            <input type="radio" name="tipo-conta" value="form-um" id="tipo-conta-cliente"
                                class="selecao-radio" onchange="mudaSelecao(this)"
                                <?=($tipo == 'c') ? 'checked' : ''?> />
                        </div>
                        <div class="selecao-header">
                            <label for="tipo-conta-empresa">Empresa</label>
                            <input type="radio" name="tipo-conta" value="form-dois" id="tipo-conta-empresa"
                                class="selecao-radio" onchange="mudaSelecao(this)"
                                <?=($tipo == 'e') ? 'checked' : ''?> />
                        </div>
                    </div>
                    <div class="selecao-form-box">
                        <div class="selecao-form-um">
                            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>auth/salvar">
                                <label for="ipt-cpf">CPF:</label>
                                <input type="text" name="ipt-cpf" id="ipt-cpf" />

                                <label for="ipt-nome">Nome:</label>
                                <input type="text" name="ipt-nome" id="ipt-nome" />

                                <label for="ipt-email">Email:</label>
                                <input type="email" name="ipt-email" id="ipt-email" />

                                <label for="ipt-senha">Senha:</label>
                                <input type="password" name="ipt-senha" id="ipt-senha" />

                                <label for="ipt-con-senha">Confirmar Senha:</label>
                                <input type="password" name="ipt-con-senha" id="ipt-con-senha" />

                                <input type="hidden" name="tipo" value="c" />
                                <input type="submit" value="Cadastrar" class="btn-enviar" />
                            </form>
                        </div>
                        <div class="selecao-form-dois">
                            <form method="POST" action="<?=$_SERVER["BASE_URL"]?>auth/salvar">
                                <label for="ipt-cnpj">CNPJ:</label>
                                <input type="text" name="ipt-cnpj" id="ipt-cnpj" />

                                <label for="ipt-nome2">Nome:</label>
                                <input type="text" name="ipt-nome" id="ipt-nome2" />

                                <label for="ipt-email2">Email:</label>
                                <input type="email" name="ipt-email" id="ipt-email2" />

                                <label for="ipt-senha2">Senha:</label>
                                <input type="password" name="ipt-senha" id="ipt-senha2" />

                                <label for="ipt-con-senha2">Confirmar Senha:</label>
                                <input type="password" name="ipt-con-senha" id="ipt-con-senha2" />

                                <input type="hidden" name="tipo" value="e" />
                                <input type="submit" value="Cadastrar" class="btn-enviar" />
                            </form>
                        </div>
                    </div>
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