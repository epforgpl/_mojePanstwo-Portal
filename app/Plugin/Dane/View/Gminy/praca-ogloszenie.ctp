<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-praca-ogloszenie', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $ogloszenie,
    'objectOptions' => array(
        'bigTitle' => true,
        'routes' => array(
            'thumbnail' => false,
        ),
    ),
    'back' => array(
        'href' => '/dane/gminy/903,krakow/zarzadzenia',
        'title' => 'Zarządzenia Prezydenta Krakowa',
    ),
));

?>
    <div class="krakow_zarzadzenia row">
        <div class="col-md-3 objectSide">
            <div class="objectSideInner">
                <ul class="dataHighlights side">
                    <? /*
                    <? if ($akt->getData('data_podpisania') && $akt->getData('data_podpisania') != '0000-00-00') { ?>
                        <li class="dataHighlight">
                            <p class="_label">Data podpisania</p>

                            <p class="_value"><?= $this->Czas->dataSlownie($akt->getData('data_podpisania')); ?></p>
                        </li>
                    <? } ?>

                    <? if ($akt->getData('status_str')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Status</p>

                            <p class="_value"><?= $akt->getData('status_str'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($akt->getData('realizacja_str')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Realizacja</p>

                            <p class="_value"><?= $akt->getData('realizacja_str'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($counters = $object->getLayer('counters')) {
                        $i = 0;
                        foreach ($counters as $counter) {
                            if (!$counter['count']) continue; ?>

                            <li class="dataHighlight big<? if (!$i) { ?> topborder<? } ?>">
                                <p class="_label"><?= $counter['nazwa'] ?></p>

                                <div>
                                    <p class="_value pull-left"><?= $counter['count'] ?></p>

                                    <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
                                                                       href="/dane/prawo/<?= $object->getId() ?>/<?= $counter['slug'] ?>">Zobacz &raquo;</a>
                                    </p>
                                </div>
                            </li>
                            <? $i++;
                        }
                    } ?>

                    <li class="dataHighlight topborder">
                        <p class="_label">Źródło</p>

                        <p class="_value sources">
                            <a itemprop="sameAs"
                               href="http://bip.krakow.pl/zarzadzenie/<?= $akt->getData('rok') ?>/<?= $akt->getData('numer') ?>"
                               target="_blank">BIP Kraków</a>
                        </p>
                    </li>
                    <? */ ?>
                </ul>
            </div>
        </div>

        <div class="col-md-9 objectMain">
	            
            <div class="block praca-ogloszenie">
	            <? echo $ogloszenie->getLayer('html'); ?>
            </div>
	            
        </div>
    </div>
<?

echo $this->Element('dataobject/pageEnd');
