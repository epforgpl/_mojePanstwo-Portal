<?
	// $this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	echo $this->Html->css($this->Less->css('msig-cover', array('plugin' => 'Krs')));
?>


<div class="col-xs-12">
		
		<div class="appBanner">
		
		    <h1 class="appTitle">Monitor Sądowy i Gospodarczy</h1>
		    <p class="appSubtitle">Przeglądaj ogłoszenia sądowe</p>
		
		    <form action="/krs/msig" method="get">
		        <div class="appSearch form-group">
		            <div class="input-group">
		                <input name="q" class="form-control" placeholder="Szukaj w ogłoszeniach Monitora Sądowego i Gospodarczego..." type="text">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary input-md">
		                        <span class="glyphicon glyphicon-search"></span>
		                    </button>
						</span>
		            </div>
		        </div>
		    </form>
		</div>


		
		<?
			$first_date = false;
		?>
		
		<div class="row">
			<div class="col-md-6">
				
				<div class="block">
			        <header>Najnowsze wydania Monitora Sądowego i Gospodarczego:</header>
			        <section class="content">
			            <div class="agg agg-Dataobjects">
				            				            
			                <ul class="dataobjects img-nopadding" style="margin: 0 20px;">
			                    <? foreach ($dataBrowser['aggs']['msig_wydania']['top']['hits']['hits'] as $doc) { ?>
			                        <li class="margin-top-10">
			                            <?
				                            if( $first_date===false ) {
					                            $first_date = $doc['_source']['data']['msig']['data'];
				                            }
				                            echo $this->Dataobject->render($doc, 'default');
			                            ?>
			                        </li>
			                    <? } ?>
			                </ul>

			            </div>
			
			            <div class="buttons">
				            <p>
				                <a href="/krs/msig_wydania" class="btn btn-xs btn-primary">Zobacz więcej &raquo;</a>
				            </p>
				            
				            <?
					            $parts = explode('-', $first_date);
					            $date = array(
						            'y' => (int) $parts[0],
						            'm' => (int) $parts[1],
						            'd' => (int) $parts[2],
					            );					            
				            ?>
				            				            
				            <div class="search_by_date">
					            <p>Znajdź wydanie według daty:</p>
					            <form class="text-center" action="/krs/msig" method="get">
						            <div class="row">
							            <div class="col-md-4">
								            
								            <p class="desc">Rok:</p>
								            
								            <select class="form-control" name="y" data-value="<?= $date['y'] ?>">
									        <? foreach( $dataBrowser['aggs']['msig_wydania']['years']['buckets'] as $b ) { ?>
									            <option value="<?= $b['key_as_string'] ?>"<? if( $b['key_as_string']==$date['y'] ) {?> selected="selected"<? } ?>><?= $b['key_as_string'] ?></option>
									        <? } ?>
								            </select>
								            
							            </div><div class="col-md-4">
								            
								            <p class="desc">Miesiąc:</p>
	
								            <select class="form-control" name="m" data-value="<?= $date['m'] ?>">
									        	<option value="">Wszystkie</option>
									        <? foreach( $miesiace as $id => $nazwa ) {?>
									            <option value="<?= $id ?>"<? if( $id==$date['m'] ) {?> selected="selected"<? } ?>><?= $nazwa ?></option>
									        <? } ?>
								            </select>
								            
							            </div><div class="col-md-4">
								            
								            <p class="desc">Dzień:</p>
	
								            <select class="form-control" name="d" data-value="<?= $date['d'] ?>">
									        	<option value="">Wszystkie</option>
									        <? for( $i=1; $i<=31; $i++ ) {?>
									            <option value="<?= $i ?>"><?= $i ?></option>
									        <? } ?>
								            </select>
								            
							            </div>
						            </div>
						            <p class="search_button">
						                <input name="search_by_date" class="btn btn-xs btn-primary" type="submit" value="Szukaj..." />
						            </p>
					            </form>
				            </div>
			            </div>
			        </section>
			    </div>
				
			</div><div class="col-md-6">
				
				<div class="block">
			        <header>Przeglądaj według typów ogłoszeń:</header>
			        <section class="content">
			            <div class="agg agg-Dataobjects">
				            				            		            
			                <ul class="dataobjects msig_dzialy">
			                    <? foreach ($dataBrowser['aggs']['msig_dzialy']['buckets'] as $b) { if( array_key_exists($b['key'], $dzialy) ) { ?>
			                        <li>
			                        	<a class="row" href="/krs/msig?conditions[msig_dzialy.typ_id]=<?= $b['key'] ?>">
				                        	<div class="col-sm-10">
					                        	<p class="title"><span class="glyphicon glyphicon-chevron-right"></span><span class="text"><?= isset($dzialy[ $b['key'] ]) ? $dzialy[ $b['key'] ] : 'tytul' ?></span></p>
				                        	</div><div class="col-sm-2">
					                        	<p title="<?= $b['doc_count'] ?>" class="counter"><span><?= number_format_h($b['doc_count']) ?></span></p>
				                        	</div>
			                        	</a>
			                        </li>
			                    <? } } ?>
			                </ul>

			            </div>
			        </section>
			    </div>
				
			</div>
		</div>
		
</div>