<?php $this->Combinator->add_libs('css', $this->Less->css('view-poslowiewyjazdywydarzenia', array('plugin' => 'Dane'))); ?>


<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="row">

        <div class="col-md-2 objectSide">
            <div class="objectSideInner">


                <ul class="dataHighlights side">

                    <li class="dataHighlight">
                        <p class="_label">Lokalizacja</p>

                        <p class="_value"><?= $object->getData('lokalizacja') ?></p>
                    </li>

                    <li class="dataHighlight">
                        <p class="_label">Data rozpoczęcia wydarzenia</p>

                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_start')) ?></p>
                    </li>

                    <li class="dataHighlight">
                        <p class="_label">Data zakończenia wydarzenia</p>

                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_stop')) ?></p>
                    </li>

                    <li class="dataHighlight topborder">
                        <p class="_label">Koszt całościowy wyjazdu</p>

                        <p class="_value"><?= _currency($object->getData('wartosc_koszt')) ?></p>
                    </li>

                    <? if ($object->getData('wartosc_koszt_transport')) { ?>
                        <li class="dataHighlight topborder">
                            <p class="_label">Koszt transportu</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_transport')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_dieta')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Koszt diet</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_dieta')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_hotel')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Koszt hoteli</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_hotel')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_dojazd')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Koszt dojazdów</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_dojazd')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_ubezpieczenie')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Koszt ubezpieczenia</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_ubezpieczenie')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_fundusz')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Wydatkowany fundusz</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_fundusz')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_kurs')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Różnice kursowe</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_kurs')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wartosc_koszt_zaliczki')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Nierozliczone zaliczki</p>

                            <p class="_value"><?= _currency($object->getData('wartosc_koszt_zaliczki')) ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('wniosek_nr')) { ?>
                        <li class="dataHighlight topborder">
                            <p class="_label">Numer wniosku</p>

                            <p class="_value"><?= $object->getData('wniosek_nr') ?></p>
                        </li>
                    <? } ?>

                </ul>

            </div>
        </div>

        <div class="col-md-10 objectMain">

            <div class="object">

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Uczestnicy wyjazdu</h2>
                    </div>
                    <div class="content">


                        <table class="table table-striped table-hover" style="font-size: 11px;">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Osoba</th>
                                <th>Klub</th>
                                <th>Transport</th>
                                <th>Dieta</th>
                                <th>Hotel</th>
                                <th>Dojazd</th>
                                <th>Ubezpieczenie</th>
                                <th>Pobrana zaliczka</th>
                                <th>Koszt</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach ($object->getLayer('uczestnicy') as $u) { ?>
                                <tr>
                                    <td><? if( $u['poslowie.id'] ) {?><a href="/dane/poslowie/<?= $u['poslowie.id'] ?>">
                                            <img onerror="imgFixer(this)"
                                                 src="http://resources.sejmometr.pl/mowcy/a/3/<?= $u['ludzie.id'] ?>.jpg"
                                                 class="border"/>
                                        </a><? } ?></td>
                                    <td>
                                        <? if($u['poslowie.id']) {?><a href="/dane/poslowie/<?= $u['poslowie.id'] ?>"><?= $u['poslowie.nazwa'] ?></a><? } else { echo $u['osoba']; } ?>
                                    </td>
                                    <td>
                                        <? if($u['sejm_kluby.id']) {?><a href="/dane/sejm_kluby/<?= $u['sejm_kluby.id'] ?>"><?= $u['sejm_kluby.skrot'] ?></a><? } ?>
                                    </td>
                                    <td><? if ($u['koszt_transport'] > 0) echo _currency($u['koszt_transport']); ?></td>
                                    <td><? if ($u['koszt_dieta'] > 0) echo _currency($u['koszt_dieta']); ?></td>
                                    <td><? if ($u['koszt_hotel'] > 0) echo _currency($u['koszt_hotel']); ?></td>
                                    <td><? if ($u['koszt_dojazd'] > 0) echo _currency($u['koszt_dojazd']); ?></td>
                                    <td><? if ($u['koszt_ubezpieczenie'] > 0) echo _currency($u['koszt_ubezpieczenie']); ?></td>
                                    <td><? if ($u['koszt_zaliczki'] > 0) echo _currency($u['koszt_zaliczki']); ?></td>
                                    <td><? if ($u['koszt'] > 0) echo _currency($u['koszt']); ?></td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

        </div>

    </div>



<?= $this->Element('dataobject/pageEnd'); ?>