<?
$this->Combinator->add_libs('css', $this->Less->css('view-zamowieniapubliczne', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('datafeed', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-zamowieniapubliczne');

echo $this->Element('dataobject/pageBegin'); ?>

<div class="row margin-top--40">
	<div class="col-sm-12">
	
		<ul class="dataHighlights row">
	        
	        <li class="dataHighlight col-md-3">
	            <p class="_label">Status</p>
                <p>
                    <? if ($object->getData('status_id') == '0') {
                        ?>
                        <span class="_label label label-success">Zamówienie otwarte</span>
                    <? } elseif ($object->getData('status_id') == '2') { ?>
                        <span class="_label label label-danger">Zamówienie rozstrzygnięte</span>
                    <? } ?>
                </p>
            </li>
	        
	        <li class="dataHighlight col-md-3">
	            <p class="_label">Tryb zamówienia</p>
                <p class="_value"><?= $object->getData('zamowienia_publiczne_tryby.nazwa') ?></p>
	        </li>
	                    
            <li class="dataHighlight col-md-6">
	            <p class="_label">Zamawiający</p>
                <p class="_value"><a href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamowienia_publiczne_zamawiajacy.id') ?>"><?= $object->getData('zamowienia_publiczne_zamawiajacy.nazwa') ?></a></p>
	        </li>
	        
	        
	                    
        </ul>
		
	</div>
</div>

<div class="row margin-top-10">
    <div class="col-xs-12 col-sm-2">
        
        <? if( $dokumenty = $object_aggs['dokumenty']['top']['hits']['hits'] ) {?>
        <div class="dataFeed margin-top-10">
            <div class="object col-feed-main" id="toc">
                
                <div class="feed-min feed-timeline">
			
			        <div class="dataObjects">
			            <div class="innerContainer update-objects">
			                
			                <div class="dataFeed-ul list-group list-dataobjects">
	                            <? foreach ($dokumenty as $dokument) { $dokument = $dokument['_source']['data']['zamowienia_publiczne_dokumenty']; ?>
	
	                                <div class="objectRender objclass zamowienia_publiczne_dokumenty">
									
									    <div class="row">
									        <div class="data col-xs-11">
									            <div class="feed-header">
									                <div class="inner">
								                        <p class="date"><?= dataSlownie($dokument['data_publikacji']) ?></p>
								                        <p class="title">
															<a href="#dokument-<?= $dokument['id'] ?>"><?= array_key_exists($dokument['typ_id'], $types_dictionary) ?  $types_dictionary[ $dokument['typ_id'] ] : 'Ogłoszenie' ?></a>
														</p>
				                                    </div>
									            </div>
					                            <? // <p class="label label-warning navigator">Tu jesteś</p> ?>
									        </div>
									    </div>
								    </div>
	
	                            <? } ?>
	                        </div>
			                
			            </div>
			            
			        </div>
			    </div>
                
            </div>
        </div>
        <? } ?>     
        
    </div>
    <div class="col-xs-12 col-md-7 objectMain">
                   
        <div class="object">
	        	        
	        <?
		        if( $dokumenty = $object_aggs['dokumenty']['top']['hits']['hits'] ) {
			        foreach( $dokumenty as $dokument ) {
				        				        
				        $details = $dokument['_source']['details'];
				        $dokument = $dokument['_source']['data'];
				        				        				        				        
			?>
				
				<div class="row">
					<div class="col-md-12">			
						<h2 id="dokument-<?= $dokument['zamowienia_publiczne_dokumenty']['id'] ?>" class="document_label"><span class="glyphicon glyphicon-menu-right"></span> <span class="title"><?= array_key_exists($dokument['zamowienia_publiczne_dokumenty']['typ_id'], $types_dictionary) ?  $types_dictionary[ $dokument['zamowienia_publiczne_dokumenty']['typ_id'] ] : 'Ogłoszenie' ?></span> <?= dataSlownie($dokument['zamowienia_publiczne_dokumenty']['data_publikacji']) ?></h2>
					</div>
				</div>
				
				<? if (isset($details['przedmiot'])) { ?>
	                <div class="block col-xs-12">
	                    <header>Przedmiot zamówienia</header>
	                    <section><?php echo(nl2br($details['przedmiot'])); ?></section>
	                </div>
	            <? } ?>
	
	            <? if (@$details['siwz_www'] || @$details['siwz_adres']) { ?>
	                <div class="block col-xs-12">
	                    <header>Specyfikacja Istotnych Warunków Zamówienia</header>
	                    <section>
	                        <? if (@$details['siwz_www']) { ?>
	                            <p>
	                                <a target="_blank"
	                                   href="<?= $details['siwz_www'] ?>"><?= $details['siwz_www'] ?></a>
	                            </p>
	                        <? } ?>
	                        <? if (@$details['siwz_adres']) { ?>
	                            <p><?= $details['siwz_adres'] ?></p>
	                        <? } ?>
	                    </section>
	                </div>
	            <? } ?>
	
	            <? if ((isset($dokument['zamowienia_publiczne_dokumenty']['oferty_data_stop']) && ($dokument['zamowienia_publiczne_dokumenty']['oferty_data_stop']) && ($dokument['zamowienia_publiczne_dokumenty']['oferty_data_stop'] != '0000-00-00')) || @$dokument['zamowienia_publiczne_dokumenty']['oferty_miejsce']) {
	                ?>
	                <div class="block col-xs-12">
	                    <header>Składanie ofert</header>
	                    <section>
	                        <p>Oferty można składać do
	                            <strong><?= $this->Czas->dataSlownie($dokument['zamowienia_publiczne_dokumenty']['oferty_data_stop']) ?></strong>, do
	                            godziny
	                            <strong><?= $dokument['zamowienia_publiczne_dokumenty']['oferty_godz'] ?></strong><? if (@$dokument['zamowienia_publiczne_dokumenty']['oferty_miejsce']) { ?>, w:<? } ?>
	                        </p>
	                        <? if (@$dokument['zamowienia_publiczne_dokumenty']['oferty_miejsce']) { ?>
	                            <p><?= $dokument['zamowienia_publiczne_dokumenty']['oferty_miejsce'] ?></p><? } ?>
	                    </section>
	                </div>
	            <? } ?>
						
				<? if (isset($details['czesci-wykonawcy'])) { ?>
	                <? foreach ($details['czesci-wykonawcy'] as $item) { ?>
	                    <div class="block col-xs-12">
	                        
	                        <header>Oferty <? if ($item['numer']) { ?> &mdash; Część <?= $item['numer'] ?><? } ?></header>
	                        	
	                        <section>
	                            <table class="table table-striped table-hover table-min">
	                                <thead>
	                                <tr>
	                                    <th>Liczba ofert / odrzuconych</th>
	                                    <th>Cena</th>
	                                    <th>Najniższa oferta</th>
	                                    <th>Najwyższa oferta</th>
	                                    <th>Wartość szacunkowa (bez VAT)</th>
	                                </tr>
	                                </thead>
	                                <tbody>
	                                <tr>
	                                    <td><?= $item['liczba_ofert'] ?>
	                                        / <?= $item['liczba_odrzuconych_ofert'] ?></td>
	                                    <td><?= number_format_h($item['cena']) ?> <?= $item['waluta'] ?></td>
	                                    <td><?= number_format_h($item['cena_min']) ?> <?= $item['waluta'] ?></td>
	                                    <td><?= number_format_h($item['cena_max']) ?> <?= $item['waluta'] ?></td>
	                                    <td><?= number_format_h($item['wartosc']) ?> <?= $item['waluta'] ?></td>
	                                    <? if (isset($admin)) { ?>
	                                        <td>
	                                            <button class="btn btn-xs btn-primary open_modal"
	                                                    numer="<?= $item['id'] ?>"><span class="glyphicon glyphicon-edit"
	                                                                                     aria-hidden="true"></span></button>
	                                        </td>
	                                    <? } ?>
	                                </tr>
	                                </tbody>
	                            </table>
	
	                            <p>Wybrany wykonawca:</p>
	                            <ul>
	                                <? 
		                                foreach ($item['wykonawcy'] as $w) {		                                			                                	
		                                	$href = $w['krs_id'] ? '/dane/krs_podmioty/' . $w['krs_id'] : '/dane/zamowienia_publiczne_zamawiajacy/' . $w['id'];
	                                ?>
	                                    <li>
	                                        <p><a href="<?= $href ?>"><?= $w['nazwa'] ?></a> (<?= $w['miejscowosc'] ?>)</p>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                        </section>
	                    </div>
	                    <? if (isset($admin)) { ?>
	                        <div class="modal" id="<?= $item['id'] ?>">
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <button type="button" class="close" data-dismiss="modal"
	                                                aria-hidden="true">&times;</button>
	                                        <h4 class="modal-title">Edycja:</h4>
	                                    </div>
	                                    <div class="modal-body">
	                                        <form method="" action="">
	                                        <div class="row">
	                                            <div class="col-sm-4">
	                                                <label class="pull-right">Cena:</label>
	                                            </div>
	                                            <div class="col-sm-6">
	                                                <input name="cena" class="form-control" value="<?= $item['cena'] ?>">
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-sm-4">
	                                                <label class="pull-right">Cena Min:</label>
	                                            </div>
	                                            <div class="col-sm-6">
	                                                <input name="cena_min" class="form-control" value="<?= $item['cena_min'] ?>">
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-sm-4">
	                                                <label class="pull-right">Cena Max:</label>
	                                            </div>
	                                            <div class="col-sm-6">
	                                                <input name="cena_max" class="form-control" value="<?= $item['cena_max'] ?>">
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-sm-4">
	                                            <label class="pull-right">Wartość:</label>
	                                        </div>
	                                        <div class="col-sm-6">
	                                            <input class="form-control" value="<?= $item['wartosc'] ?>" disabled>
	                                        </div>
	                                        </div>
	                                    </div>
	
	                                    <div class="modal-footer">
	                                        <div class="text-center">
	                                            <button type="submit" class="btn btn-md btn-primary btn-icon btn-inline"
	                                                    id="bdl_temp_savebtn"><i
	                                                    class="icon glyphicon glyphicon-ok"></i>Zapisz
	                                            </button>
	                                            </form>
	                                            <div class="inline">
	                                                <a class="margintop" id="bdl_temp_cancelbtn" href="#">Anuluj</a>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    <? } ?>
	                <? } ?>
	            <? } ?>
	            
	
	            <? foreach ($details as $key => $value) {
	                if( $value && in_array($key, $text_details_keys) ) {
	                    ?>
	                    <div class="block col-xs-12">
	                        <header><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_' . $key)); ?></header>
	                        <section><?php echo(nl2br($value)); ?></section>
	                    </div>
	                <? }
	            } ?>
				
			<?
			        }
		        }
		    ?>	        
            
        </div>
    </div>
    
    <div class="col-xs-12 col-md-3">
	    <ul class="dataHighlights">
	        
	        <? if( $object->getData('wartosc_cena') ) {?>
            <li class="dataHighlight">
	            <p class="_label">Wartość:</p>
                <p class="_value"><?= number_format_h($object->getData('wartosc_cena')) ?> PLN</p>
	        </li>
	        <? } ?>
	        
	        <? if( $wykonawcy = $object->getField('zamowienia_publiczne-wykonawcy') ) { ?>
	        <li class="dataHighlight">
	            <p class="_label">Wykonawcy:</p>
                
                <ul class="dataobjects nopadding ul_wykonawcy">
	            <?
		            foreach( $wykonawcy as $w ) {
		        		$href = $w['krs_id'] ? '/dane/krs_podmioty/' . $w['krs_id'] : '/dane/zamowienia_publiczne_zamawiajacy/' . $w['id'];
	            ?>
	            	<li>
	            		
	            		<div class="objectRender readed objclass zamowienia_publiczne_wykonawcy">
	                        <div class="data col-xs-12 nopadding">
	                            <div class="content">
	                                <span class="object-icon icon-datasets-zamowienia_publiczne_wykonawcy"></span>
	                                <div class="object-icon-side ">
	                                    <p class="title">
	                                        <a href="<?= $href ?>"><?= $w['nazwa'] ?></a>
	                                    </p>
	                                    <p class="meta meta-desc"><?= number_format_h($w['cena']) ?> <?= $w['waluta'] ?></p>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	            		
	            	</li>
	            <? } ?>
                </ul>
                
	        </li>
	        <? } ?>
	        
	        <? if( $kryteria = $object->getField('zamowienia_publiczne-kryteria') ) { ?>
	        <li class="dataHighlight">
	            <p class="_label">Kryteria wyboru ofert:</p>
                <ul class="dataobjects nopadding ul_kryteria">
	            <?
		            foreach( $kryteria as $k ) {
	            ?>
	            	<li>
	            		<p><?= ucfirst($k['nazwa']) ?></p>
	            		<? if( $k['punkty'] ) {?><p class="meta meta-desc"><?= pl_dopelniacz($k['punkty'], 'punkt', 'punkty', 'punktów') ?></p><? } ?>
	            	</li>
	            <? } ?>
                </ul>
	        </li>
	        <? } ?>
	               	        	                    
        </ul>
        
        
        
        <div class="margin-top-20">
        	<p class="_src text-left"><a href="http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=<?= $object->getData('pozycja') ?>&rok=<?= $object->getData('data_publikacji') ?>" target="_blank"><span class="glyphicon glyphicon-link"></span> Źródło</a></p>
    	</div>
        
    </div>
    
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
