<?
	
	$this->Combinator->add_libs('css', $this->Less->css('sejm', array('plugin' => 'Dane')));
	
	$stats = array();
        	
	$fields = array(
    	array('ustaw', 'ustawę', 'ustawy', 'ustaw'),
    	array('uchwal', 'uchwałę', 'uchwały', 'uchwał'),
    	array('sprawozdan_kontrolnych', 'sprawozdanie kontrolne', 'sprawozdania kontrolne', 'sprawozdań kontrolnych'),
    	array('referendow', 'wniosek o referendum', 'wnioski o referenda', 'wniosków o referenda'),
    	array('powolan_odwolan', 'powołanie / odwołanie', 'powołania / odwołania', 'powołań / odwołań'),
    	array('zmian_komisji', 'zmianę w komisjach', 'zmiany w komisjach', 'zmian w komisjach'),
    	array('inne', 'inny projekt', 'inne projekty', 'innych projektów'),
	);
	
	
	
	foreach( array('przyjetych', 'odrzuconych', 'skierowanych') as $type ) {
    	
    	$stats[ $type ] = array();
    	
    	foreach( $fields as $field ) {
        	
        	$_field = 'sejm_posiedzenia.liczba_' . $type . '_' . $field[0];
        	
        	if( $data[$_field] )
        		$stats[$type][] = pl_dopelniacz($data[$_field], $field[1], $field[2], $field[3]);
        	
    	}
	}
	
	$stats['senat'] = $data['sejm_posiedzenia.liczba_poprawki_senatu'];
	
?>
<section class="aggs-init">	
	
    <div class="dataAggs">
        <div class="agg agg-Dataobjects sejm_posiedzenie">
            
            <div class="row">
                
                <div class="col-md-5">
                    <ul class="stats">
                        <li>
                            <? if( $stats['przyjetych'] ) {?><p><span class="glyphicon glyphicon-ok"></span> Przyjęto <?= implode(', ', $stats['przyjetych']) ?>.</p><? } ?>
                            <? if( $stats['odrzuconych'] ) {?><p><span class="glyphicon glyphicon-remove"></span> Odrzucono <?= implode(', ', $stats['odrzuconych']) ?>.</p><? } ?>
                            <? if( $stats['skierowanych'] ) {?><p><span class="glyphicon glyphicon-arrow-right"></span> Do dalszych prac skierowano <?= implode(', ', $stats['skierowanych']) ?>.</p><? } ?>
                            <? if( $stats['senat'] ) { ?><p><span class="glyphicon glyphicon-arrow-right"></span>Rozpatrzono poprawki Senatu wobec <?= pl_dopelniacz($stats['senat'], 'ustawy', 'ustaw', 'ustaw') ?>.</p><? } ?>
                        </li>
                    </ul>
                </div><div class="col-md-7 text-center">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p>Największa zgodność:</p>
                            <p class="number">36,2%</p>
                        </div><div class="col-md-6">
                            <p>Najmniejsza zgodność:</p>
                            <p class="number">58,2%</p>
                        </div>
                    </div>
                    
                </div>		                            
                    
            </div>
            <? if( isset($buttons) && $buttons ) {?>
            <div class="row">
                <div class="buttons" style="margin-top: 0;">
                    <a href="/dane/instytucje/3214/posiedzenia/<?= $data['sejm_posiedzenia.id'] ?>" class="btn btn-primary btn-xs">Zobacz więcej</a>
                </div>
            </div>
            <? } ?>

        </div>
    </div>

</section>