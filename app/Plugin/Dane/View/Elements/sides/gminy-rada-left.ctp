<?

	$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
	$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
	$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
	$this->Combinator->add_libs('js', 'Dane.view-gminy');
	
	if ($object->getId() == '903') {
	    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
	    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
	}

?>

<div class="objectSideInner">

    <div class="block">

        <div class="block-header">
            <h2 class="label">Rada Miasta</h2>
        </div>

        <ul class="dataHighlights side">

            <li class="dataHighlight">
                <a href="<?= $object->getUrl() . '/radni' ?>"><span class="icon icon-moon">&#xe617;</span>Radni
                    Miasta <span class="glyphicon glyphicon-chevron-right"></span></a>
            </li>

            <li class="dataHighlight">
                <a href="<?= $object->getUrl() . '/radni_powiazania' ?>"><span class="icon icon-moon">&#xe611;</span>Powiązania
                    radnych <span class="glyphicon glyphicon-chevron-right"></span></a>
            </li>
            
            <li class="dataHighlight">
                <a href="<?= $object->getUrl() . '/komisje' ?>"><span class="icon icon-moon">&#xe613;</span>Komisje
                    Rady Miasta <span class="glyphicon glyphicon-chevron-right"></span></a>
            </li>

        </ul>
    </div>
   


</div>