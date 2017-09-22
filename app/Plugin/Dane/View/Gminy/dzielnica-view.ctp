<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}


$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-dzielnica', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Dane.view-gminy-dzielnica.js');


echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));


echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $dzielnica,
    'objectOptions' => array(
        'bigTitle' => true,
        'hlFields' => array(),
    )
));
?>

<div class="dataBrowser margin-top--5">
    <div class="dataBrowserContent">
	    <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
				<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
				
	                <? if (isset($_submenu) && isset($_submenu['items'])) {
	
	                    if (!isset($_submenu['base']))
	                        $_submenu['base'] = $dzielnica->getUrl();
	
	                    echo $this->Element('Dane.DataBrowser/browser-menu', array(
	                        'menu' => $_submenu,
	                    ));
	
	                } ?>
	                
	                <?
			        $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
			        $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
			        $this->Combinator->add_libs('js', 'Pisma.pisma-button');
			        echo $this->element('tools/pismo', array(
			            'label' => '<strong>Wyślij pismo</strong> do Rady Dzielnicy',
			            'adresat' => 'dzielnice:' . $dzielnica->getId(),
			        ));
			        ?>
	                
				</div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
	            
	            <div class="dataWrap">
	                
		           
		            <div class="row">
					    <div class="col-sm-9">
					        <div class="databrowser-panels">
				
					            <? if ($object->getId() == 903) { ?>
									
									<? /*
									<div class="databrowser-panel margin-top-10">
										<? if(!empty($cadences)) { ?>
											<form action="" method="get">
												<select
													class="form-control"
													name="<?= $cadences['param'] ?>"
													onchange="this.form.submit()">
													<? foreach($cadences['items'] as $key => $item) { ?>
														<? $active = $cadences['selected'] == $key; ?>
														<option value="<?= $key ?>"<?= $active ? "selected" : '' ?>>
															<?= $item['label'] ?>
														</option>
													<? } ?>
												</select>
											</form>
										<? } ?>
									</div>
									*/ ?>
				
					                <div class="databrowser-panel margin-top-20">
					                    <h2>Najnowsze posiedzenia rady dzielnicy:</h2>
				
					                    <div class="aggs-init">
				
					                        <div class="dataAggs">
					                            <div class="agg agg-Dataobjects">
					                                <? if ($dataBrowser['aggs']['posiedzenia']['top']['hits']['hits']) { ?>
					                                    <ul class="dataobjects">
					                                        <? foreach ($dataBrowser['aggs']['posiedzenia']['top']['hits']['hits'] as $doc) { ?>
					                                            <li>
					                                                <?
					                                                echo $this->Dataobject->render($doc, 'default');
					                                                ?>
					                                            </li>
					                                        <? } ?>
					                                    </ul>
					                                    <div class="buttons">
					                                        <a href="<?= $dzielnica->getUrl() ?>/rada_posiedzenia" class="btn btn-primary btn-xs">Zobacz
					                                            więcej</a>
					                                    </div>
					                                <? } ?>
				
					                            </div>
					                        </div>
				
				
					                    </div>
					                </div>
				
					                <div class="databrowser-panel">
					                    <h2>Radni dzielnicy:</h2>
				
					                    <div class="aggs-init">
				
					                        <div class="dataAggs">
					                            <div class="agg agg-Dataobjects">
					                                <? if ($dataBrowser['aggs']['radni']['top']['hits']['hits']) { ?>
					                                    <ul class="dataobjects row radni_dzielnic">
					                                        <? foreach ($dataBrowser['aggs']['radni']['top']['hits']['hits'] as $doc) { ?>
					                                            <li class="col-md-6<? if(@$doc['fields']['source'][0]['data']['radni_dzielnic.avatar']) {?> avatar<?}?>">
					                                                <?
					                                                echo $this->Dataobject->render($doc, 'default');
					                                                ?>
					                                            </li>
					                                        <? } ?>
					                                    </ul>
					                                <? } ?>
				
					                            </div>
					                        </div>
				
				
					                    </div>
					                </div>
				
				
				
					            <? } ?>
				
					        </div>
				
					    </div><div class="col-sm-3">
							
							<div class="margin-top-20">
							
								<? if( $info = $dzielnica->getLayer('info') ) { ?>
								<ul class="dataHighlights show overflow-auto">
					                <li class="dataHighlight col-xs-12">
							            <p class="_label">Liczba mieszkańców:</p>
							            <p class="_value"><?= $info['liczba_mieszkancow'] ?></p>
							        </li>
							        <li class="dataHighlight col-xs-12">
							            <p class="_label">Powierzchnia:</p>
							            <p class="_value"><?= $info['liczba_powierzchnia'] ?> km<sup>2</sup></p>
							        </li>
							        <li class="dataHighlight col-xs-12">
							            <p class="_label">Gęstość zaludnienia:</p>
							            <p class="_value"><?= $info['liczba_gestosc_zaludnienia'] ?> os./km<sup>2</sup></p>
							        </li>
							        <li class="dataHighlight col-xs-12">
							            <p class="_label">Frekwencja w wyborach samorządowych:
							            <p class="_value"><?= $info['liczba_frekwencja'] ?>%</p>
							        </li>
							        <li class="dataHighlight col-xs-12">
							            <p class="_label">Wikipedia:
							            <p class="_value"><a target="_blank" href="<?= $info['url_wiki'] ?>">Link</a></p>
							        </li>
								</ul>
								<? } ?>
					
								<? if(isset($dataBrowser['aggs']['radni']['top']['hits']['hits'])) {
					
									$radni = $dataBrowser['aggs']['radni']['top']['hits']['hits'];
									$pie_chart_data = array();
									foreach($radni as $radny) {
										if(isset($radny['fields']['source'][0]['data']['radni_dzielnic.partia_wspierany_przez'])) {
											$key = $radny['fields']['source'][0]['data']['radni_dzielnic.partia_wspierany_przez'];
											if(isset($pie_chart_data[$key])) {
												$pie_chart_data[$key]++;
											} else
												$pie_chart_data[$key] = 1;
										}
									}
					
									if(isset($pie_chart_data[''])) {
										$pie_chart_data['Brak'] = $pie_chart_data[''];
										unset($pie_chart_data['']);
									}
					
									if(isset($pie_chart_data['-'])) {
										if(isset($pie_chart_data['Brak'])) {
											$pie_chart_data['Brak'] += $pie_chart_data['-'];
										} else
											$pie_chart_data['Brak'] = $pie_chart_data['-'];
										unset($pie_chart_data['-']);
									}
					
									$open_data = array(
										array(
											'field' => 'radni_dzielnic.email',
											'label' => 'Adres e-mail',
											'count' => 0
										),
										array(
											'field' => 'radni_dzielnic.tel',
											'label' => 'Telefon',
											'count' => 0
										),
										array(
											'field' => 'radni_dzielnic.www',
											'label' => 'Strona www',
											'count' => 0
										),
										'max' => count($radni)
									);
					
					
									foreach($open_data as $o => $od) {
										if(!isset($od['count'])) continue;
										foreach($radni as $radny) {
											$f = @$radny['fields']['source'][0]['data'][$od['field']];
											if($f != '' && $f != '-') {
												$open_data[$o]['count']++;
											}
										}
									}
					
									if(count($pie_chart_data)) { ?>
					
										<h2>Popracie dla radnych:</h2>
					
										<div style="margin-top:-30px;" class="poparcieRadnychPieChart" data-aggs="<?= htmlspecialchars(json_encode($pie_chart_data)) ?>"></div>
					
									<? } ?>
					
									<? if(count($open_data)) { ?>
					
										<h2 class="margin-top-20">
											Dostępność radnych
										</h2>
					
										<p class="help-block">
											Dane kontaktowe udostępniane przez radnych określające ich dostępność do mieszkańców
										</p>
					
										<ul class="dataHighlights show overflow-auto margin-top-5">
											<? foreach($open_data as $od) { if(!isset($od['count'])) continue; ?>
												<li class="dataHighlight col-xs-12">
													<p class="_label"><?= $od['label'] ?>:</p>
													<p class="_value"><?= $od['count'] ?>/<?= $open_data['max'] ?></p>
												</li>
											<? } ?>
										</ul>
					
									<? } ?>
					
								<? } ?>
										        
					        </div>
				
					    </div>
					</div>
				
				</div>
	                
	                
            </div>
        </div>
    </div>
</div>

<?
echo $this->Element('dataobject/pageEnd', array(
    'titleTag' => 'p',
));
?>
