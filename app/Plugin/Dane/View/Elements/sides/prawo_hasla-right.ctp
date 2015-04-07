<div class="objectSideInner">
	    
    <? if ($object->getLayer('tags')) { ?>
    <div class="block">
        <div class="block-header">
            <h2 class="label">Pokrewne tematy</h2>
        </div>
        <ul class="dataHighlights side">
        <? foreach( $object->getLayer('tags') as $tag ) {?>	
        	
        	<li class="dataHighlight"><a title="<?= addslashes($tag['q']) ?>" href="/dane/prawo_hasla/<?= $tag['id'] ?>"><?= $this->Text->truncate($tag['q'], 35) ?></a></li>
        	
        <? } ?>	
        </ul>
    </div>
    <? } ?>
	
	<div class="block">
        <ul class="dataHighlights side">

            <li class="dataHighlight">
                <p class="_label">Źródło</p>

                <p class="_value sources">
                    <a itemprop="sameAs" href="http://isap.sejm.gov.pl/KeyWordServlet?viewName=thasA&passName=<?= json_decode(str_replace('\u00a0', '', json_encode( $object->getData('q') )), true) ?>" target="_blank">ISAP</a>
                </p>
            </li>



        </ul>
    </div>

</div>