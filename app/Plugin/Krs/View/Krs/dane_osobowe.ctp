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
						<p>Administratorem danych osobowych jest Fundacja ePaństwo z siedzibą w Zgorzale ul. Pliszki 2B/1 05-500 Mysiadło zarejestrowana pod numerem KRS 0000359730. Dane osobowe zostały pozyskane z dostępnych źródeł pozostających trwale w obiegu publicznym i są publikowane na podstawie ustawy z dnia 20 sierpnia 1997 r. o Krajowym Rejestrze Sądowym (Dz.U. z 2015 r. poz. 1142) w Krajowym Rejestrze Sądowym oraz Monitorze Sądowym i Gospodarczym.</p>
						
						<p>Zgodnie z art. 8 ust. 1 powołanej ustawy rejestr jest jawny, a istotą Monitora Sądowego i Gospodarczego jest umieszczenie go obiegu publicznym (art. 13 ust. 1 ustawy). Zgodnie z brzmieniem art. 35 ust. 1 ustawy o ochronie danych osobowych realizacja żądania, o którym mowa w art. 32 ust. 1 pkt 6 ustawy nie jest prowadzona gdy dotyczy to danych osobowych, w odniesieniu do których tryb ich uzupełnienia, uaktualnienia lub sprostowania określają odrębne ustawy. Na podstawie art. 32 ust. 1 pkt 7 ustawy przysługuje prawo wniesienia pisemnego, umotywowanego żądania zaprzestania przetwarzania danych ze względu na szczególną sytuację.
						</p>
						
					</div>
					
		        </div>
		    </div>
        </div>
                
    </div>
</div>
