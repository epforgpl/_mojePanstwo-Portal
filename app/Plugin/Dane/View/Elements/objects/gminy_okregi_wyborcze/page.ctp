<?
$this->Combinator->add_libs('js', 'jquery-tablesorter-min');
$this->Combinator->add_libs('js', 'Dane.view-gminy-okreg_wyborczy');
?>
<div class="gminy_okregi_wyborcze row">
    <div class="col-md-3 objectSide">
        <div class="objectSideInner">


            <ul class="dataHighlights side">

                <li class="dataHighlight big">
                    <p class="_label">Liczba wyborców</p>

                    <div>
                        <p class="_value"><?= _number($object->getData('liczba_wyborcow')); ?></p>
                    </div>
                </li>

                <li class="dataHighlight big">
                    <p class="_label">Liczba kandydatów</p>

                    <div>
                        <p class="_value"><?= _number($object->getData('liczba_kandydatow')); ?></p>
                    </div>
                </li>

                <li class="dataHighlight big">
                    <p class="_label">Liczba mandatów</p>

                    <div>
                        <p class="_value"><?= _number($object->getData('liczba_mandatow')); ?></p>
                    </div>
                </li>

                <li class="dataHighlight big">
                    <p class="_label">Liczba komitetów</p>

                    <div>
                        <p class="_value"><?= _number($object->getData('liczba_komitetow')); ?></p>
                    </div>
                </li>

            </ul>


        </div>
    </div>


    <div class="col-md-9 objectMain">
        <div class="object">

            <div class="block-group col-xs-12">

                <div id="wyniki" class="block">
                    <div class="block-header">
                        <h2 class="label">Wyniki wyborów</h2>
                    </div>

                    <div class="content">

                        <table id="wynikiTable" class="table table-striped table-hover ">

                            <thead>
                            <tr>
                                <th>Wybrany</th>
                                <th>Imię i nazwisko</th>
                                <th>Rok urodzenia</th>
                                <th>Lista</th>
                                <th>Pozycja na liście</th>

                                <th>Liczba głosów</th>
                                <th>Procent głosów</th>
                            </tr>
                            </thead>

                            <tbody>

                            <? foreach ($object->getLayer('kandydaci') as $kandydat) {
                                $href = '/dane/gminy/' . $object->getData('gmina_id') . '/radni/' . $kandydat['radny_id'];
                                ?>
                                <tr>
                                    <td><? if ($kandydat['radny_id']) { ?><a href="<?= $href ?>"
                                                                             class="glyphicon glyphicon-ok-sign"></a><? } ?>
                                    </td>
                                    <td><? if ($kandydat['radny_id']){ ?><a
                                            href="<?= $href ?>"><? } ?><?= $kandydat['nazwa'] ?><? if ($kandydat['wybrany'] == '1'){ ?></a><? } ?>
                                    </td>
                                    <td><?= $kandydat['rok_urodzenia'] ?></td>
                                    <td><?= $kandydat['komitet_nazwa'] ?></td>
                                    <td><?= $kandydat['pozycja'] ?></td>

                                    <td><?= $kandydat['l_glosow'] ?></td>
                                    <td><?= $kandydat['p_glosow'] ?>%</td>
                                </tr>
                            <? } ?>

                            </tbody>

                        </table>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>