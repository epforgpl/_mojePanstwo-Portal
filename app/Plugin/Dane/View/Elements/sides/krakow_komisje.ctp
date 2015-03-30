<div class="objectSideInner rrs">


    <div class="block">

        <div class="block-header">
            <h2 class="label">Komisja</h2>
        </div>

        <ul class="dataHighlights side">
			
			<li class="dataHighlight">
                <a href="<?= $komisja->getUrl() ?>/posiedzenia"><span
                        class="icon icon-moon">&#xe615;</span>Posiedzenia <span
                        class="glyphicon glyphicon-chevron-right"></a>
            </li>
			
			<? if( $komisja->getData('kadencja_id')=='6' ) {?>
            <li class="dataHighlight">
                <a href="<?= $komisja->getUrl() ?>/radni"><span class="icon icon-moon">&#xe617;</span>Skład
                    <span class="glyphicon glyphicon-chevron-right"></a>
            </li>
            <? } ?>
            

        </ul>

    </div>


</div>