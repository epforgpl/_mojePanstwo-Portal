<?
	echo $this->Combinator->add_libs('css', $this->Less->css('search-main', array('plugin' => 'Dane')));
?>
<div class="container">

<? if( @$isAdmin ) {?>
	<p class="took"><?= $dataBrowser['took'] ?> s</p>
<? } ?>

<? foreach( $apps as $app ) { $href = $app['app']['href'] . '?q=' . $this->request->query['q'] ?>
	
	<div class="app-row">	
		<div class="row">
			<div class="col-md-2">
				<a href="<?= $href ?>" class="app">
					<img class="_mPAppIcon icon" src="<?= $app['icon_path'] ?>">
				</a>
				
			</div><div class="col-md-8">
				
				<div class="block margin-top-0">
					<header><a href="<?= $href ?>"><?= $app['app']['name'] ?></a></header>
					<p class="search_counter"><?= pl_dopelniacz($app['doc_count'], 'wynik', 'wyniki', 'wyników') ?></p>
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