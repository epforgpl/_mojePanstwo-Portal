<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-wpf', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

    switch (Configure::read('Config.language')) {
        case 'pol':
            $lang = "pl-PL";
            break;
        case 'eng':
            $lang = "en-EN";
            break;
    };
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=places&language=' . $lang, array('block' => 'scriptBlock'));
}

$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

echo $this->Element('dataobject/pageBegin');

if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();
?>

    <div class="col-sm-9">
        <h1 class="margin-top-15"><?= $program->getShortTitle() ?></h1>

        <? $przedsiewziecia = $program->getLayer('przedsiewziecia');
        foreach ($przedsiewziecia as $p) {

            $static = array(
                'years' => array()
            );

            for ($i = 2016; $i <= 2052; $i++) {
                $static['years'][] = array(
                    $i,
                    $p['limit_' . $i]
                );
            }

            ?>
            <div class="krakow_wpf_content">
                <p class="text-muted">
                    <?= $p['kategoria_nazwa'] ?> <?= $p['podkategoria_nazwa'] ?>
                </p>

                <? if (isset($p['opis']) && strlen($p['opis']) > 10) { ?>
                    <p class="text-muted">
                        <?= ucfirst($p['opis']) ?>
                    </p>
                <? } ?>

                <ul class="dataHighlights oneline col-xs-12">
                    <? foreach (array(
                                    array(
                                        'field' => 'cel',
                                        'label' => 'Cel'
                                    ),
                                    array(
                                        'field' => 'jednostka',
                                        'label' => 'Jednostka'
                                    ),
                                    array(
                                        'field' => 'okres_od',
                                        'label' => 'Okres Od'
                                    ),
                                    array(
                                        'field' => 'okres_do',
                                        'label' => 'Okres do'
                                    ),
                                    array(
                                        'field' => 'nr',
                                        'label' => 'Numer'
                                    ),
                                    array(
                                        'field' => 'laczne_naklady_fin',
                                        'label' => 'Łączne nakłady finansowe'
                                    ),
                                    array(
                                        'field' => 'limit_zobowiazan',
                                        'label' => 'Limit zobowiązań'
                                    ),
                                ) as $f) {
                        if (isset($p[$f['field']]) && trim($p[$f['field']]) != '') { ?>
                            <li class="dataHighlight col-sm-6">
                                <p class="_label"><?= $f['label'] ?></p>
                                <p class="_value"><?=
                                    in_array($f['field'], array('laczne_naklady_fin', 'limit_zobowiazan')) ?
                                        number_format_h($p[$f['field']]) . ' zł' : $p[$f['field']]
                                    ?></p>
                            </li>
                        <? }
                    } ?>
                </ul>
                <div
                    class="krakowWpfProgramStatic margin-top-20"
                    data-static="<?= htmlspecialchars(json_encode($static)); ?>">
                </div>
                <?

                //TODO: fake marker data;
                $marker = '{"formatted_address":"Powstańców Wielkopolskich 1, 30-553 Kraków-Podgórze, Polska","geometry":{"location":{"G":50.04251,"K":19.960890000000063}},"icon":"https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png","id":"50848b2d02aed8ff52899842152536a426189c65","name":"Powstańców Wielkopolskich 1","place_id":"ChIJ-_-eNk5bFkcRS0jOGqmaidw","reference":"CqQBnQAAADzYnjosfTGy7yQeTZaaIrE5l53vHotZkZFkeN1Ip7LU6eNYwKGLjT_wAySWPsNliqvKL6fpYPCUkY3ArvLHDUGdHRIFplD9D_ow5tfHSAmAKJzPD1-7ss0Ojw1BEvg_dEKfHJeNyGXOZIRuCNYcbDEM8xA-InUIOi-tLKpZYAKIzU5B0eSfOQMhuuCTHx7zwCs6kgt-nYnIwSDQ8qOUBMQSEG-HbA4Q7b-7gz3GWYqrGsEaFJ7qKoUe0GHhRc548YAqtEK--Xy5","types":["street_address"],"html_attributions":[]}';

                if ((isset($can_edit) && $can_edit) || isset($marker)) { ?>
                    <div class="krakowWpfPlaceMarker margin-top-20">
                        <? if ($can_edit) { ?>
                            <input id="pac-input" class="controls" type="text" placeholder="Wpisz adres"
                                   value="Kraków, ">
                        <? } ?>
                        <div
                            id="map"<? if (isset($marker)) echo ' data-place="' . htmlentities($marker) . '"' ?>></div>
                        <? if ($can_edit) { ?>
                            <form method="post" action="<?= $this->request->here; ?>.json">
                                <button type="submit" class="btn btn-success pull-right margin-top-10">Zapisz</button>
                            </form>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        <? } ?>

    </div>

    <div class="col-sm-3">
        <ul class="dataHighlights">
            <li class="dataHighlight">
                <p class="_label">Liczba przedsięwzięć</p>
                <p class="_value"><?= $program->getData('ilosc') ?></p>
            </li>
            <li class="dataHighlight">
                <p class="_label">Łączne nakłady finansowe</p>
                <p class="_value"><?= number_format_h($program->getData('laczne_naklady_fin')) ?> zł</p>
            </li>
            <li class="dataHighlight">
                <p class="_label">Limit zobowiązań</p>
                <p class="_value"><?= number_format_h($program->getData('limit_zobowiazan')) ?> zł</p>
            </li>
            <li class="dataHighlight">
                <p class="_label">Okres od</p>
                <p class="_value"><?= $program->getData('okres_od') ?></p>
            </li>
            <li class="dataHighlight">
                <p class="_label">Okres do</p>
                <p class="_value"><?= $program->getData('okres_do') ?></p>
            </li>
        </ul>
    </div>

<? echo $this->Element('dataobject/pageEnd');
