<?
	echo $this->element('Dane.modals/dataobject-observe');
	echo $this->Combinator->add_libs('css', $this->Less->css('search-main', array('plugin' => 'Dane')));
?>
<div class="container">

	<div class="search-header">
	<? if( @$isAdmin ) {?>
		<p class="took pull-left"><?= $dataBrowser['took'] ?> s</p>
	<? } ?>
		<p class="pull-right dataobject-head" data-phrase="<?= htmlspecialchars($this->request->query['q'], ENT_QUOTES, 'UTF-8') ?>">
			<a href="#" class="btn-observe">
			    <span class="icon"
			          data-icon-applications="&#xe60a;"></span> <?= (isset($subscription) && !empty($subscription)) ? 'Obserwujesz' : 'Obserwuj' ?>
			</a>
		</p>
	</div>
	
	<? foreach( $apps as $app ) { $href = $app['app']['href'] . '?q=' . $this->request->query['q']; ?>
		
		<div class="app-row">	
			<div class="row">
				<div class="col-md-2">
					<a href="<?= $href ?>" class="app">
						<img class="_mPAppIcon icon" src="<?= $app['icon_path'] ?>">
					</a>
					
				</div><div class="col-md-8">
					
					<div class="block margin-top-0">
																		
						<header>
							<a class="pull-left" href="<?= $href ?>"><?= $app['app']['name_' . $_lang] ?></a>
							<p class="search_counter"><?= pl_dopelniacz($app['doc_count'], 'wynik', 'wyniki', 'wyników') ?></p>
						</header>
						
						<section class="content">
					        <div class="agg agg-Dataobjects">
			                    <ul class="dataobjects img-nopadding" style="margin: 0 20px;">
			                        <? foreach ($app['top']['hits']['hits'] as $doc) { ?>
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