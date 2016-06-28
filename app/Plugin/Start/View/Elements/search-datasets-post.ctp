<?
	echo $this->element('Dane.modals/dataobject-observe');
	echo $this->Combinator->add_libs('css', $this->Less->css('search-main', array('plugin' => 'Dane')));
		
?>
<div class="container">

	<div class="search-header">
		<p class="took pull-left"><?= pl_dopelniacz($dataBrowser['count'], 'wynik', 'wyniki', 'wyników') ?></p>
	<? if( @$dataBrowser['appObserve'] ) {?>
		<p class="pull-right dataobject-head" data-dataset="aplikacje" data-object_id="<?= $dataBrowser['appObserve'] ?>">
			<a href="#" class="btn-observe">
			    <span class="icon"
			          data-icon-applications="&#xe60a;"></span> <?= (isset($subscription) && !empty($subscription)) ? 'Obserwujesz' : 'Obserwuj' ?>
			</a>
		</p>
	<? } ?>
	</div>
	
	<? foreach( $datasets as $dataset ) { $href = $dataset['dataset']['app_id'] . '/' . $dataset['dataset']['dataset_name']['menu_id'] . '?q=' . $this->request->query['q']; ?>
		
		<div class="app-row">	
			<div class="row">
				<div class="col-md-8 col-md-offset-1">
					
					<div class="block margin-top-0">
						
						<header>
							<a class="pull-left" href="<?= $href ?>"><?= $dataset['dataset']['dataset_name']['label'] ?></a>
							<p class="search_counter"><?= pl_dopelniacz($dataset['doc_count'], 'wynik', 'wyniki', 'wyników') ?></p>
						</header>
						
						<section class="content">
					        <div class="agg agg-Dataobjects">
			                    <ul class="dataobjects img-nopadding" style="margin: 0 20px;">
			                        <? foreach ($dataset['top']['hits']['hits'] as $doc) { ?>
			                            <li class="margin-top-10">
			                                <?
			                                echo $this->Dataobject->render($doc, 'default');
			                                ?>
			                            </li>
			                        <? } ?>
			                    </ul>
			                </div>
													
		                    <div class="buttons">
				                <a href="<?= $href ?>" class="btn btn-xs btn-primary">Zobacz więcej &raquo;</a>
		                    </div>
				        </section>
				        
					</div>
					
				</div>
			</div>
		</div>
		
	<? } ?>	
			
</div>