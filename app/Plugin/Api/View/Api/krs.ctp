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
					
					            <p class="appSubtitle">Krajowy Rejestr Sądowy &mdash; pobieraj dane o organizacjach zarejestrowanych w KRS</p>
					        </div>
					        					        
					        
					        <div class="row">
						        <div class="col-md-3">
							        
							        <div id="spy-menu" class="block block-simple nobg">
								        <header>Spis treści</header>
								        <section class="content nopadding">
									        
									        <ul class="nav nav-pills nav-stacked tos" role="tablist">
										        <li role="presentation"><a href="#przegladanie"><span class="glyphicon glyphicon-hand-right"></span> <span class="title">Przeglądanie listy organizacji</span></a></li>
										        <li role="presentation"><a href="#wyszukiwanie"><span class="glyphicon glyphicon-hand-right"></span> <span class="title">Wyszukiwanie organizacji przez filtry</span></a></li>
										        <li role="presentation"><a href="#informacje_o_organizacji"><span class="glyphicon glyphicon-hand-right"></span> <span class="title">Pobieranie informacji o organizacji</span></a></li>
									        </ul>
									        
								        </section>
							        </div>
							        
						        </div>
						        <div class="col-md-9">
							        
							        
							        
							        <div id="przegladanie" class="block block-simple">
								        <header>Przeglądanie organizacji</header>
								        <section class="content">
									        
									        <p>Aby pobrać listę organizacji, użyj adresu:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json</pre>
									        
									        <p>Aby nawigować w liście zwracanych wyników, możesz używać parametru <code>page</code>, np:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json?page=2</pre>
									        
									        <p>Domyślnie jedna strona wyników zawiera listę maksymalnie <code>50</code> elementów. Możesz regulować tę wartość, w zakresie do <code>1000</code>, używając parametru <code>limit</code>, np:</p>

									        <pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json?page=2&limit=100</pre>
									        
								        </section>
							        </div>
							        
							        
							        
							        <div id="wyszukiwanie" class="block block-simple">
								        <header>Wyszukiwanie organizacji</header>
								        <section class="content">
									        
									        <p>Możesz szukać organizacji stosując filtry - korzystając z paremetru <code>conditions</code>. Aby przeszukiwać pełnotekstowo według nazw organizacji, użyj parametru <code>conditions[q]</code>, np:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json?conditions[q]=Bank Millennium</pre>
									        
									        <p>Pozostałe filtry, które możesz stosować, to:</p>
									        
									        <ul class="layers">
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>krs</b>]</code></p>
										        	<p>Zwraca organizację o podanym numerze KRS.</p>
										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>nip</b>]</code></p>
										        	<p>Zwraca organizację o podanym numerze NIP.</p>
										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>regon</b>]</code></p>
										        	<p>Zwraca organizację o podanym numerze REGON.</p>
										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>forma_prawna_id</b>]</code></p>
										        	<p>Zwraca listę organizacji o określonej formie prawnej. Lista form prawnych jest dostępna pod adresem: </p>
    										        <pre>https://api-v3.mojepanstwo.pl/dane/krs_formy_prawne.json</pre>

										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>forma_prawna_typ_id</b>]</code></p>
										        	<p>Zwraca listę organizacji o określonym typie formy prawnej. Dozwolone wartości to:</p>
										        	<ul class="layers">
												        <li>
												        	<p><code>1</code> &mdash; Organizacje biznesowe</p>
												        	<p><code>2</code> &mdash; Organizacje pozarządowe</p>
												        	<p><code>3</code> &mdash; Samodzielne publiczne zakłady opieki zdrowotnej</p>
												        </li>
										        	</ul>
										        </li>
										        <li>
										        	<p><code>conditions[<b>date</b>]</code></p>
										        	<p>Zwraca listę organizacji zarejestrowanych w podanym dniu lub przedziale. Przykłady:</p>
										        	<ul class="layers">
												        <li>
												        	<p><pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json?conditions[date]=2016-05-23</pre></p>
												        	<p>Zwraca listę organizacji zarejestrowanych 23 maja 2016 r.</p>
												        </li>
												        <li>
												        	<p><pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json?conditions[date]=[2016-01-01 TO 2016-01-31]</pre></p>
												        	<p>Zwraca listę organizacji zarejestrowanych w styczniu 2016 r.</p>
												        </li>
												        <li>
												        	<p><pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty.json?conditions[date]=[2016-01-01 TO *]</pre></p>
												        	<p>Zwraca listę organizacji zarejestrowanych w 2016 r.</p>
												        </li>
										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>gmina_id</b>]</code></p>
										        	<p>Zwraca listę organizacji zarejestrowanych w danej gminie. Listę gmin możesz pobrać pod adresem:</p>
    										        <pre>https://api-v3.mojepanstwo.pl/dane/gminy.json</pre>

										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>powiat_id</b>]</code></p>
										        	<p>Zwraca listę organizacji zarejestrowanych w danym powiecie. Listę powiatów możesz pobrać pod adresem:</p>
    										        <pre>https://api-v3.mojepanstwo.pl/dane/powiaty.json</pre>
										        </li>
										        <li>
										        	<p><code>conditions[krs_podmioty.<b>wojewodztwo_id</b>]</code></p>
										        	<p>Zwraca listę organizacji zarejestrowanych w danym województwie. Listę województw możesz pobrać pod adresem:</p>
    										        <pre>https://api-v3.mojepanstwo.pl/dane/województw.json</pre>
										        </li>
									        </ul>

									        <p>Tylko wyszukiwanie przez parametr <code>conditions[q]</code> działa w trybie pełnotekstowym. Pozostałe parametry działają w trybie porównań prostych. Wszystkie filtry mogą być stosowane łącznie.</p>
									        
								        </section>
							        </div>
							        
							        
							        
							        <div id="informacje_o_organizacji" class="block block-simple">
								        <header>Pobieranie informacji o organizacji</header>
								        <section class="content">
									        
									        <p>Znając <code>id</code> organizacji, możesz pobrać więcej informacji o niej, pod adresem:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty/{$id}.json</pre>
									        
									        <p>Dla każdej organizacji, można pobierać także dodatkowe informacje korzystając z mechanizmu warstw, np:</p>
									        
									        <pre>https://api-v3.mojepanstwo.pl/dane/krs_podmioty/10186.json?layers[]=dzialalnosci&layers[]=reprezentacja</pre>
									        
									        <p>Wszystkie dostępne warstwy to:</p>
									        
									        <ul class="layers">
										        <li>
										        	<p><code>dzialalnosci</code></p>
										        	<p>Zwraca listę działalności według PKD, które zarejestrowała organizacja</p>
										        </li>
										        <li>
										        	<p><code>emisje_akcji</code></p>
										        	<p>Zwraca listę emisji akcji dla organizacji.</p>
										        </li>
										        <li>
										        	<p><code>firmy</code></p>
										        	<p>Zwraca listę firm, w których organizacja ma udziały wraz z informacjami o liczbie i wartości tych udziałów.</p>
										        </li>
										        <li>
										        	<p><code>graph</code></p>
										        	<p>Zwraca listę powiązanych osób i organizacji w formie przyjaznej do tworzenia wykresów powiązań.</p>
										        </li>
										        <li>
										        	<p><code>jedynyAkcjonariusz</code></p>
										        	<p>Zwraca listę osób zarejestrowanych jako jedyni akcjonariusze organizacji.</p>
										        </li>
										        <li>
										        	<p><code>komitetZalozycielski</code></p>
										        	<p>Zwraca listę osób stanowiących komitet założycielski organizacji.</p>
										        </li>
										        <li>
										        	<p><code>nadzor</code></p>
										        	<p>Zwraca listę osób stanowiących organ nadzoru organizacji.</p>
										        </li>
										        <li>
										        	<p><code>oddzialy</code></p>
										        	<p>Zwraca listę oddziałów organizacji.</p>
										        </li>
										        <li>
										        	<p><code>prokurenci</code></p>
										        	<p>Zwraca listę prokurentów organizacji</p>
										        </li>
										        <li>
										        	<p><code>reprezentacja</code></p>
										        	<p>Zwraca listę osób stanowiących organ reprezentacji organizacji.</p>
										        </li>
										        <li>
										        	<p><code>wspolnicy</code></p>
										        	<p>Zwraca listę wspólników organizacji.</p>
										        </li>
									        </ul>
									        
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
