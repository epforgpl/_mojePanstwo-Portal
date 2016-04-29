<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api')));


echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
	<div class="objectsPage">
		<div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
						
			<div class="container">
	            <div class="dataBrowserContent">
						
					<div class="col-xs-12 col-sm-8 col-md-4-5">
					
					        
					        <div class="appBanner bottom-border">
					            <h1 class="appTitle">API</h1>
					
					            <p class="appSubtitle">Sejmometr</p>
					        </div>
					        					        
					        
					        <div class="row">
						        <div class="col-md-4">
							        
							        <div class="block bgA">
								        <header>Spis treści</header>
								        <section class="content">
									        
									        <ul class="tos">
										        <li><a href="#pobieranie_listy_poslow">Pobieranie listy posłów</a></li>
										        <li><a href="#pobieranie_informacji_o_posle">Pobieranie informacji o pośle</a></li>
									        </ul>
									        
								        </section>
							        </div>
							        
						        </div>
						        <div class="col-md-8">
							        
							        <div id="pobieranie_listy_poslow" class="block">
								        <header>Pobieranie listy posłów</header>
								        <section class="content">
									        
									        <p>asd</p>
									        
								        </section>
							        </div>
							        
							        <div id="pobieranie_informacji_o_posle" class="block">
								        <header>Pobieranie informacji o pośle</header>
								        <section class="content">
									        
									        <p>asd</p>
									        
								        </section>
							        </div>
							        
						        </div>
					        </div>			        					
						        				        
					        
					
					</div>
	
			    </div>
			</div>
	
		</div>
	</div>
</div>
