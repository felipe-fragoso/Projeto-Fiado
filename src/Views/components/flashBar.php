<?php
    if (isset($flash->message)):
?>
<div class="flashbar-base flashbar-msg">
    <div class="flashbar-content flashbar-type-<?=strtolower($flash->message->type)?>">
        <span><?=$flash->message->message?></span>
        <div class="flashbar-content-close" onclick="this.parentNode.remove()">x</div>
    </div>
</div>
<?php
    endif;
    if (isset($flash->error)):
?>
<div class="flashbar-base flashbar-error">
    <?php
        foreach ($flash->error as $key => $error):
            foreach ($error as $errorMessage):
                if ($errorMessage):
            ?>
    <div class="flashbar-content flashbar-type-error">
        <span><?="Campo {$key}: {$errorMessage}"?></span>
        <div class="flashbar-content-close" onclick="this.parentNode.remove()">x</div>
    </div>
    <?php
                endif;
            endforeach;
        endforeach;
    ?>
</div>
<?php
    endif;
?>