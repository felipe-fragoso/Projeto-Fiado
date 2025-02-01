<div class="pagination">
    <ol>
        <?php
            if ($data->pagination->hasPrevious()):
        ?>
        <li><a href="<?=$data->pagination->getFirstPage()?>">Primeira</a></li>
        <li><a href="<?=$data->pagination->getPreviousPage()?>">Anterior</a></li>
        <?php
            endif;
            foreach ($data->pagination->getPages() as $number => $url):
                if ($data->pagination->isCurrent($number)):
        ?>
        <li><span><?=$number?></span></li>
        <?php
                else:
        ?>
        <li><a href="<?=$url?>"><?=$number?></a></li>
        <?php
                endif;
            endforeach;
            if ($data->pagination->hasNext()):
        ?>
        <li><a href="<?=$data->pagination->getNextPage()?>">Próximo</a></li>
        <li><a href="<?=$data->pagination->getLastPage()?>">Última</a></li>
        <?php
            endif;
        ?>
    </ol>
</div>