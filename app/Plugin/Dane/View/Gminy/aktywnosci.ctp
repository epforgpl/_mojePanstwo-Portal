<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-aktywnosci');
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)); ?>

    <h1 class="subheader">Rada Miasta Kraków</h1>

    <div class="dataBrowser">
        <div class="row">
            <div class="dataBrowserContent">
                <div class="col-md-3 col-xs-12 dataAggsContainer">

                    <? if (isset($_submenu) && isset($_submenu['items'])) {

                        if (!isset($_submenu['base']))
                            $_submenu['base'] = $object->getUrl();

                        echo $this->Element('Dane.DataBrowser/browser-menu', array(
                            'menu' => $_submenu,
                        ));

                    } ?>

                </div>
                <div class="col-xs-12 col-md-9">

                    <? if(
                        !empty($aggs['ranking_aktywnosci']['top']['hits']['hits']) &&
                        $data = $aggs['ranking_aktywnosci']['top']['hits']['hits']
                    ) { ?>
                        <div class="margin-top-10">

                            <h2>
                                Aktywność
                                <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="" data-original-title="Radni którzy najczęściej wypowiadali się na posiedzeniach, brali udział w głosowaniach oraz posiadają najwięcej interpelacji."></i>
                            </h2>

                            <div
                                data-aggs="<?= htmlentities(json_encode($data)) ?>"
                                data-field="radni_gmin.punkty_aktywnosc"
                                data-request="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/radni/' : '/radni/') ?>"
                                class="radniRankingChart"
                            ></div>

                        </div>
                    <? } ?>

                    <? if(
                        !empty($aggs['ranking_otwartosci']['top']['hits']['hits']) &&
                        $data = $aggs['ranking_otwartosci']['top']['hits']['hits']
                    ) { ?>
                        <div class="margin-top-10">

                            <h2>
                                Otwartość
                                <i class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="" data-original-title="Radni którzy udostępnili o sobie najwięcej informacji."></i>
                            </h2>

                            <div
                                data-aggs="<?= htmlentities(json_encode($data)) ?>"
                                data-field="radni_gmin.punkty_dostepnosc"
                                data-request="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/radni/' : '/radni/') ?>"
                                class="radniRankingChart"
                                ></div>

                        </div>
                    <? } ?>

                </div>
            </div>
        </div>
    </div>


<?= $this->Element('dataobject/pageEnd');
