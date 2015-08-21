<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');

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
                <div class="col-xs-12 col-md-8">

                    <? if (isset($okregi)) { ?>

                        <div id="kto_tu_rzadzi" class="object"></div>
                        <div data-name="okregi" data-content='<?= json_encode($okregi) ?>'></div>

                    <? } else if (isset($okreg)) { ?>

                        <div class="row">

                            <div class="col-sm-6">

                                <h2>Okręg nr. <?= $okreg[2] ?></h2>

                                <dl class="dl-horizontal margin-top-20">
                                    <dt>Rok</dt>
                                    <dd><?= $okreg[1] ?></dd>
                                    <dt>Dzielnice</dt>
                                    <dd><?= $okreg[4] ?></dd>
                                    <dt>Ilość mieszkańców</dt>
                                    <dd><?= $okreg[5] ?></dd>
                                    <dt>Liczba mandatów</dt>
                                    <dd><?= $okreg[6] ?></dd>
                                </dl>

                                <p>
                                    <strong>Ilość mieszkańców / Norma przedstawicielstwa <span
                                            style="color: rgba(160, 25, 27, 0.78);">*</span></strong> : <?= $okreg[8] ?>
                                </p>

                                <p class="text-muted">
                                    <span style="color: rgba(160, 25, 27, 0.78);">*</span> Norma przedstawicielska -
                                    określa ilość mandatów przypadających na dany okręg. Jest obliczana przez
                                    podzielenie liczby mieszkańców gminy przez liczbę radnych wybieranych do danej rady.
                                    By ustalić liczbę mandatów w danym okręgu wyborczym, stosuje się normę
                                    przedstawicielską. Ułamki równe lub większe od 1/2, jakie wynikają z zastosowania
                                    normy przedstawicielstwa, zaokrągla się w górę do liczby całkowitej.
                                </p>

                                <p>
                                    <a target="_blank" href="/rada_uchwaly/18316">
                                        Źródło
                                    </a>
                                </p>

                            </div>

                            <div class="col-sm-6">
                                <div id="okreg_map" class="object"></div>
                                <div data-name="okreg" data-content='<?= json_encode($okreg) ?>'></div>
                            </div>

                        </div>

                    <? } ?>

                </div>
            </div>
        </div>
    </div>


<?= $this->Element('dataobject/pageEnd');
