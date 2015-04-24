<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy-dyzury', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy-radny-obietnice', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-dyzury');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow', 'procent_glosow_w_okregu'),
        'bigTitle' => true,
    )
));

?>

    <div class="col-md-10 col-md-offset-1">
        <div class="object radny-obietnice">

            <h1 class="light"><a href="<?= $radny->getUrl() ?>"
                                 class="btn-back glyphicon glyphicon-circle-arrow-left"></a> Obietnice wyborcze</h1>
            <ul class="list-unstyled">
                <? foreach ($radny->getLayer('obietnice') as $obietnica) { ?>
                    <li class="panel panel-default<? if (isset($obietnica['do_sprawdzenia']) && !empty($obietnica['do_sprawdzenia'])) { ?> checking<? } ?>">
                        <div class="panel-header">
                            <div class="info date"><span class="glyphicon glyphicon-calendar"
                                                         aria-hidden="true"></span><?= $obietnica['znaleziono'] ?>
                            </div>
                            <? if (isset($obietnica['zrodlo_url']) && !empty($obietnica['zrodlo_url'])) { ?>
                                <a href="<?= $obietnica['zrodlo_url'] ?>" target="_blank"
                                   class="info btn btn-link"><span class="glyphicon glyphicon-globe"
                                                                   aria-hidden="true"></span>Źródło</a>
                            <? } ?>
                            <? if (isset($obietnica['zrzut_url']) && !empty($obietnica['zrzut_url'])) { ?>
                                <a href="<?= $obietnica['zrzut_url'] ?>" target="_blank" class="info btn btn-link"><span
                                        class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>Zrzut ekranu</a>
                            <? } ?>
                            <? if (isset($obietnica['do_sprawdzenia']) && !empty($obietnica['do_sprawdzenia'])) { ?>
                                <a href="<?= $obietnica['do_sprawdzenia'] ?>" target="_blank"
                                   class="info btn btn-link pull-right"><span class="glyphicon glyphicon-lock"
                                                                              aria-hidden="true"></span>W trakcie
                                    sprawdzania</a>
                            <? } ?>
                        </div>
                        <div class="panel-body">
                            <?= nl2br($obietnica['text']) ?>
                        </div>
                    </li>
                <? } ?>
            </ul>
            <? /* debug($radny->getLayer('obietnice')); */ ?>
        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
?>