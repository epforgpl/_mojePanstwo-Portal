<?
	$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
?>
<div class="container dataBrowser">
	
	<div class="row">
		<form action="" data-url="<?= $dataBrowser['cancel_url']; ?>" method="get" class="form-horizontal searchForm col-md-8<? if( empty($dataBrowser['aggs']) ) {?> col-md-offset-1<?}?>">
			
			<? if( isset($title) ) { ?>
			<h2><?= $title ?></h2>
			<? } ?>
			
	        <div class="form-group has-feedback">
	            <div class="col-md-12">
	                <?
	                    $value = isset( $this->request->query['q'] ) ? addslashes( $this->request->query['q'] ) : '';
	                ?>
	                <input class="form-control hasclear" placeholder='<? if(isset($dataBrowser['search_label'])) { echo addslashes($dataBrowser['search_label']); } else { echo "Szukaj ..."; } ?>' type="text" value="<?= $value ?>" name="q" required>
	                <a href="<?= $dataBrowser['cancel_url']; ?>"><span class="clearer form-control-feedback" aria-hidden="true">&times;</span></a>
	            </div>
	        </div>
	    </form>
	</div>
        
    <? if(
    	( $params = $this->Paginator->params() ) && 
    	isset( $params['count'] )
    ) {?>
    <div class="row">
	    <div class="dataCounter col-md-8<? if( empty($dataBrowser['aggs']) ) {?> col-md-offset-1<?}?>"><p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?> (<?= round($dataBrowser['took'], 2) ?> s)</p></div>
    </div>
    <? } ?>
    	
	<div class="row">
		
		<? if( empty($dataBrowser['aggs']) ) {?>
		<div class="col-md-8 col-md-offset-1">
		<? } else {?>
		<div class="col-md-8">
		<? } ?>

	        
	        <div class="dataObjects">
		        		        
				<div class="innerContainer update-objects">
					
					<?
					if (isset($dataBrowser['hits'])) {
					    if (empty($dataBrowser['hits'])) {
					        echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
					    } else {
					        ?>
					        <ul class="list-group list-dataobjects">
					            <?
					            foreach ($dataBrowser['hits'] as $object) {
					
					                echo $this->Dataobject->render($object, 'default', array(
					                    // 'hlFields' => $dataBrowser->hlFields,
					                    // 'hlFieldsPush' => $dataBrowser->hlFieldsPush,
					                    // 'routes' => $dataBrowser->routes,
					                    // 'forceLabel' => in_array($page['mode'], array('*', 'datachannel')),
					                    // 'defaults' => $defaults,
					                ));
					            }
					            ?>
					        </ul>
					    <?
					    }
					}
					?>
				
				</div>
								
			</div>
			
			<div class="dataPagination">
				<ul class="pagination">
				<?php

                  //$this->MPaginator->options['url'] = array('alias' => 'prawo');
                  //$this->MPaginator->options['paramType'] = 'querystring';

                  //echo $this->MPaginator->first('&larr;', array('tag' => 'li', 'escape' => false), '<a href="#">&larr;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
				  echo $this->MPaginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
				  echo $this->MPaginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
				  echo $this->MPaginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
				  //echo $this->MPaginator->last('&rarr;', array('tag' => 'li', 'escape' => false), '<a href="#">&rarr;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
				?>
				</ul>
			</div>
	        
		</div>
		<? if(!empty($dataBrowser['aggs'])) { ?>
		<div class="col-md-4">
            <ul class="dataAggs">
            <? foreach($dataBrowser['aggs'] as $agg_id => $agg_data) { ?>
                <? if(count($agg_data['buckets']) > 0) { ?>
                    <li class="agg">
                        <h2><?= $dataBrowser['aggs_visuals_map'][$agg_id]['label']; ?></h2>
                        <? echo $this->element('Dane.DataBrowser/' . $dataBrowser['aggs_visuals_map'][$agg_id]['skin'], array(
                            'data' => $agg_data,
                            'map' => $dataBrowser['aggs_visuals_map'][$agg_id]
                        )); ?>
                    </li>
                <? } ?>
            <? } ?>
            </ul>
		</div>
		<? } ?>
	</div>

</div>