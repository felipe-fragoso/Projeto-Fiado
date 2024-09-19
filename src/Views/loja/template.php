<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Area da Empresa</title>
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <script src="../js/carrossel.js"></script>
    </head>

    <body>
        <?php
            require_once 'layout/head.php';
        ?>
        <div class="content-wrapper main-box">
            <?php
                require_once 'layout/menu.php';

                $this->load($view, $viewData)
            ?>
        </div>
        <?php
            require_once 'layout/footer.php';
        ?>
    </body>
</html>