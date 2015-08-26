<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
    <div class="col-md-9">

        <div class="block block-simple col-xs-12">
            <header>Główne parametry budżetu:</header>
            <section class="aggs-init margin-sides-20">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                        <div class="col-sm-10 col-sm-offset-1">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Dochody</th>
                                    <th>Wydatki</th>
                                    <th>Deficyt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $object->getData('liczba_dochody') ?></td>
                                    <td><?= $object->getData('liczba_wydatki') ?></td>
                                    <td><?= $object->getData('liczba_deficyt') ?></td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-hover">
                                <caption>Ze środków Unii Europejskiej</caption>
                                <thead>
                                <tr>
                                    <th>Dochody</th>
                                    <th>Wydatki</th>
                                    <th>Deficyt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $object->getData('liczba_dochody_eu') ?></td>
                                    <td><?= $object->getData('liczba_wydatki_eu') ?></td>
                                    <td><?= $object->getData('liczba_deficyt_eu') ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="block block-simple col-xs-12">
            <header>Wydatki według działów:</header>
            <section class="aggs-init margin-sides-20">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                        <? debug($object->getLayers('wydatki')) ?>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <div class="col-md-3">

        <ul class="dataHighlights rightColumn margin-top-15">

            <?
            $data_wydania = $object->getData('prawo.data_wydania');
            if (isset($data_wydania) && !empty($data_wydania) && ($data_wydania != '0000-00-00')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data wydania</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_wydania); ?></p>
                </li>
            <? } ?>

            <?
            $data_publikacji = $object->getData('prawo.data_publikacji');
            if (isset($data_publikacji) && !empty($data_publikacji) && ($data_publikacji != '0000-00-00')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data publikacji</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_publikacji); ?></p>
                </li>
            <? } ?>


            <?
            $data_wejscia_w_zycie = $object->getData('prawo.data_wejscia_w_zycie');
            if (isset($data_wejscia_w_zycie) && !empty($data_wejscia_w_zycie) && ($data_wejscia_w_zycie != '0000-00-00')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data wejścia w życie</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_wejscia_w_zycie); ?></p>
                </li>
            <? } ?>

            <?
            if ($sygnatura = $object->getData('prawo.sygnatura')) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Sygnatura</p>

                    <p class="_value"><?= $sygnatura ?></p>
                </li>
            <? } ?>
        </ul>

    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
