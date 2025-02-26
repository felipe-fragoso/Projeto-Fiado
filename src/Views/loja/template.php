<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Area da Empresa</title>
        <link rel="stylesheet" type="text/css" href="<?=$_SERVER["BASE_URL"]?>css/main.css">
        <script src="<?=$_SERVER["BASE_URL"]?>js/main.js"></script>
        <script src="<?=$_SERVER["BASE_URL"]?>js/carrossel.js"></script>
    </head>

    <body>
        <?php
            require_once 'layout/head.php';
        ?>
        <div class="content-wrapper main-box">
            <?php
                require_once 'layout/menu.php';

                $this->load($data->view, $viewData)
            ?>
        </div>
        <?php
            require_once 'layout/footer.php';
        ?>
    </body>
</html>