<?
echo $this->Element('dataobject/pageBegin');

echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('css', $this->Less->css('view-krsosoby', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krsosoby');
$this->Combinator->add_libs('js', 'graph-krs-osoba');

?>
    <div class="krsOsoby row">

        <div class="col-md-3 objectSide">
            <div class="objectSideInner">

                <ul class="dataHighlights side">

                    <? if ($object->getData('liczba_reprezentanci')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Zarządzane organizacje</p>

                            <p class="_value"><?= $object->getData('liczba_reprezentanci'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('liczba_wspolnicy')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Spółki, w których posiada udziały</p>

                            <p class="_value"><?= $object->getData('liczba_wspolnicy'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('liczba_akcjonariusze')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Akcjonariusz w organizacjach</p>

                            <p class="_value"><?= $object->getData('iczba_akcjonariusze'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('liczba_nadzorcow')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Nadzorowane organizacje</p>

                            <p class="_value"><?= $object->getData('liczba_nadzorcow'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('liczba_zalozyciele')) { ?>
                        <li class="dataHighlight big">
                            <p class="_label">Założone organizacje</p>

                            <p class="_value"><?= $object->getData('liczba_zalozyciele'); ?></p>
                        </li>
                    <? } ?>

                </ul>

            </div>
        </div>
        <div class="col-md-9 objectMain">
            <div class="object">
                <div class="block-group">

                    <? if ($organizacje = $object->getLayer('organizacje')) {

                        echo $this->Element('Dane.objects/krs_osoby/organizacje', array(
                            'organizacje' => $organizacje,
                        ));

                    } ?>

                    <div class="powiazania block">
                        <div class="block-header"><h2 class="label">Powiązania</h2></div>
                        <div id="connectionGraph" class="loading" data-id="<?php echo $object->getId() ?>"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>