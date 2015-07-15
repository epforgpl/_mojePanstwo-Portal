<ul class="dataHighlights oneline col-xs-12">

    <?
    $date = $object->getDate();
    if ($date) { ?>
        <li class="dataHighlight col-sm-3">
            <p class="_label">Data publikacji</p>

            <p class="_value"><?= dataSlownie( $date ) ?></p>
        </li>
    <? } ?>
    
</ul>