<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>

<div class="row">
<div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
	<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $object->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu,
        ));

    } ?>
    <?

        if ($adres = $object->getData('adres')) {
            $adres = $adres . ', Polska';
            echo $this->element('Dane.adres', array(
                'adres' => $adres,
                'label' => 'Urząd gminy',
            ));
        }

        $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
        $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
        $this->Combinator->add_libs('js', 'Pisma.pisma-button');
        echo $this->element('tools/pismo', array(
            'label' => '<strong>Wyślij pismo</strong> do Urzędu Miasta',
            'adresat' => 'gminy:903',
        ));
    ?>
    
	</div>
</div>
<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
	
	<div class="dataWrap">
		
		<h1 class="smaller margin-top-15">Urząd Miasta Kraków</h1>
		
        <div class="databrowser-panels">
            <? if ($object->getId() == 903) { ?>
                <div class="databrowser-panel">
                    <h2>Prezydent miasta:</h2>

                    <div class="aggs-init">
                        <div class="thumbnail pull-left col-xs-4 col-md-3">
                            <img src="/Dane/img/customObject/krakow/prezydent_jacek_majchrowski.jpg"
                                 alt="Prezydent Jacek Majchrowski"/>
                        </div>
                        <p><strong>Jacek Majchrowski</strong> &ndash; prezydent Krakowa od 2002 r., 30 listopada
                            2014 r. wybrany na czwartą kadencję. Prawnik, profesor Uniwersytetu Jagiellońskiego,
                            profesor zwyczajny nauk prawnych, historyk doktryn politycznych i prawnych. Znawca II
                            Rzeczypospolitej, dokumentujący jej historię, a szczególnie działalność ugrupowań
                            prawicowych. Był zastępcą przewodniczącego Trybunału Stanu (w latach 2001-2005), do
                            listopada 2011 r. &ndash; sędzia Trybunału Stanu.</p>

                        <p>Jacek Majchrowski urodził się 13 stycznia 1947 r. w Sosnowcu. Swoje życie związał z Krakowem,
                            a pracę z Uniwersytetem Jagiellońskim. W 1970 r. ukończył studia. W 1974 r. zdobył tytuł
                            doktora na Wydziale Prawa i Administracji, w 1978 r. habilitował się, a w 1988 r., jako
                            jeden z najmłodszych w historii UJ, uzyskał tytuł profesora nadzwyczajnego nauk prawnych. W
                            latach 1987-1993 pełnił funkcję dziekana Wydziału Prawa i Administracji.</p>
                    </div>
                </div>

                <div class="block">
                    <header>Najnowsze zarządzenia Prezydenta:</header>
					
					<section class="content">
	                    <div class="aggs-init">
	                        <div class="dataAggs">
	                            <div class="agg agg-Dataobjects">
	                                <? if ($dataBrowser['aggs']['zarzadzenia']['top']['hits']['hits']) { ?>
	                                    <ul class="dataobjects">
	                                        <? foreach ($dataBrowser['aggs']['zarzadzenia']['top']['hits']['hits'] as $doc) { ?>
	                                            <li>
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
					</section>
					
					<div class="buttons">
                        <a href="<?= $object->getUrl() ?>/zarzadzenia" class="btn btn-default btn-xs">Zobacz
                            więcej</a>
                    </div>
                </div>
            <? } ?>
		
        </div>

    </div>
</div>
</div>
