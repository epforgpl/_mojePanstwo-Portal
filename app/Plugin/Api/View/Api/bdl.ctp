<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$this->Html->css(array(
    // '/api/swagger/css/typography',
    '/api/swagger/css/reset',
    '/api/swagger/css/screen',
), array('inline' => 'false', 'block' => 'cssBlock', 'media' => 'screen'));

$this->Html->css(array(
    '/api/swagger/css/reset',
    '/api/swagger/css/print',
), array('inline' => 'false', 'block' => 'cssBlock', 'media' => 'print'));

$this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api')));

$this->Html->script(array(
    '/api/swagger/lib/jquery.slideto.min',
    '/api/swagger/lib/jquery.wiggle.min',
    '/api/swagger/lib/handlebars-2.0.0',
    '/api/swagger/lib/underscore-min',
    '/api/swagger/lib/backbone-min',
    '/api/swagger/lib/marked',
    // enabling this will enable oauth2 implicit scope support
    // '/api/swagger/lib/swagger-oauth',
    '/api/swagger/swagger-ui.min',
    // '/api/swagger/lib/highlight.7.3.pack',

), array('inline' => 'false', 'block' => 'scriptBlock'));

$this->Html->scriptBlock('window.swaggerUi = new SwaggerUi({url: "' . API_url . '/swagger-bdl.json", uiRoot: "/api/",docExpansion: "list"});window.swaggerUi.load();',
    array('inline' => 'false', 'block' => 'scriptBlock'));

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
					
					            <p class="appSubtitle">Bank Danych Lokalnych</p>
					        </div>
					        					        
					        <div class="block margin-top-20">
						        <header class="">Dokumentacja żądań</header>
						        <section class="textBlock">
							        						        
							        <div class="newLayout">
	
				                        <div class="swagger-section row">
				                            <div id="message-bar" class="swagger-ui-wrap col-md-12">&nbsp;</div>
				                            <div id="swagger_ui" class="swagger-ui-wrap col-md-12"></div>
				                        </div>
				                        
					                </div>
					               
						        </section>
					        </div>
					        
					        <p class="text-center">Bank danych lokalnych jest skomplikowaną strukturą danych, jednak dostęp do niej można podzielić na cztery proste kroki:</p> 				        				        
					        
					        <div class="block margin-top-20">
						        <header class="">Wybór wskaźnika [metric_id]</header>
						        
						        <section class="textBlock">
							        <p>Skorzystaj z wyszukiwarki <em>/bdl/search</em>, aby znaleźć interesujący cię wskaźnik. Wskaźniki pogrupowane są w grupy oraz kategorie.</p>
						
						            <p>
						                Przykład: <a href="http://api-v3.mojepanstwo.pl/bdl/search?q=bezrobotni">Wyszukaj statystyki dotyczące
						                    bezrobotnych</a><br/>
						                Interesuje nas wskaźnik "Bezrobotni zarejestrowani wg poziomu wykształcenia i płci",
						                którego szczegóły możemy zobaczyć <a href="http://api-v3.mojepanstwo.pl/dane/bdl_wskazniki/762">pod tym
						                    adresem</a> wskazanym przez pole <em>url</em>.
						            </p>
						        </section>
					        </div>
					        
					        <div class="block margin-top-20">
						        <header class="">Wybór przekroju [slice]</header>
						        
						        <section class="textBlock">
							        
							        <p>Każdy wskaźnik składa się z n-wymiarowego hipersześcianu opisanego przez warstwę <em>dimensions</em> (<a
						                    href="http://api-v3.mojepanstwo.pl/dane/bdl_wskazniki/762?layers=dimennsions">przykład</a>).
						                Konkretny przekrój to zbiór n-identyfikatorów z każdego wymiaru. Zapytanie <em>series</em> zwraca
						                szeregi
						                czasowe dla każdego przekroju, o który pytamy (dla wszystkich jeżeli brak przekroju podanego).
						            </p>
						            <ul>
						                <li>Przykład: <a href="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762">Wszystkie przekroje</a>
						                </li>
						                <li>Przykład: <a href="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]">Bezrobotni
						                        mężczyźni z wyższym wykształceniem</a></li>
						                <li>Przykład: <a href="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,*]">Bezrobotni
						                        mężczyźni i kobiety z wyższym wykształceniem</a></li>
						            </ul>
							        
						        </section>
					        </div>
					        
					        <div class="block margin-top-20">
						        <header class="">Wybór szczegółowości danych wg. rejonu [wojewodztwo_id,powiat_id,gmina_id]</header>
						        
						        <section class="textBlock">
							        
							        <p>Podaj <em>id</em> konkretnego regionu lub <em>*</em>, aby otrzymać dane ze wszystkich regionów na danym
						                poziomie. Pomiń parametry, aby zwrócić dane na poziomie kraju. W pojedynczym zapytaniu można zwrócić
						                dane tylko na jednym poziomie.
						                Szczegółowość danych dla danego wskaźnika określona jest przez parametry
						                <em>bdl_wskazniki.poziom_id</em> i <em>bdl_wskazniki.poziom_str"</em>.
						            </p>
						            <ul>
						                <li>Przykład: <a href="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]">Dane na
						                        poziomie kraju</a></li>
						                <li>Przykład: <a
						                        href="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]&wojewodztwo_id=*">Dane
						                        dla wszystkich województw</a></li>
						                <li>Przykład: <a
						                        href="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]&powiat_id=2">Powiat
						                        augustowski</a></li>
						            </ul>
							        
						        </section>
					        </div>
					        
					        <div class="block margin-top-20">
						        <header class="">Wybór okresu czasu [time_range]</header>
						        
						        <section class="textBlock">
							        
							        <p>Na razie udostępniamy wyłącznie dane roczne. Każdy zwracany szereg czasowy może zostać obcięty do
						                określonego
						                przedziału poprzez podanie parametru <em>time_range=rok_poczatkowy:rok_koncowy</em> (włącznie).
						            </p>
						            <ul>
						                <li>Przykład: <a
						                        hreg="http://api-v3.mojepanstwo.pl/bdl/series?metric_id=762&slice=[5479,1713]&time_range=2001:2002">Bezrobotni
						                        w latach 2001:2002</a></li>
						            </ul>
						            
						            <p>Użyj powyższych parametrów na endpoint <em>/series</em>, aby zwrócić dane.</p>
							        
						        </section>
					        </div>
					        
					        					
						        				        
					        
					
					</div>
	
			    </div>
			</div>
	
		</div>
	</div>
</div>
