<div class="agg agg-List agg-Datasets<? if( isset($this->request->query['q']) ) {?> showCounters<? } ?>">
    <? if ($data['buckets']) { ?>
        <ul class="nav nav-pills nav-stacked">
            	
           	<? 
	        if( isset($_app) ) {
	        	
	        	$href = $_app['href'];
			?>
				
				<li<? if( 
					(
						!isset($dataBrowser['dataset']) || 
						!$dataBrowser['dataset'] 
					) && 
					!isset($this->request->query['q'])
				) {?> class="active"<? } ?>>
            		<a href="<?= $href ?>">Start</a>
            	</li>
				
			<?
	           	if (isset($this->request->query['q'])) {
                    $href .= "?q=" . urlencode($this->request->query['q']);
            ?>
            
	            	<li<? if( !isset($dataBrowser['dataset']) || !$dataBrowser['dataset'] ) {?> class="active"<? } ?>>
	            		<a href="<?= $href ?>">Wyniki wyszukiwania<? if(isset($data['doc_count']) && $data['doc_count']) {?> <span class="counter"><?= $data['doc_count'] ?></span><? } ?></a>
	            	</li>
            
	            <? } ?>
	        <? } ?>
            	
            <? foreach ($data['buckets'] as $b) {
                	            
                $active = false;
                  					
                $href = '/bdl/kategorie/' . $b['key'];
                $label = $b['label']['buckets'][0]['key'];
                
                if( 
                	isset($dataBrowser['dataset']) && 
                	( $dataBrowser['dataset'] == $b['key'] )
                )
                	$active = true;

                if (isset($this->request->query['q']))
                    $href .= "?q=" . urlencode($this->request->query['q']);

                ?>

                <li<? if($active) { ?> class="active"<?}?>>
                	<a href="<?= $href ?>">
	                	<?= $label ?><? if (isset($b['doc_count'])) { ?> <span class="counter"><?= $b['doc_count'] ?></span><? } ?>
                    </a>
                </li>
                        
                
            <? } ?>
        </ul>
    <? } ?>
</div>
