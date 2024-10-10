<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FiadoFacil - Fiado do jeito certo</title>
        <link rel="stylesheet" type="text/css" href="<?= $_SERVER["BASE_URL"] ?>css/main.css">
    </head>

    <body>
        <?php
            require_once 'layout/head.php';
        ?>
        <div class="main-box">
            <?php
                $this->load($view, $viewData)
            ?>
        </div>
        <?php
            require_once 'layout/footer.php';
        ?>
    </body>
</html>