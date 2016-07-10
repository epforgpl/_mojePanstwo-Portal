<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Api.api.js');

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
					
					        
					        <div class="appBanner">
					            <h1 class="appTitle">API</h1>
					
					            <p class="appSubtitle">Zamówienia publiczne</p>
					        </div>
					        					        
					        
					        <div class="row">
						        <div class="col-md-3">
							        
							        <div id="spy-menu" class="block block-simple nobg">
								        <header>Spis treści</header>
								        <section class="content nopadding">
									        
									        <ul class="nav nav-pills nav-stacked tos" role="tablist">
										        <li role="presentation"><a href="#przegladanie"><span class="glyphicon glyphicon-hand-right"></span> <span class="title">Przeglądanie listy zamówień</span></a></li>
										        <li role="presentation"><a href="#informacje_o_zamowieniu"><span class="glyphicon glyphicon-hand-right"></span> <span class="title">Pobieranie informacji o zamóweniu</span></a></li>
									        </ul>
									        
								        </section>
							        </div>
							        
						        </div>
						        <div class="col-md-9">
							        
							        
							        
							        <div id="przegladanie" class="block block-simple">
								        <header>Przeglądanie listy zamówień publicznych</header>
								        <section class="content">
									        
									        <p>Aby pobrać listę zamówień publicznych, użyj adresu:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne.json</pre>
									        
									        <p>Aby nawigować w liście zwracanych wyników, możesz używać parametru <code>page</code>, np:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne.json?page=2</pre>
									        
									        <p>Domyślnie jedna strona wyników zawiera listę maksymalnie <code>50</code> elementów. Możesz regulować tę wartość, w zakresie do <code>1000</code>, używając parametru <code>limit</code>, np:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne.json?page=2&limit=100</pre>
									        
								        </section>
							        </div>
							        
							        
							        
							        							        
							        
							        
							        <div id="informacje_o_zamowieniu" class="block block-simple">
								        <header>Pobieranie informacji o konkretnym zamówieniu</header>
								        <section class="content">
									        
									        <p>Znając <code>id</code> zamówienia, możesz pobrać więcej informacji o nim, pod adresem:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne/{$id}.json</pre>
									        
									        <p>Aby pobrać także informacje o wybranych wykonawcach i kryteriach wyboru wykonawcy, które stosował zamawiający, użyj adresu:
										        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne/{$id}.json?fields[]=zamowienia_publiczne-wykonawcy&fields[]=zamowienia_publiczne-kryteria</pre>
									        
									        <p>Każde zamówienie publiczne składa się z jednego lub wielu dokumentów. W tych dokumentach ogłaszane są zamówienia, zmiany w ogłoszeniach, a także informacje o wyborze wykonawcy. Aby pobrać listę dokumentów dla zamówienia, którego <code>id</code> znamy należy użyć adresu:</p>
									       									        
									        
									        									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne_dokumenty.json?conditions[zamowienia_publiczne_dokumenty.parent_id]=$id</pre>
									        
									        <p>Na przykład dla zamówienia o <code>id=2255666</code>, możemy pobrać jego podstawowe informacje:</code>
										        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne/2255666.json?fields[]=zamowienia_publiczne-wykonawcy&fields[]=zamowienia_publiczne-kryteria</pre>
									        
									        <p>Możemy także pobrać informacje o wszystkich dokumentach, wchodzących w skład tego zamówienia:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne_dokumenty.json?conditions[zamowienia_publiczne_dokumenty.parent_id]=2255666&order[]=date asc</pre>
									        
									        <p>Dokumenty otrzymane w ten sposób zawieraja pole <code>typ_id</code>, które może przybierając następujące wartości:</p>
									        
									        <ul class="layers">
										        <li>
										        	<p><code>1</code> &mdash; Ogłoszenie zamówienia</p>
										        	<p><code>2</code> &mdash; Uproszczone ogłoszenie</p>
										        	<p><code>3</code> &mdash; Udzielenie zamówienia</p>
										        	<p><code>4</code> &mdash; Ogłoszenie konkursu</p>
										        	<p><code>5</code> &mdash; Ogłoszenie wyników konkursu</p>
										        	<p><code>6</code> &mdash; Zmiana ogłoszenia</p>
										        	<p><code>7</code> &mdash; Zamiar zawarcia umowy</p>
										        </li>
								        	</ul>
								        	

								        	
								        	
								        	<p>Aby pobrać listę dokumentów, wchodzących w skład danego zamówienia wraz z polami, zawierającymi dokładne informacje tekstowe podane przez zamawiającego, a także listę otrzymanych ofert, użyj dodatkowego parametru <code>fields[]=details</code>:
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/zamowienia_publiczne_dokumenty.json?conditions[zamowienia_publiczne_dokumenty.parent_id]=2255666&order[]=date asc&fields[]=details</pre>

							        
									        
									        
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
