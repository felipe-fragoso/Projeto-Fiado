<div class="card card-medium">
    <h3 class="card-title"><?=$title?></h3>
    <div class="card-content">
        <p><b>Total:</b> R$ <?=$graph->getTotal()?></p>
        <div class="grafico-barra">
            <div class="g-moeda"><?=$graph->getMoeda()?></div>
            <?php
                foreach ($graph->getBars() as $bar):
            ?>
            <div class="g-barra">
                <div class="g-barra-titulo"><?=$bar->name?></div>
                <div class="g-barra-valor"><?=$bar->value ?: 0?></div>
            </div>
            <?php
                endforeach;
            ?>
        </div>
        <p><a href="<?=$url?>">Mais Detalhes</a></p>
    </div>
</div>