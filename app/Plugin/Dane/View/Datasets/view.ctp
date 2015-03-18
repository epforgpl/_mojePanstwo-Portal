<?= $this->Element('dataobject/pageBegin'); ?>


<div class="container dataBrowser">
	
	<div class="row">
		<div class="col-md-8">
			
			<form action="/prawo/szukaj" class="searchForm">
	            <div class="app_input">
	                <input type="text" placeholder='Szukaj w "<?= addslashes( $object->getTitle() ) ?>"...' class="datasearch form-control input-md ui-autocomplete-input" autocomplete="off" value="" name="q">
	            </div>
	        </form>
	        
	        <? if(
		    	( $params = $this->Paginator->params() ) && 
		    	isset( $params['count'] )
		    ) {?>
	        <div class="dataCounter"><p class="pull-left"><?= pl_dopelniacz($params['count'], 'wynik', 'wyniki', 'wyników') ?></p><p class="pull-right">Strona <?= $params['page'] ?> z <?= $params['pageCount'] ?> </p></div>
	        <? } ?>
	        
	        <div class="dataObjects">
				<div class="innerContainer update-objects">
					
					<?
					if (isset($dataBrowser['objects'])) {
					    if (empty($dataBrowser['objects'])) {
					        echo '<p class="noResults">' . __d('dane', 'LC_DANE_BRAK_WYNIKOW') . '</p>';
					    } else {
					        ?>
					        <ul class="list-group list-dataobjects">
					            <?
					            foreach ($dataBrowser['objects'] as $object) {
					
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
				  echo $this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
				  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));
				  echo $this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href="#">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
				?>
				</ul>
			</div>
	        
		</div>
	</div>

</div>

<?= $this->Element('dataobject/pageEnd'); ?>