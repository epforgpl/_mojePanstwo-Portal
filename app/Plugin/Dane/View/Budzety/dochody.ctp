<? echo $this->Element('dataobject/pageBegin'); ?>


<div class="row">
    <div class="col-md-12">
        <div class="block block-simple col-xs-12">
            <header>Dochody budżetu:</header>
            <section class="aggs-init margin-sides-20">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                        <div class="col-xs-12 col-sm-11 row">
                            <table class="table table-strict table-condensed">
                                <thead>
                                <tr>
                                    <th>Część</th>
                                    <th>Dział</th>
                                    <th>Treść</th>
                                    <th>Poz.</th>
                                    <th>Plan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? $i = 0;
                                //debug($object->getLayers('dochody'));
                                foreach ($object->getLayers('dochody') as $row) {
                                    ?>
                                    <tr <? if ($row['pl_budzety_dochody']['czesc_str'] != '') { ?> class="active"<? } elseif ($row['pl_budzety_dochody']['dzial_str'] != '') { ?> class=""<? } ?>>
                                        <th scope="row"><?= $row['pl_budzety_dochody']['czesc_str'] ?></th>
                                        <th scope="row"><?= $row['pl_budzety_dochody']['dzial_str'] ?></th>
                                        <td><?= $row['pl_budzety_dochody']['tresc'] ?></td>
                                        <td><?= $row['pl_budzety_dochody']['pozycja'] ?></td>
                                        <td><?= number_format_h($row['pl_budzety_dochody']['plan'] * 1000) ?></td>
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
