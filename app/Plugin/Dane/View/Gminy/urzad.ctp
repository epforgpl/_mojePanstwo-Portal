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

echo $this->Element('dataobject/pageBegin');
?>




    <div class="poslowie row">
        <div class="col-md-3 objectSide">

            <div class="objectSideInner">

                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Prezydent</h2>
                    </div>

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a href="/dane/gminy/903,krakow/zarzadzenia"><span class="icon icon-moon">&#xe614;</span>Zarządzenia
                                Prezydenta <span class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                    </ul>
                </div>

                <div class="block">

                    <div class="block-header">
                        <h2 class="label">Urząd</h2>
                    </div>

                    <ul class="dataHighlights side">

                        <li class="dataHighlight">
                            <a href="/dane/gminy/903,krakow/jednostki"><span class="icon icon-moon">&#xe613;</span>Jednostki
                                i wydziały <span class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="/dane/gminy/903,krakow/urzednicy"><span class="icon icon-moon">&#xe617;</span>Urzędnicy
                                <span class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                        <li class="dataHighlight">
                            <a href="/dane/gminy/903,krakow/urzednicy_powiazania"><span
                                    class="icon icon-moon">&#xe611;</span>Powiązania urzędników w KRS <span
                                    class="glyphicon glyphicon-chevron-right"></a>
                        </li>

                    </ul>
                </div>


            </div>

        </div>
        <div class="col-md-7 nopadding">
            <div class="object">
                <?= $this->dataobject->feed($feed); ?>
            </div>
        </div>
        <div class="col-md-2">

        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>