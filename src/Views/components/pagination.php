<div class="pagination">
    <ol>
        <?php
            if ($pagination->hasPrevious()):
        ?>
        <li><a href="<?=$pagination->getFirstPage()?>">Primeira</a></li>
        <li><a href="<?=$pagination->getPreviousPage()?>">Anterior</a></li>
        <?php
            endif;
            foreach ($pagination->getPages() as $number => $url):
                if ($pagination->isCurrent($number)):
        ?>
        <li><span><?=$number?></span></li>
        <?php
                else:
        ?>
        <li><a href="<?=$url?>"><?=$number?></a></li>
        <?php
                endif;
            endforeach;
            if ($pagination->hasNext()):
        ?>
        <li><a href="<?=$pagination->getNextPage()?>">Próximo</a></li>
        <li><a href="<?=$pagination->getLastPage()?>">Última</a></li>
        <?php
            endif;
        ?>
    </ol>
</div>