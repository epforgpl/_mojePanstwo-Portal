<?php

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');


if ($historia) {

    $lastDate = false;
    $lastLocation = false;
    $lastSublocation = false;

    ?>
    <div class="object col-md-10 col-md-offset-1">
        <div id="historia" class="block historia">


            <div class="content">

                <ul>
                    <?
                    foreach ($historia as $h) {

                        $location = $h->getData('nr_dz') . '-' . $h->getData('nr_rub');
                        $sublocation = $h->getData('nr_dz') . '-' . $h->getData('nr_rub') . '-' . $h->getData('nr_sub');

                        ?>
                        <li>

                            <? if ($h->getDate() != $lastDate) {
                                $lastLocation = false;
                                $lastSublocation = false; ?>
                                <p class="date"><?= $this->Czas->dataSlownie($h->getDate()) ?></p>
                            <? } ?>

                            <div class="row">
                                <div class="col-md-12">

                                    <? if ($location !== $lastLocation) {
                                        $lastSublocation = false; ?>
                                        <div class="location">
                                            <span class="title"><?= $h->getData('opis') ?></span>
                                            <span class="desc pull-right">Dział <?= $h->getData('nr_dz') ?>
                                                , Rubryka <?= $h->getData('nr_rub') ?></span>
                                        </div>
                                    <? } ?>

                                    <? if ($h->getData('opis_sub') && ($sublocation !== $lastSublocation)) { ?>
                                        <div class="sublocation col-md-offset-1">
                                            <span><?= preg_replace('/([0-9]{11})/', '---', $h->getData('opis_sub')) ?></span>
                                            <? if ($h->getData('nr_sub')) { ?><span class="desc pull-right">
                                                Pozycja <?= $h->getData('nr_sub') ?></span><? } ?>
                                        </div>
                                    <? } ?>

                                    <div class="row col-md-offset-2">

                                        <div class="col-xs-2">

                                            <? if ($h->getData('mode') == 'ADD') { ?>
                                                <p class="status label label-success">Dodać</p>
                                            <? } elseif ($h->getData('mode') == 'REMOVE') { ?>
                                                <p class="status label label-danger">Usunąć</p>
                                            <? } elseif ($h->getData('mode') == 'CHANGE') { ?>
                                                <p class="status label label-warning">Zmienić</p>
                                            <? } ?>

                                        </div>
                                        <div class="col-xs-10">
                                            <div class="content_">
                                                <? if ($h->getData('label')) echo '<span class="_label">' . $h->getData('label') . ':</span> '; ?>
                                                <? if ($h->getData('label')) { ?><span class="_value"><? } ?>

                                                    <?
                                                    if ($h->getData('tresc_html'))
                                                        echo $h->getData('tresc_html');
                                                    else
                                                        echo preg_replace('/([0-9]{11})/', '---', $h->getData('tresc'));
                                                    ?>


                                                    <? if ($h->getData('label')) { ?></span><? } ?>
                                                <? if ($h->getData('tresc_poprzednia')) echo '<span class="_lastvalue" data-placement="top" data-toggle="tooltip" title="' . addslashes('Poprzednia wartość: ' . $h->getData('tresc_poprzednia')) . '"></span> '; ?>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </li>

                        <?
                        $lastDate = $h->getDate();
                        $lastLocation = $location;
                        $lastSublocation = $sublocation;

                    }
                    ?>
                </ul>

            </div>
        </div>
    </div>
<? }

echo $this->Element('dataobject/pageEnd');