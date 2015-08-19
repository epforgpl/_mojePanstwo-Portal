<? if (!isset($this->request->query['conditions'][$map['field']])) { ?>
<div class="agg agg-List">
		
    <? if ($data['buckets']) { ?>
        <ul class="nav nav-pills nav-stacked">
            <? 
	        $limit = 5;
	        $index = 0;
	        $more = false;
	        foreach ($data['buckets'] as $b) { 
		        
		        if( $index==$limit ) {
		        	$more = uniqid();
		        	echo '</ul><ul id="cl' . $more . '" class="nav nav-pills nav-stacked collapse">';
		        }
		        
	        ?>
                <li>
                    <?
					
					$label = ' - ';
					$href = '#';
					
					if( isset($b['label']) ) {
						
						if( is_array($b['label']) ) {
							
							$label = $b['label']['buckets'][0]['key'];
							$href = $map['chooseRequest'] . $b['key'];
							
						} elseif( is_string($b['label']) ) {
							
						}
						
					} else {
						
						$label = $b['key'];
						$href = $map['chooseRequest'] . $b['key'];
						
					}
								                    
                    ?>

                    <a href="<?= $href ?>"><?= $label ?><? if (isset($b['doc_count'])) { ?> <span
                            class="badge pull-right"><?= $b['doc_count'] ?></span><? } ?></a>
                </li>
            <?
	            $index++;
            }
	        ?>
        </ul>
        <? if( $more ) {?>
        <p class="text-center">
	        <a data-toggle="collapse" href="#cl<?= $more ?>" onclick="return false;">Więcej</a>
        </p>
        <? } ?>
    <? } ?>
</div>
<? } else {?>

<p class="label-browser">
    <a href="<?= $map['cancelRequest']; ?>" aria-label="Close">
        <span class="label label-primary">
            <span aria-hidden="true">&times;</span>&nbsp;
            <?= isset($data['buckets'][0]['label']['buckets'][0]['key']) ? $data['buckets'][0]['label']['buckets'][0]['key'] : (isset($data['buckets'][0]['key']) ? $data['buckets'][0]['key'] : 'Usuń filtr'); ?>
        </span>
    </a>
</p>

<? } ?>