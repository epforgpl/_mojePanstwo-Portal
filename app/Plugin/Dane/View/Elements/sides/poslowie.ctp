<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
?>

<div class="objectSideInner">

    <div class="block">
        <ul class="dataHighlights side">

            <li class="dataHighlight">
                <p class="_label">Zawód</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('zawod'); ?></p>
                </div>
            </li>

            <li class="dataHighlight">
                <p class="_label">Data urodzenia</p>

                <div>
                    <p class="_value pull-left"><?= $this->Czas->dataSlownie($object->getData('data_urodzenia')); ?></p>
                </div>
            </li>

            <? if ($object->getData('data_wygasniecia_mandatu') && ($object->getData('data_wygasniecia_mandatu') != '0000-00-00')) { ?>
                <li class="dataHighlight">
                    <span class="label label-default">Ta osoba nie jest już posłem</span>
                </li>
                <li class="dataHighlight">
                    <p class="_label">Data wygaśnięcia mandatu</p>

                    <div>
                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wygasniecia_mandatu')); ?></p>
                    </div>
                </li>
            <? } ?>

            <? if ($object->getData('data_slubowania') && ($object->getData('data_slubowania') != '0000-00-00')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Data ślubowania</p>

                    <div>
                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_slubowania')); ?></p>
                    </div>
                </li>
            <? } ?>

        </ul>
    </div>

    <div class="block">
        <ul class="dataHighlights side">
            <li class="dataHighlight big">
                <p class="_label">Liczba wystąpień na forum Sejmu</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('liczba_wypowiedzi'); ?></p>
                    <? if ($object->getData('liczba_wypowiedzi')) { ?><p class="pull-right nopadding"><a
                            class="btn btn-sm btn-default"
                            href="/dane/poslowie/<?= $object->getId() ?>/wystapienia">Zobacz &raquo;</a>
                        </p><? } ?>
                </div>
            </li>

            <li class="dataHighlight big">
                <p class="_label">Frekwencja na głosowaniach</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('frekwencja'); ?>%</p>

                    <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
                                                       href="/dane/poslowie/<?= $object->getId() ?>/glosowania/?poslowie_glosy:glos_id[]=4&search=web">Zobacz &raquo;</a>
                    </p>
                </div>
            </li>

            <li class="dataHighlight big">
                <p class="_label">Zbuntowanie</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('zbuntowanie'); ?>%</p>

                    <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
                                                       href="/dane/poslowie/<?= $object->getId() ?>/glosowania?poslowie_glosy:bunt[]=1&search=web">Zobacz &raquo;</a>
                    </p>
                </div>

            </li>
        </ul>
    </div>

    <div class="block">
        <ul class="dataHighlights side">
            <li class="dataHighlight big">
                <p class="_label">Liczba podpisanych projektów ustaw</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('liczba_projektow_ustaw'); ?></p>
                    <? if ($object->getData('liczba_projektow_ustaw')) { ?><p class="pull-right nopadding">
                        <a
                            class="btn btn-sm btn-default"
                            href="<?= $object->getUrl() ?>/projekty_ustaw">Zobacz &raquo;</a>
                        </p><? } ?>
                </div>
            </li>

            <li class="dataHighlight big">
                <p class="_label">Liczba podpisanych projektów uchwał</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('liczba_projektow_uchwal'); ?></p>
                    <? if ($object->getData('liczba_projektow_uchwal')) { ?><p class="pull-right nopadding">
                        <a
                            class="btn btn-sm btn-default"
                            href="<?= $object->getUrl() ?>/projekty_uchwal">Zobacz &raquo;</a>
                        </p><? } ?>
                </div>
            </li>

            <li class="dataHighlight big">
                <p class="_label">Liczba wysłanych interpelacji</p>

                <div>
                    <p class="_value pull-left"><?= $object->getData('liczba_interpelacji'); ?></p>
                    <? if ($object->getData('liczba_interpelacji')) { ?><p class="pull-right nopadding"><a
                            class="btn btn-sm btn-default"
                            href="/dane/poslowie/<?= $object->getId() ?>/interpelacje">Zobacz &raquo;</a>
                        </p><? } ?>
                </div>
            </li>

            <? /* ?>
            <? if($object->getData('wartosc_refundacja_kwater_pln')) {?>
            <li class="dataHighlight">
                <p class="_label">Wartość refenduacji w 2013 r.</p>

                <p class="_value"><?= _currency($object->getData('wartosc_refundacja_kwater_pln')); ?></p>
            </li>
            <? } ?>
            
            <? if($object->getData('wartosc_uposazenia_pln')) {?>
            <li class="dataHighlight">
                <p class="_label">Kwota uposażenia w 2013 r.</p>

                <p class="_value"><?= _currency($object->getData('wartosc_uposazenia_pln')); ?></p>
            </li>
            <? } ?>
            <? */
            ?>

        </ul>
    </div>

</div>