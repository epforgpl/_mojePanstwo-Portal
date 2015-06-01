<?
$this->Combinator->add_libs('css', $this->Less->css('view-zamowieniapubliczne', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-zamowieniapubliczne');

echo $this->Element('dataobject/pageBegin'); ?>

<div class="col-xs-12 col-md-8 objectMain">
    <div class="object">
        <div class="panel panel-default">
            <ul class="list-group">
                <? if (isset($details['czesci-wykonawcy'])) { ?>
                    <li class="list-group-item">
                        <div class="panel-heading">
                            <h3 class="panel-title">Wykonawcy</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover table-min">
                                <thead>
                                <tr>
                                    <? /*
                                    <th>Część</th>
                                    <th>Nazwa</th>
                                    <th>Liczba ofert</th>
                                    <th>Wykonawca</th>
                                    */ ?>
                                    <th>Liczba ofert / odrzuconych</th>
                                    <th>Cena</th>
                                    <th>Najniższa oferta</th>
                                    <th>Najwyższa oferta</th>
                                    <th>Wartość szacunkowa (bez VAT)</th>
                                    <? /*<th>Odrzucone oferty</th>*/ ?>
                                </tr>
                                </thead>
                                <tbody>
                                <? foreach ($details['czesci-wykonawcy'] as $item) { ?>
                                    <tr>
                                        <? /*
                                                                    <td>#<?= $item['numer'] ?></td>
                                                                    <td><?= $item['nazwa'] ?></td>
                                                                    <td><?= $item['liczba_ofert'] ?></td>
                                                                    <td><?= $item['wykonawcy'][0]['nazwa'] ?> (<?= $item['wykonawcy'][0]['miejscowosc'] ?>)</td>
                                                                    */ ?>
                                        <td><?= $item['liczba_ofert'] ?>
                                            / <?= $item['liczba_odrzuconych_ofert'] ?></td>
                                        <td><?= number_format_h($item['cena']) ?> <?= $item['waluta'] ?></td>
                                        <td><?= number_format_h($item['cena_min']) ?> <?= $item['waluta'] ?></td>
                                        <td><?= number_format_h($item['cena_max']) ?> <?= $item['waluta'] ?></td>
                                        <td><?= number_format_h($item['wartosc']) ?> <?= $item['waluta'] ?></td>
                                        <? /*<td><?= $item['liczba_odrzuconych_ofert'] ?></td>*/ ?>
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </div>
                    </li>
                <? } ?>
                <? if (isset($details['przedmiot'])) { ?>
                    <li class="list-group-item">
                        <div class="panel-heading">
                            <h3 class="panel-title">Przedmiot zamówienia</h3>
                        </div>
                        <div class="panel-body"><?php echo(nl2br($details['przedmiot'])); ?></div>
                    </li>
                <? } ?>

                <? if (@$details['siwz_www'] || @$details['siwz_adres']) { ?>
                    <li class="list-group-item">
                        <div class="panel-heading">
                            <h3 class="panel-title">Specyfikacja Istotnych Warunków Zamówienia</h3>
                        </div>
                        <div class="panel-body">
                            <? if (@$details['siwz_www']) { ?>
                                <p>
                                    <a target="_blank"
                                       href="<?= $details['siwz_www'] ?>"><?= $details['siwz_www'] ?></a>
                                </p>
                            <? } ?>
                            <? if (@$details['siwz_adres']) { ?>
                                <p><?= $details['siwz_adres'] ?></p>
                            <? } ?>
                        </div>
                    </li>
                <? } ?>

                <? if ((isset($details['oferty_data_stop']) && ($details['oferty_data_stop']) && ($details['oferty_data_stop'] != '0000-00-00')) || @$details['oferty_miejsce']) {
                    ?>
                    <li class="list-group-item">
                        <div class="panel-heading">
                            <h3 class="panel-title">Składanie ofert</h3>
                        </div>
                        <div class="panel-body">
                            <p>Oferty można składać do
                                <b><?= $this->Czas->dataSlownie($details['oferty_data_stop']) ?></b>, do
                                godziny
                                <b><?= $details['oferty_godz'] ?></b><? if (@$details['oferty_miejsce']) { ?>, w:<? } ?>
                            </p>
                            <? if (@$details['oferty_miejsce']) { ?>
                                <p><?= $details['oferty_miejsce'] ?></p><? } ?>
                        </div>
                    </li>
                <? } ?>

                <? foreach ($text_details as $key => $value) {
                    if ($value) {
                        ?>
                        <li class="list-group-item">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_' . $key)); ?></h3>
                            </div>
                            <div class="panel-body"><?php echo(nl2br($value)); ?></div>
                        </li>
                    <? }
                } ?>

            </ul>
            <div class="panel-footer">Źródło: <a
                    href="http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=<?= $details['data']['numer'] ?>&rok=<?= $details['data']['data'] ?>">
                    http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=<?= $details['data']['numer'] ?>
                    &rok=<?= $details['data']['data'] ?>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-4 dataFeed">
    <div class="object col-feed-main">
        <? echo $this->Element('Dane.DataFeed/feed-min'); ?>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>

<script type="text/javascript">
    var sources = <?= json_encode( $object->getLayer('sources') ) ?>;
</script>