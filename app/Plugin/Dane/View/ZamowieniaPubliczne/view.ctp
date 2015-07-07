<?
$this->Combinator->add_libs('css', $this->Less->css('view-zamowieniapubliczne', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-zamowieniapubliczne');

echo $this->Element('dataobject/pageBegin'); ?>


<div class="row">
    <div class="col-xs-12 col-sm-3">
        <div class="dataFeed">
            <div class="object col-feed-main">
                <h2>Przebieg zamówienia</h2>
                <? echo $this->Element('Dane.DataFeed/feed-min', array(
                    'selected' => array(
                        'dataset' => $dokument->getDataset(),
                        'id' => $dokument->getId(),
                    ),
                )); ?>
            </div>
        </div>

        <ul class="dataHighlights col-xs-12">
            <li class="dataHighlight">
                <p>
                    <? if ($object->getData('status_id') == '0') {
                        ?>
                        <span class="_label label label-success">Zamówienie otwarte</span>
                    <? } elseif ($object->getData('status_id') == '2') { ?>
                        <span class="_label label label-danger">Zamówienie rozstrzygnięte</span>
                    <? } ?>
                </p>


                <? if ($object->getData('wartosc_cena')) { ?>
                    <p><span class="_value">na kwotę <?= number_format_h($object->getData('wartosc_cena')); ?>
                            PLN</span></p>
                <? } ?>
            </li>
        </ul>
    </div>
    <div class="col-xs-12 col-md-9 objectMain">
        <div class="object">
            <? if (isset($details['czesci-wykonawcy'])) { ?>
                <? foreach ($details['czesci-wykonawcy'] as $item) { ?>
                    <div class="block col-xs-12">
                        <? if ($item['numer']) { ?>
                            <header>Część <?= $item['numer'] ?></header>
                        <? } ?>

                        <section>
                            <table class="table table-striped table-hover table-min">
                                <thead>
                                <tr>
                                    <th>Liczba ofert / odrzuconych</th>
                                    <th>Cena</th>
                                    <th>Najniższa oferta</th>
                                    <th>Najwyższa oferta</th>
                                    <th>Wartość szacunkowa (bez VAT)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= $item['liczba_ofert'] ?>
                                        / <?= $item['liczba_odrzuconych_ofert'] ?></td>
                                    <td><?= number_format_h($item['cena']) ?> <?= $item['waluta'] ?></td>
                                    <td><?= number_format_h($item['cena_min']) ?> <?= $item['waluta'] ?></td>
                                    <td><?= number_format_h($item['cena_max']) ?> <?= $item['waluta'] ?></td>
                                    <td><?= number_format_h($item['wartosc']) ?> <?= $item['waluta'] ?></td>
                                    <? if (isset($admin)) { ?>
                                        <td>
                                            <button class="btn btn-xs btn-primary open_modal"
                                                    numer="<?= $item['id'] ?>"><span class="glyphicon glyphicon-edit"
                                                                                     aria-hidden="true"></span></button>
                                        </td>
                                    <? } ?>
                                </tr>
                                </tbody>
                            </table>

                            <p>Wybrany wykonawca:</p>
                            <ul>
                                <? foreach ($item['wykonawcy'] as $w) { ?>
                                    <li>
                                        <p><?= $w['nazwa'] ?> (<?= $w['miejscowosc'] ?>)</p>
                                    </li>
                                <? } ?>
                            </ul>
                        </section>
                    </div>
                    <? if (isset($admin)) { ?>
                        <div class="modal fade in" id="<?= $item['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Edycja:</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="" action="">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="pull-right">Cena:</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input name="cena" class="form-control" value="<?= $item['cena'] ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="pull-right">Cena Min:</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input name="cena_min" class="form-control" value="<?= $item['cena_min'] ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="pull-right">Cena Max:</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input name="cena_max" class="form-control" value="<?= $item['cena_max'] ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                            <label class="pull-right">Wartość:</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input class="form-control" value="<?= $item['wartosc'] ?>" disabled>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-md btn-primary btn-icon btn-inline"
                                                    id="bdl_temp_savebtn"><i
                                                    class="icon glyphicon glyphicon-ok"></i>Zapisz
                                            </button>
                                            </form>
                                            <div class="inline">
                                                <a class="margintop" id="bdl_temp_cancelbtn" href="#">Anuluj</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                <? } ?>
            <? } ?>
            <? if (isset($details['przedmiot'])) { ?>
                <div class="block col-xs-12">
                    <header>Przedmiot zamówienia</header>
                    <section><?php echo(nl2br($details['przedmiot'])); ?></section>
                </div>
            <? } ?>

            <? if (@$details['siwz_www'] || @$details['siwz_adres']) { ?>
                <div class="block col-xs-12">
                    <header>Specyfikacja Istotnych Warunków Zamówienia</header>
                    <section>
                        <? if (@$details['siwz_www']) { ?>
                            <p>
                                <a target="_blank"
                                   href="<?= $details['siwz_www'] ?>"><?= $details['siwz_www'] ?></a>
                            </p>
                        <? } ?>
                        <? if (@$details['siwz_adres']) { ?>
                            <p><?= $details['siwz_adres'] ?></p>
                        <? } ?>
                    </section>
                </div>
            <? } ?>

            <? if ((isset($details['oferty_data_stop']) && ($details['oferty_data_stop']) && ($details['oferty_data_stop'] != '0000-00-00')) || @$details['oferty_miejsce']) {
                ?>
                <div class="block col-xs-12">
                    <header>Składanie ofert</header>
                    <section>
                        <p>Oferty można składać do
                            <b><?= $this->Czas->dataSlownie($details['oferty_data_stop']) ?></b>, do
                            godziny
                            <b><?= $details['oferty_godz'] ?></b><? if (@$details['oferty_miejsce']) { ?>, w:<? } ?>
                        </p>
                        <? if (@$details['oferty_miejsce']) { ?>
                            <p><?= $details['oferty_miejsce'] ?></p><? } ?>
                    </section>
                </div>
            <? } ?>

            <? foreach ($text_details as $key => $value) {
                if ($value) {
                    ?>
                    <div class="block col-xs-12">
                        <header><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_' . $key)); ?></header>
                        <section><?php echo(nl2br($value)); ?></section>
                    </div>
                <? }
            } ?>

            <footer class="text-center">
                <a href="http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=<?= $details['data']['numer'] ?>&rok=<?= $details['data']['data'] ?>">Źródło</a>
            </footer>
        </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>

<script type="text/javascript">
    var sources = <?= json_encode( $object->getLayer('sources') ) ?>;
</script>