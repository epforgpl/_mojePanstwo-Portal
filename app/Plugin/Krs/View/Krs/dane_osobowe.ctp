<?
echo $this->Html->css($this->Less->css('app'));
$this->Combinator->add_libs('js', 'app');

$displayAggs = isset($displayAggs) ? (boolean)$displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>
<style>
	#info ol {
		margin-left: 10px;
	}
	#info ol.lst-kix_3s51322ym4my-1 {
		margin-left: 50px;
	}
	#info ol li {
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>
<div class="app-content-wrap">
    <div class="objectsPage">
        
        <div class="dataBrowser upper margin-top-0">
		    <div class="container container-padding">
		        <div class="dataBrowserContent" id="info">

					<div class="col-xs-12">
					    <div class="appBanner playerMode">

					        <h1 class="appTitle">Krajowy Rejestr Sądowy</h1>
					        <p class="appSubtitle">Informacja o przetwarzaniu danych osobowych</p>
					        
					    </div>
					</div>
					
					<div class="block" style="padding: 30px; font-size: 15px; line-height: 23px;">
						
						<p class="c2 c10"><span class="c1 c13"></span></p>
    <p class="c11"><span class="c3 c1">Informacja dla os&oacute;b, kt&oacute;rych dane z publicznie dost&#281;pnych &#378;r&oacute;de&#322; tj. z Krajowego Rejestru S&#261;dowego oraz Monitora S&#261;dowego i Gospodarczego s&#261; udost&#281;pniane w portalu mojepanstwo.pl: </span></p>
    <p class="c11"><span class="c3 c1">Administratorem danych osobowych jest Fundacja ePa&#324;stwo z siedzib&#261; w Zgorzale przy ul. Pliszki 2B/1 05-500 Mysiad&#322;o. Twoje dane s&#261; przetwarzane w celu ich udost&#281;pniania w serwisach internetowych prowadzonych przez Fundacj&#281; dla wspierania pewno&#347;ci i jawno&#347;ci obrotu gospodarczego, w tym poprzez profilowanie. </span></p>
    <ol class="c6 lst-kix_3s51322ym4my-0 start" start="1">
        <li class="c2 c5"><span class="c1">Administratorem Twoich danych osobowych jest Fundacja ePa&#324;stwo z siedzib&#261; w Zgorzale przy ul. Pliszki 2B/1 05-500 Mysiad&#322;o (&bdquo;</span><span class="c9">Fundacja</span><span class="c3 c1">&rdquo;)</span></li>
        <li class="c2 c5"><span class="c1">Kontakt z Fundacj&#261; jest mo&#380;liwy poprzez adres email: </span><span class="c0">daneosobowe@mojepanstwo.pl</span><span class="c3 c1">&nbsp;lub pisemnie na adres do dor&#281;cze&#324; Fundacji tj. ul. Nowogrodzka 25/37 00-511 Warszawa.</span></li>
        <li class="c2 c5"><span class="c1">Twoje </span><span class="c3 c1">dane osobowe b&#281;d&#261; przetwarzane w celu:</span></li>
    </ol>
    <ol class="c6 lst-kix_3s51322ym4my-1 start" start="1">
        <li class="c2 c8"><span class="c1">ich udost&#281;pniania w serwisach internetowych prowadzonych przez Fundacj&#281; dla wspierania pewno&#347;ci i jawno&#347;ci obrotu gospodarczego, </span><span class="c1">z wykorzystaniem </span><span class="c1">profilowania</span><span class="c1">&nbsp;(patrz pkt 6 poni&#380;ej) &ndash; podstaw&#261; prawn&#261; jest prawnie uzasadniony interes Fundacji (art. 6 </span><span class="c1">ust</span><span class="c1">. 1 lit. f og&oacute;lnego rozporz&#261;dzenia o ochronie danych osobowych nr 2016/679 (&bdquo;</span><span class="c9">RODO</span><span class="c3 c1">&rdquo;), prawnie uzasadnionym interesem Fundacji jest udost&#281;pnianie danych osobowych w serwisach internetowych prowadzonych przez Fundacj&#281; dla wspierania pewno&#347;ci i jawno&#347;ci obrotu gospodarczego.</span></li>
        <li class="c8 c12"><span class="c3 c1">ewentualnego ustalenia i dochodzenia roszcze&#324; lub obrony przed nimi &ndash; podstaw&#261; prawn&#261; przetwarzania jest uzasadniony interes Administratora (art. 6 ust. 1 lit f RODO) polegaj&#261;cy na ochronie praw Administratora;</span></li>
    </ol>
    <ol class="c6 lst-kix_3s51322ym4my-0" start="4">
        <li class="c2 c5"><span class="c1">Fundacja</span><span class="c3 c0">&nbsp;pobiera dane osobowe ze &#378;r&oacute;de&#322; publicznie dost&#281;pnych tj. z Krajowego Rejestru S&#261;dowego oraz Monitora S&#261;dowego i Gospodarczego. </span></li>
        <li class="c2 c5"><span class="c1">Kategorie</span><span class="c0">&nbsp;danych osobowych przetwarzanych przez Fundacj&#281; s&#261; to&#380;same z kategoriami danych osobowych ujawnionych w Krajowym Rejestrze S&#261;dowym oraz Monitorze S&#261;dowym i Gospodarczym, w szczeg&oacute;lno&#347;ci stanowi&#261; je: </span><span class="c3 c0">imiona, nazwiska, data urodzenia, wiek, numer PESEL, informacje o funkcjach pe&#322;nionych przez osob&#281; w podmiocie wpisanym do Krajowego Rejestru S&#261;dowego, je&#347;li wyst&#281;puje: ilo&#347;&#263; i warto&#347;&#263; posiadanych udzia&#322;&oacute;w/akcji;</span></li>
        <li class="c2 c5"><span class="c3 c1">Profilowanie, o kt&oacute;rym mowa w pkt 3) powy&#380;ej, polega na automatycznej analizie numeru PESEL, w celu uzyskania informacji o roku urodzenia os&oacute;b, kt&oacute;rych dane s&#261; przetwarzane, co pozwala Administratorowi na wprowadzenie funkcjonalno&#347;ci wy&#347;wietlania roku urodzenia os&oacute;b o tych samych imionach i nazwiskach (dla ich rozr&oacute;&#380;nienia od innych, tak samo nazywaj&#261;cych si&#281; os&oacute;b, wyst&#281;puj&#261;cych w Krajowym Rejestrze S&#261;dowym);</span></li>
        <li class="c2 c5"><span class="c1">Twoje dane osobowe mog&#261; by&#263; przekazywane u&#380;ytkownikom serwis&oacute;w internetowych prowadzonych przez Fundacj&#281; oraz podmiotom &#347;wiadcz&#261;cym us&#322;ugi na rzecz Fundacji takim jak: dostawcy system&oacute;w informatycznych, dostawcy us&#322;ug IT</span><span class="c1">, podmioty &#347;wiadcz&#261;ce us&#322;ugi prawne.</span></li>
        <li class="c2 c5"><span class="c3 c1">Twoje dane osobowe b&#281;d&#261; przetwarzane przez okres trwania uzasadnionego interesu Administratora danych. Okres przetwarzania mo&#380;e zosta&#263; ka&#380;dorazowo przed&#322;u&#380;ony o okres przedawnienia roszcze&#324;, je&#380;eli przetwarzanie Twoich danych osobowych b&#281;dzie niezb&#281;dne dla ustalenia lub dochodzenia ewentualnych roszcze&#324; lub obrony przed takimi roszczeniami przez Fundacj&#281;. </span></li>
    </ol>
    <ol class="c6 lst-kix_egu429oomchd-0 start" start="9">
        <li class="c2 c5"><span class="c1 c3">Przys&#322;uguje Ci prawo dost&#281;pu do Twoich danych oraz prawo &#380;&#261;dania ich sprostowania, ich usuni&#281;cia lub ograniczenia ich przetwarzania oraz prawo do przenoszenia danych.</span></li>
        <li class="c2 c5"><span class="c3 c1">Przys&#322;uguje Ci prawo wniesienia skargi do organu nadzorczego zajmuj&#261;cego si&#281; ochron&#261; danych osobowych w pa&#324;stwie cz&#322;onkowskim Twojego zwyk&#322;ego pobytu, miejsca pracy lub miejsca pope&#322;nienia domniemanego naruszenia.</span></li>
        <li class="c2 c5"><span class="c3 c1">Przys&#322;uguje Ci ponadto prawo sprzeciwu wzgl&#281;dem przetwarzania danych osobowych, w tym wzgl&#281;dem profilowania. &nbsp;</span></li>
    </ol>
    <p class="c2"><span class="c3 c1">&nbsp;</span></p>


						
					</div>
					
		        </div>
		    </div>
        </div>
                
    </div>
</div>
