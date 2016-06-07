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
					
					            <p class="appSubtitle">Sejmometr &mdash; pobieraj dane o pracy Sejmu RP</p>
					        </div>
					        					        
					        
					        <div class="row">
						        <div class="col-md-3">
							        
							        <div id="spy-menu" class="block block-simple nobg">
								        <header>Spis treści</header>
								        <section class="content nopadding">
									        
									        <ul class="nav nav-pills nav-stacked tos" role="tablist">
										        <li role="presentation"><a href="#gminy"><span class="glyphicon glyphicon-hand-right"></span> <span class="title">Finanse gmin</span></a></li>
										        
									        </ul>
									        
								        </section>
							        </div>
							        
						        </div>
						        <div class="col-md-9">
							        
							        
							        <div id="gminy" class="block block-simple">
								        <header>Pobieranie informacji o finansach gminy</header>
								        <section class="content">
									        
									        <p>Znając <code>id</code> posła, możesz pobrać więcej informacji o nim, pod adresem:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/poslowie/{$id}.json</pre>
									        
									        <p>Dla każdego posła, można pobierać także dodatkowe informacje korzystając z mechanizmu warstw, np:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/poslowie/174.json?layers[]=krs&layers[]=wydatki</pre>
									        
									        <p>Wszystkie dostępne warstwy to:</p>
									        
									        <ul class="layers">
										        <li>
										        	<p><code>krs</code></p>
										        	<p>Zwraca listę organizacji z rejestru KRS, z którymi powiązany jest poseł.</p>
										        </li>
										        <li>
										        	<p><code>biura</code></p>
										        	<p>Zwraca listę biur poselskich, prowadzonych przez posła.</p>
										        </li>
										        <li>
										        	<p><code>wyjazdy</code></p>
										        	<p>Zwraca listę wyjazdów służbowych posła.</p>
										        </li>
										        <li>
										        	<p><code>wydatki</code></p>
										        	<p>Zwraca listę wydatków służbowych posła.</p>
										        </li>
									        </ul>
									        
								        </section>
							        </div>
							        
							        
							        
							        <div id="posiedzenia_sejmu" class="block block-simple">
								        <header>Pobieranie listy posiedzeń Sejmu</header>
								        <section class="content">
									        
									        <p>Aby pobrać listę wszystkich posiedzeń Sejmu VII i VIII kadencji, użyj adresu:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_posiedzenia.json</pre>
									        
									        <p>Aby pobrać listę tylko posiedzeń VIII kadencji, możesz zastosować następujący filtr:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_posiedzenia.json?conditions[sejm_posiedzenia.kadencja]=8</pre>
									        
								        </section>
							        </div>
							        
							        
							        
							        <div id="dni_posiedzen_sejmu" class="block block-simple">
								        <header>Pobieranie listy dni posiedzeń sejmowych</header>
								        <section class="content">
									        
									        <p>Aby pobrać listę wszystkich dni, w których odbywały się posiedzenia Sejmu VII i VIII kadencji, użyj adresu:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_posiedzenia_dni.json</pre>
									        
									        <p>Aby pobrać listę tylko dni posiedzeń VIII kadencji, możesz zastosować następujący filtr:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_posiedzenia_dni.json?conditions[sejm_posiedzenia.kadencja]=8</pre>
									        
									        <p>Aby pobrać listę dni dla konkretnego posiedzenia, dla którego znasz <code>id</code>, użyj filtra:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_posiedzenia_dni.json?conditions[sejm_posiedzenia_dni.posiedzenie_id]=125</pre>
									        
								        </section>
							        </div>
							        
							        
							        
							        <div id="wystapienia_sejmowe" class="block block-simple">
								        <header>Pobieranie wystąpień sejmowych</header>
								        <section class="content">
									        
									        <p>Aby pobrać listę wszystkich wystąpień w Sejmie VII i VIII kadencji, użyj adresu:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_wystapienia.json</pre>
									        
									        <p>Aby pobrać listę tylko dni wystąpień z VIII kadencji, możesz zastosować następujący filtr:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_wystapienia.json?conditions[sejm_wystapienia.kadencja]=8</pre>
									        
									        <p>Aby pobrać listę wystąpień wygłoszonych podczas konkretnego posiedzenia, dla którego znasz <code>id</code>, użyj filtra:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_wystapienia.json?conditions[sejm_wystapienia.posiedzenie_id]=125</pre>
									        
									        <p>Aby pobrać listę wystąpień wygłoszonych podczas konkretnego dnia posiedzenia, dla którego znasz <code>id</code>, użyj filtra:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_wystapienia.json?conditions[sejm_wystapienia.dzien_sejmowy_id]=1134706</pre>
									        
								        </section>
							        </div>
							        
							        
							        
							        <div id="wystapienie_sejmowe_tresc" class="block block-simple">
								        <header>Pobieranie pełnych treści wystąpień sejmowych</header>
								        <section class="content">
									        
									        <p>Pobierając listę wystąpień sejmowych, otrzymujesz jedynie skróty treści tych wystąpień. Aby pobrać pełną treść wystąpienia, dla którego znasz <code>id</code>, użyj adresu:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/sejm_wystapienia.json?conditions[sejm_posiedzenia_dni.posiedzenie_id]=125?layers[]=html</pre>
									        
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
