<?php
    if (isset($message)):
?>
<div class="flashbar-base flashbar-msg">
    <div class="flashbar-content flashbar-type-<?=strtolower($message->type)?>">
        <span><?=$message->message?></span>
        <div class="flashbar-content-close" onclick="this.parentNode.remove()">x</div>
    </div>
</div>
<?php
    endif;
    if (isset($error)):
?>
<div class="flashbar-base flashbar-error">
    <?php
        foreach ($error as $key => $error):
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