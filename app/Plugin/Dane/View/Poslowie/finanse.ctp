<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
////$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-poslowie.js');

echo $this->Element('dataobject/pageBegin');
?>


    <div class="poslowie row">
        <div class="col-md-3 objectSide">
            <div class="objectSideInner">
                <ul class="dataHighlights side">

                    <? if ($object->getData('deleted') == '1') { ?>
                        <li class="dataHighlight">
                            <span class="label label-default">Ta osoba nie jest już posłem</span>
                        </li>
                    <? } ?>


                    <li class="dataHighlight big">
                        <p class="_label">Liczba przejazdów samochodami służbowymi Sejmu w 2013 r.</p>

                        <p class="_value"><?= $object->getData('liczba_przejazdow'); ?></p>
                    </li>

                    <li class="dataHighlight big">
                        <p class="_label">Liczba przelotów na koszt Sejmu w 2013 r.</p>

                        <p class="_value"><?= $object->getData('liczba_przelotow'); ?></p>
                    </li>

                </ul>


            </div>
        </div>


        <div class="col-md-9 objectMain">
            <div class="object">

                <div class="block-group col-xs-12">


                    <?
                    if (isset($krs_osoba)) {
                        echo $this->Element('Dane.objects/krs_osoby/organizacje', array(
                            'organizacje' => $krs_osoba->getLayer('organizacje'),
                        ));
                    }
                    ?>

                    <? if ($oswiadczenia_majatkowe) { ?>
                        <div id="projekty_za" class="block">
                            <div class="block-header">
                                <h2 class="label pull-left">Oświadczenia majątkowe</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/oswiadczenia_majatkowe">Zobacz
                                    wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($oswiadczenia_majatkowe, array(
                                            'perGroup' => 3,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>


                    <? if ($rejestr_korzysci) { ?>
                        <div id="projekty_za" class="block">
                            <div class="block-header">
                                <h2 class="label pull-left">Rejestr korzyści</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/rejestr_korzysci">Zobacz wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($rejestr_korzysci, array(
                                            'perGroup' => 3,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>



                    <? if ($wspolpracownicy) { ?>
                        <div id="projekty_za" class="block">
                            <div class="block-header">
                                <h2 class="label pull-left">Współpracownicy</h2>
                                <a class="btn btn-default btn-sm pull-right"
                                   href="/dane/poslowie/<?= $object->getId() ?>/wspolpracownicy">Zobacz wszystkie</a>
                            </div>

                            <div class="content">
                                <div class="dataobjectsSliderRow row">
                                    <div>
                                        <?php echo $this->dataobjectsSlider->render($wspolpracownicy, array(
                                            'perGroup' => 3,
                                            'rowNumber' => 1,
                                            'dfFields' => array('data'),
                                        )) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>




                    <?
                    if (
                        ($wydatki = $object->getLayer('wydatki')) &&
                        ($liczba_pol = $wydatki['liczba_pol']) &&
                        ($liczba_rocznikow = $wydatki['liczba_rocznikow'])
                    ) {
                        ?>
                        <div id="wydatki" class="block">
                            <div class="block-header">
                                <h2 class="label label-danger pull-left">Wydatki biura poselskiego</h2>
                            </div>

                            <div class="content">

                                <table class="table table-wydatki table-striped ">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <? for ($r = 0; $r < $liczba_rocznikow; $r++) { ?>
                                            <th><?= $wydatki['roczniki'][$r]['rok'] ?> <a
                                                    data-dokument_id="<?= $wydatki['roczniki'][$r]['dokument_id'] ?>"
                                                    href="/dane/poslowie/<?= $object->getId() ?>/finanse/<?= $wydatki['roczniki'][$r]['rok'] ?>"
                                                    class="glyphicon glyphicon-file"></a></th>
                                        <? } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <? for ($p = 0; $p < $liczba_pol; $p++) { ?>
                                        <tr>
                                            <td class="label_td"
                                                style="max-width: 50%;"><?= $wydatki['punkty'][$p]['tytul'] ?></td>
                                            <?
                                            for ($r = 0; $r < $liczba_rocznikow; $r++) {
                                                $v = (float)$wydatki['roczniki'][$r]['pola'][$p];
                                                ?>
                                                <td<? if (!$v) { ?> class="zero"<? } ?>><?= _currency($v) ?></td>
                                            <? } ?>
                                        </tr>
                                    <? } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    <?
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>






<?= $this->Element('dataobject/pageEnd'); ?>