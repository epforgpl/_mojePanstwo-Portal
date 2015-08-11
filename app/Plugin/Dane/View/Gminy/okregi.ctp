<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)); ?>

    <div class="objectsPage">

        <h1 class="subheader">Rada Miasta Kraków</h1>

        <? if (isset($_submenu) && !empty($_submenu)) { ?>
            <div class="menuTabsCont">
                <?
                if (!isset($_submenu['base']))
                    $_submenu['base'] = $object->getUrl();
                echo $this->Element('Dane.dataobject/menuTabs', array(
                    'menu' => $_submenu,
                ));
                ?>
            </div>
        <? } ?>

        <? if(isset($okregi)) { ?>

            <div id="kto_tu_rzadzi" class="object"></div>
            <div data-name="okregi" data-content='<?= json_encode($okregi) ?>'></div>

        <? } else if(isset($okreg)) { ?>

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
                        <strong>Ilość mieszkańców / Norma przedstawicielstwa <span style="color: rgba(160, 25, 27, 0.78);">*</span></strong> : <?= $okreg[8] ?>
                    </p>

                    <p class="text-muted">
                        <span style="color: rgba(160, 25, 27, 0.78);">*</span> Norma przedstawicielska - określa ilość mandatów przypadających na dany okręg. Jest obliczana przez podzielenie liczby mieszkańców gminy przez liczbę radnych wybieranych do danej rady. By ustalić liczbę mandatów w danym okręgu wyborczym, stosuje się normę przedstawicielską. Ułamki równe lub większe od 1/2, jakie wynikają z zastosowania normy przedstawicielstwa, zaokrągla się w górę do liczby całkowitej.
                    </p>

                    <p>
                        <a target="_blank" href="<?= ($okreg[1] == '2014') ? 'https://trello-attachments.s3.amazonaws.com/54d0f560995fdf500c52501f/54d0f927596c90a3636ced09/d3342ff9f9626679da7e983560fe5e97/okr%C4%99gi_2014.pdf' : 'https://trello-attachments.s3.amazonaws.com/54d0f560995fdf500c52501f/54d0f927596c90a3636ced09/221680cbe63c743f8e053c4fdd134883/okr%C4%99gi_2010.pdf'; ?>">
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


<?= $this->Element('dataobject/pageEnd');
