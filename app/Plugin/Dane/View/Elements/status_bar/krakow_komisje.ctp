<ul class="dataHighlights col-xs-12">
    <? if ($komisja->getData('kadencja_id') == '6') { ?>
        <li class="dataHighlight col-xs-3">
            <a href="<?= $komisja->getUrl() ?>/radni"><span class="icon icon-moon">&#xe617;</span>Skład
                <span class="glyphicon glyphicon-chevron-right"></a>
        </li>
    <? } ?>
</ul>