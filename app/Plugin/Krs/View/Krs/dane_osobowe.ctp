<?
echo $this->Html->css($this->Less->css('app'));
$this->Combinator->add_libs('js', 'app');

$displayAggs = isset($displayAggs) ? (boolean)$displayAggs : true;
$columns = isset($columns) ? $columns : array(9, 3);

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>
<div class="app-content-wrap">
    <div class="objectsPage">
        
        <div class="dataBrowser upper margin-top-0">
		    <div class="container container-padding">
		        <div class="dataBrowserContent">

					<div class="col-xs-12">
					    <div class="appBanner playerMode">

					        <h1 class="appTitle">Krajowy Rejestr Sądowy</h1>
					        <p class="appSubtitle">Informacja o przetwarzaniu danych osobowych</p>
					        
					    </div>
					</div>
					
					<div class="block" style="padding: 30px; font-size: 15px; line-height: 23px;">
						
						<p><span>Zgodnie z treścią art. 25 ust. 1 ustawy z dnia 29 sierpnia 1997 roku o ochronie danych osobowych </span><span>(Dz. U. 1997 Nr 133 poz. 883)</span><span>, Fundacja ePaństwo jako wydawca portalu </span><span><a href="https://mojepanstwo.pl">mojePaństwo</a></span><span>&nbsp;informuje, że: </span></p>
<p><span></span></p>
<ol>
   <li style="margin-bottom: 10px;"><span>Administratorem danych osobowych przetwarzanych w ramach portalu </span><span><a href="https://mojepanstwo.pl">mojePaństwo</a></span><span>&nbsp;w aplikacji </span><span><a href="https://mojepanstwo.pl/krs">Krajowy Rejestr Sądowy</a></span><span>&nbsp;jest Fundacja ePaństwo z siedzibą w Zgorzale ul. Pliszki 2B/1 05-500 Mysiadło (KRS: 0000359730), zwana dalej Fundacją. </span></li>
   <li><span>Dane osobowe zawarte w aplikacji Krajowy Rejestr Sądowy są przetwarzane w celu </span><span>wspierania jawności i pewności obrotu gospodarczego, poprzez</span><span>&nbsp;prowadzenie przez Fundację</span><span>&nbsp;</span><span>niekomercyjnej działalności</span><span>&nbsp;</span><span>polegającej na: </span>
   
   	  <ul type="disc">
	   <li><span>udostępnianiu informacji pochodzących z Krajowego Rejestru Sądowego oraz z Monitora Sądowego i Gospodarczego tj. informacji o podmiotach gospodarczych i społecznych, informacji o osobach pełniących funkcje w tych podmiotach.</span></li>
	   <li><span>udostępnianiu do pobrania informacji odpowiadającej odpisom z Krajowego Rejestru Sądowego.</span></li>
	  </ul>
   
   </li>

   <li style="margin-bottom: 10px;"><span>Zakres danych osobowych przetwarzanych przez Fundację obejmuje: </span><span>imiona, nazwiska, datę urodzenia, wiek, numer PESEL oraz informacje o pełnionych funkcjach</span><span>. </span></li>
   <li style="margin-bottom: 10px;"><span>Fundacja pobiera ww. dane osobowe ze źródeł powszechnie dostępnych tj. z Monitora Sądowego i Gospodarczego oraz z Krajowego Rejestru Sądowego.</span></li>
   <li style="margin-bottom: 10px;"><span>Odbiorcami ww. danych osobowych są użytkownicy serwisu </span><span><a href="https://mojepanstwo.pl">mojePaństwo</a></span><span>.</span></li>
   <li style="margin-bottom: 10px;"><span>Osoba, której dane osobowe są przetwarzane przez Fundację ma prawo dostępu do treści swoich danych oraz </span><span>do ich poprawiania</span><span>.</span></li>
   <li style="margin-bottom: 10px;"><span>W razie wykazania przez osobę, której dane osobowe dotyczą, że dane pochodzące z Krajowego Rejestru Sądowego lub Monitora Sądowego i Gospodarczego prezentowane przez Fundację są niekompletne, nieaktualne lub nieprawdziwe - Fundacja bez zbędnej zwłoki uzupełni, uaktualni, lub odpowiednio sprostuje dane. </span></li>
   <li><span>Osobie, której dane osobowe są przetwarzane przez Fundację przysługuje:</span>
    <ul type="disc">
     <li><span>prawo wniesienia pisemnego, umotywowanego żądania zaprzestania przetwarzania jej danych osobowych ze względu na jej szczególną sytuację oraz</span></li>
     <li><span>prawo wniesienia sprzeciwu wobec przetwarzania danych osobowych w celach marketingowych lub wobec przekazywania ich innemu administratorowi danych.</span></li>
    </ul>
   </li>
   <li style="margin-bottom: 10px;"><span>Korespondencję w sprawach dotyczących danych osobowych prosimy kierować na ad</span><span>res: ul. Nowogrodzka 25/37, 00-511 Warszawa.</span></li>
</ol>


						
					</div>
					
		        </div>
		    </div>
        </div>
                
    </div>
</div>
