<?
	
	$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('css', $this->Less->css('mapa', array('plugin' => 'Mapa')));
	
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	$this->Combinator->add_libs('js', 'Mapa.mapa');
	
	switch (Configure::read('Config.language')) {
	    case 'pol':
	        $lang = "pl-PL";
	        break;
	    case 'eng':
	        $lang = "en-EN";
	        break;
	};
	echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
	echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));
	?>
	<div class="objectsPage">
	    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
	        <div class="searcher-app">
	            <div class="container">
	                <div class="row">
		                <? if( isset($widget) ) {?>
		                <div class="col-xs-12 widget-localize">
		                
		                	<p class="text-center">
			                	<a href="/mapa/miejsce/253272?n=25&widget" class="btn btn-primary btn-icon auto-width"><i class="icon" data-icon="&#xe800;"></i>Zlokalizuj się</a> <span class="txt">lub znajdź swój adres:</span>
		                	</p>
		                
		                </div>
		                <div class="col-sm-6 col-sm-offset-3">
		                <? } else { ?>
		                <div class="col-xs-12">
		                <? } ?>
	                	
		                	
		                <?
			            	
			            	$_params = array(
				            	'dataBrowser' => array(
			                        'autocompletion' => array(
				                        'dataset' => 'miejsca',
			                        ),
			                        'searchTitle' => 'Szukaj adresu, miejscowości lub kodu pocztowego...',
			                        'searchAction' => '/mapa',
			                    ),
			            	);
			            	
			            	if( !isset($widget) )
				            	$_params['dataBrowser']['searchTag'] = array(
					            	'href' => '/mapa',
		                            'label' => 'Mapa',
				            	);
			            	
				            echo $this->element('Dane.DataBrowser/browser-searcher', $_params);
		                
		                ?>
		                
	                	</div>
	                </div>
	            </div>
	        </div>
	
	        <? if( !isset($widget) && isset($app_menu) ) { ?>
	            <div class="apps-menu">
	                <div class="container">
	                    <ul>
	                        <? foreach ($app_menu[0] as $a) { ?>
	                            <li>
	                                <a<? if (isset($a['active']) && $a['active']) { ?> class="active"<? } ?>
	                                    href="<?= $a['href'] ?>"><?= $a['title'] ?></a>
	                            </li>
	                        <? } ?>
	                    </ul>
	                </div>
	            </div>
	        <? } ?>
	
	        <div class="container">
	            <div id="stage" class="row dataBrowserContent<? if( isset($widget) ) {?> hide<? } ?>">
	                <div id="mapa"></div>
	                <div id="localizeMe" class="btn btn-default btn-sm">
	                    <span class="glyphicon glyphicon-screenshot"></span>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
