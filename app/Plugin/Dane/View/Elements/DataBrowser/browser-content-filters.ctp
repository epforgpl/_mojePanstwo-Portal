<?
	$phrases = array('wynik', 'wyniki', 'wyników');
	
	if (@isset($dataBrowser['phrases']['paginator']) && $dataBrowser['phrases']['paginator'])
	    $phrases = $dataBrowser['phrases']['paginator'];
	
	if (isset($paginatorPhrases) && $paginatorPhrases)
	    $phrases = $paginatorPhrases;	    
?>

<? if( (!isset($nopaging) || !$nopaging) ) {?>
<div class="dataAggsDropdownListContainer<? if( isset($class) ) echo ' ' . $class; ?>">
	
	
	<? if (
		(
			isset($dataBrowser['aggs_visuals_map']) && 
			( count($dataBrowser['aggs_visuals_map']) > 0 )
		) || 
		(
			isset( $paging['count'] ) && 
			(
				!isset($nopaging) || 
				!$nopaging
			)
		)
	) {
	    $selected = false;
    ?>
	
	<ul class="nav nav-pills dataAggsDropdownList nopadding" role="tablist">
	
				<? if (isset($paging['count']) && (!isset($nopaging) || !$nopaging)) { ?>
			        <li>
			            <div class="dataCounter">
				            <? if( $paging['count'] ) {?>
			                <span><?= pl_dopelniacz($paging['count'], $phrases[0], $phrases[1], $phrases[2]) ?></span>
			                <? } else { ?>
			                <span><?= __d('dane', isset($noResultsPhrase) ? $noResultsPhrase : 'LC_DANE_BRAK_WYNIKOW') ?></span>
			                <? } ?>
			            </div>
			        </li>
			    <? } ?>
					
					
	        <?
	        foreach ($dataBrowser['aggs_visuals_map'] as $name => $map) {
            ?>
			
	            <?
	            if (($name != 'dataset') && isset($map['target']) && ($map['target'] == 'filters')) {
	
	                if (!isset($map['all']))
	                    $map['all'] = 'Wszystkie dane';
	
	                $isSelected = isset($this->request->query['conditions'][$map['field']]);
	
	                ?>
	                <li role="presentation" class="dropdown dataAggsDropdown<?= $isSelected ? ' active' : ''; ?>"
	                    data-skin="<?= $map['skin'] ?>"
	                    data-aggs="<?= htmlspecialchars(json_encode($dataBrowser['aggs'][$name]), ENT_QUOTES, 'UTF-8') ?>" 
	                    data-cancel-request="<?= $map['cancelRequest'] ?>"
	                    data-label-dictionary='<?= json_encode(isset($map['dictionary']) ? $map['dictionary'] : array()) ?>'
	                    data-choose-request="<?= $map['chooseRequest'] ?>"
	                    data-all-label="<?= $map['all'] ?>"
						data-desc="<?= isset($map['desc']) ? $map['desc'] : '' ?>"
	                    data-label="<?= @$map['label'] ?>"
	                    data-is-selected="<?= $isSelected ?>"
	                    data-selected="<?= @$this->request->query['conditions'][$map['field']] ?>">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
	                       aria-expanded="false">
	                        <? if ($isSelected) {
	
	                            $selected = true;
	
	                            if ($map['skin'] == 'krs/kapitalizacja') {
	                                $label = 'Kapitalizacja: ' . es_range_number($this->request->query['conditions'][$map['field']]);
	                            } elseif ($map['skin'] == 'date_histogram') {
	                                $t = $this->request->query['conditions'][$map['field']];
	
	                                $labels = array(
	                                    '1D' => 'Ostatnie 24 godziny',
	                                    '1W' => 'Ostatni tydzień',
	                                    '1M' => 'Ostatni miesiąc',
	                                    '1Y' => 'Ostatni rok'
	                                );
	
	                                if (array_key_exists($t, $labels)) {
	                                    $label = $labels[$t];
	                                } else {
	                                    $label = 'Kiedykolwiek';
	                                    $ranges = explode('TO', $t);
	                                    if (count($ranges) == 2) {
	                                        $from = trim(substr($ranges[0], 1));
	                                        $to = trim(substr($ranges[1], 0, -1));
	                                        if ($from == $to) {
	                                            $label = dataSlownie($from);
	                                        } else {
	                                            $label = dataSlownie($from) . ' - ' . dataSlownie($to);
	                                        }
	                                    }
	                                }
	                            } elseif (isset($map['dictionary']) && isset($map['dictionary'][$this->request->query['conditions'][$map['field']]])) {
	                                $label = $map['dictionary'][$this->request->query['conditions'][$map['field']]];
	                            } else {
	                                foreach ($dataBrowser['aggs'][$name]['buckets'] as $b => $bucket) {
	                                    if ($bucket['key'] == $this->request->query['conditions'][$map['field']]) {
	                                        $label = isset($dataBrowser['aggs'][$name]['buckets'][$b]['label']['buckets'][0]['key']) ?
	                                            $dataBrowser['aggs'][$name]['buckets'][$b]['label']['buckets'][0]['key'] :
	                                            (isset($dataBrowser['aggs'][$name]['buckets'][$b]['key']) ?
	                                                $dataBrowser['aggs'][$name]['buckets'][$b]['key'] :
	                                                'Usuń filtr');
	                                        break;
	                                    }
	                                }
	                            }
	
	                            $label = isset($label) ? $label : $this->request->query['conditions'][$map['field']];
	                            if( isset($map['activePrefix']) )
		                            $label = $map['activePrefix'] . $label;
	                            echo $label;
	
	                        } else { ?>
	                            <?= $map['all'] ?>
	                        <? } ?>
	                        <span class="caret"></span>
	                    </a>
	                    <ul class="dropdown-menu">
		                    <li class="title"><?= $map['label'] ?>:</li>
	                    </ul>
	                </li>
	            <? }
	        } ?>
	        
	        <? if (isset($dataBrowser['sort']) && $dataBrowser['sort'] && (!isset($nopaging) || !$nopaging)) { ?>
	            <li role="presentation" class="dropdown dataAggsDropdown splitDropdownMenu pull-right">
	                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
	                   aria-expanded="false">Sortowanie <span class="caret"></span></a>
	                <ul class="dropdown-menu modal-sort">
	                    <?php
	                    $order_key = false;
	                    $order_value = false;
	                    if (isset($this->request->query['order'])) {
	                        $order_query_parts = explode(' ', $this->request->query('order'));
	                        $order_key = $order_query_parts[0];
	                        $order_value = $order_query_parts[1];
	                    } else {
							$order_key = 'score';
							$order_value = 'desc';
	                    }
	
	                    foreach ($dataBrowser['sort'] as $sortKey => $sortValue) {
	                                                
	                        $sort = '<li>';
	                        $sort .= '<span>' . $sortValue['label'] . '</span>';
	                        $sort .= '<ul>';
	
	                        foreach ($sortValue['options'] as $sortOptionsKey => $sortOptionsValue) {
	                            
	                            if( $sortKey=='score' )
		                            $query = array_merge($this->request->query, array(
		                                'order' => null,
		                            ));
		                        else
		                        	$query = array_merge($this->request->query, array(
		                                'order' => $sortKey . ' ' . $sortOptionsKey,
		                            ));
	
	
	                            $sort .= '<li' . (($order_key == $sortKey && $order_value == $sortOptionsKey) ? ' class="active"' : '') . '><a href="/' . $this->request->url . '?' . http_build_query($query) . '">' . $sortOptionsValue . '</a></li>';
	                        }
	
	                        $sort .= '</ul>';
	                        $sort .= '</li>';
													
	                        echo $sort;
	                    }
	                    ?>
	                </ul>
	            </li>
	        <? } ?>
	
	        <? if ($selected) { ?>
	            <li role="presentation" class="cancel">
	                <a href="<?= $dataBrowser['cancel_url'] ?>" role="button" aria-haspopup="true" aria-expanded="false">
	                    Usuń filtry
	                </a>
	            </li>
	        <? } ?>
	        	        
	        <? if( $dataBrowser['observe'] ) { ?>
	        <li role="presentation" class="pull-right dataobject-head" data-dataset="<?= $dataBrowser['observe']['dataset'] ?>" data-object_id="<?= $dataBrowser['observe']['object_id'] ?>">
                <a class="btn-observe" href="#"><span class="icon" data-icon-applications="&#xe60a;"></span> Obserwuj</a>
	        </li>
	        <? echo $this->element('Dane.modals/dataobject-observe'); ?>
	        <? } ?>

		
	</ul>
	<? } ?>
	

</div>
<? } ?>
