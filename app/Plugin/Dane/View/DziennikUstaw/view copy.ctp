<?
$this->Combinator->add_libs('css', $this->Less->css('view-prawo', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');
?>

    <div class="prawo row">
        <div class="col-md-3 objectSide">
            <div class="objectSideInner">
                <div class="block">
                    <ul class="dataHighlights side">
                        <? if ($object->getData('isap_status_str')) { ?>
                            <li class="dataHighlight">
                                <p class="_label">Status</p>

                                <p class="_value"><?= $object->getData('isap_status_str'); ?></p>
                            </li>
                        <? } ?>

                        <? if ($object->getData('sygnatura')) { ?>
                            <li class="dataHighlight">
                                <p class="_label">Sygnatura</p>

                                <p class="_value"><?= $object->getData('sygnatura'); ?></p>
                            </li>
                        <? } ?>
                    </ul>
                </div>

                <div class="block">
                    <ul class="dataHighlights side">

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
                    </ul>
                </div>

                <? if ($object->getLayer('tags')) { ?>
                    <div class="block">
                        <div class="block-header">
                            <h2 class="label">Tematy</h2>
                        </div>
                        <ul class="dataHighlights side">
                            <? foreach ($object->getLayer('tags') as $tag) { ?>

                                <li class="dataHighlight"><a title="<?= addslashes($tag['q']) ?>"
                                                             href="/dane/prawo_hasla/<?= $tag['id'] ?>"><?= $this->Text->truncate($tag['q'], 35) ?></a>
                                </li>

                            <? } ?>
                        </ul>
                    </div>
                <? } ?>

                <div class="block">
                    <ul class="dataHighlights side">

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

        </div>
        <div class="col-md-7 nopadding">
            <div class="object">
                <?= $this->dataobject->feed($feed); ?>
            </div>
        </div>
        <div class="col-md-2">

        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>
