<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-wpf', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

if ($object->getId() == '903')
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

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
            <div style="overflow: hidden;padding: 20px 0; border-bottom: 1px solid #efefef;">
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
