<?

$this->Combinator->add_libs('css', $this->Less->css('view-prawo', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');

?>


    <div class="prawo row">
        <div class="col-lg-2 objectSide">
            <div class="objectSideInner">
                <ul class="dataHighlights side">


                    <? if ($object->getData('isap_status_str')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Status</p>

                            <p class="_value"><?= $object->getData('isap_status_str'); ?></p>
                        </li>
                    <? } ?>



                    <? if ($object->getData('data_wydania') && ($object->getData('data_wydania') != '0000-00-00')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Data wydania</p>

                            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wydania')); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('data_publikacji') && ($object->getData('data_publikacji') != '0000-00-00')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Data publikacji</p>

                            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_publikacji')); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('data_wejscia_w_zycie') && ($object->getData('data_wejscia_w_zycie') != '0000-00-00')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Data wejścia w życie</p>

                            <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wejscia_w_zycie')); ?></p>
                        </li>
                    <? } ?>



                    <? if ($counters = $object->getLayer('counters')) { ?>

                        <? $i = 0;
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
                        } ?>

                    <? } ?>



                    <? if ($object->getData('sygnatura')) { ?>
                        <li class="dataHighlight topborder">
                            <p class="_label">Sygnatura</p>

                            <p class="_value"><?= $object->getData('sygnatura'); ?></p>
                        </li>
                    <? } ?>


                    <li class="dataHighlight">
                        <p class="_label">Źródło</p>

                        <p class="_value sources">
                            <?
                            $isap_str = 'W';
                            if ($object->getData('zrodlo') == 'DzU') {
                                $isap_str .= 'DU';
                            } elseif ($object->getData('zrodlo') == 'MP') {
                                $isap_str .= 'MP';
                            }

                            $isap_str .= $object->getData('rok');
                            $isap_str .= str_pad($object->getData('nr'), 3, "0", STR_PAD_LEFT);
                            $isap_str .= str_pad($object->getData('poz'), 4, "0", STR_PAD_LEFT);
                            ?>
                            <a itemprop="sameAs" href="http://isap.sejm.gov.pl/DetailsServlet?id=<?= $isap_str ?>"
                               target="_blank">ISAP</a>
                        </p>
                    </li>


                </ul>

            </div>
        </div>


        <div class="col-lg-10 objectMain">

            <div class="object">


                <? if (isset($projekt)) { ?>

                    <div class="block proces">
                        <div class="block-header">
                            <h2 class="label">Zobacz prace w Sejmie nad tą ustawą</h2>
                        </div>
                        <div class="content">
                            <? echo $this->Dataobject->render($projekt, 'default', array(
                                'hlFields' => array('autorzy_html')
                            )); ?>
                        </div>
                    </div>

                <? } ?>

            </div>

            <?= $this->Document->place($document) ?>

        </div>
    </div>


<?= $this->Element('dataobject/pageEnd'); ?>