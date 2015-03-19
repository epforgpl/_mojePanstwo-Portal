<div class="container dataBrowser">
	
	<div class="row">
		<form action="" class="form-horizontal searchForm col-md-8<? if( empty($dataBrowser['aggs']) ) {?> col-md-offset-1<?}?>">
	        <div class="form-group has-feedback">
	            <div class="col-md-12">
	                <?
	                $value = isset( $this->request->query['q'] ) ? addslashes( $this->request->query['q'] ) : '';
	                ?>
	                <input class="form-control hasclear" placeholder='Szukaj w "<?= addslashes( $object->getTitle() ) ?>"...' type="text" value="<?= $value ?>" name="q">
	                <a href="/dane/prawo"><span class="clearer glyphicon glyphicon-remove-circle form-control-feedback"></span></a>
	            </div>
	        </div>
	    </form>
	</div>
    
    <? if(
    	( $params = $this->Paginator->params() ) && 
    	isset( $params['count'] )
    ) {?>
    <div class="row">
	    <div class="dataCounter col-md-8<? if( empty($dataBrowser['aggs']) ) {?> col-md-offset-1<?}?>"><p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?></p><? if( $params['pageCount'] > 1 ) {?><p class="pull-right">Strona <?= $params['page'] ?> z <?= $params['pageCount'] ?> </p><? } ?></div>
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
		<? if( !empty($dataBrowser['aggs']) ) {?>
		<div class="col-md-4">
			
			<? debug($dataBrowser['aggs']); ?>
			
			<ul>
				<li>
					<h3><?= $label ?></h3>
					<? echo $this->element('Dane.DataBrowser/' . $skin, array(
						'data' => $data
					)); ?>
				</li>
			</ul>
			
		</div>
		<? } ?>
	</div>

</div>