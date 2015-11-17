<?
$this->Combinator->add_libs('css', $this->Less->css('view-zamowieniapubliczne', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-zamowieniapubliczne');

echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">

    <div class="col-md-12 objectMain feed-content">
        <div class="row dataBrowser dataFeed">

            <div class="col-xs-12 col-sm-8">
                <div class="object">

                    <div class="block-group col-xs-12">

                        <? if (isset($details['czesci-wykonawcy'])) { ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="block">
                                        <div class="block-header">
                                            <h2 class="label">Wykonawcy</h2>
                                        </div>
                                        <div class="content">

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
                                                <? foreach ($details['czesci-wykonawcy'] as $item) { ?>
                                                    <tr>
                                                        <td><?= $item['liczba_ofert'] ?>
                                                            / <?= $item['liczba_odrzuconych_ofert'] ?></td>
                                                        <td><?= number_format_h($item['cena']) ?> <?= $item['waluta'] ?></td>
                                                        <td><?= number_format_h($item['cena_min']) ?> <?= $item['waluta'] ?></td>
                                                        <td><?= number_format_h($item['cena_max']) ?> <?= $item['waluta'] ?></td>
                                                        <td><?= number_format_h($item['wartosc']) ?> <?= $item['waluta'] ?></td>
                                                    </tr>
                                                <? } ?>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>


                                </div>
                            </div>
                        <? } ?>

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">

                                <? if (isset($details['przedmiot'])) { ?>
                                    <div class="block">
                                        <div class="block-header">
                                            <h2 class="label">Przedmiot zamówienia</h2>
                                        </div>
                                        <div class="content">
                                            <div class=""><?php echo(nl2br($details['przedmiot'])); ?></div>
                                        </div>
                                    </div>
                                <? } ?>

                                <? if (@$details['siwz_www'] || @$details['siwz_adres']) { ?>
                                    <div class="block">
                                        <div class="block-header">
                                            <h2 class="label">Specyfikacja Istotnych Warunków Zamówienia</h2>
                                        </div>

                                        <div class="content">
                                            <div class="">
                                                <? if (@$details['siwz_www']) { ?><p><a target="_blank"
                                                                                        href="<?= $details['siwz_www'] ?>"><?= $details['siwz_www'] ?></a>
                                                    </p><? } ?>
                                                <? if (@$details['siwz_adres']) { ?>
                                                    <p><?= $details['siwz_adres'] ?></p><? } ?>
                                            </div>
                                        </div>

                                    </div>
                                <? } ?>

                                <? if (
                                    (
                                        isset($details['oferty_data_stop']) &&
                                        ($details['oferty_data_stop']) &&
                                        ($details['oferty_data_stop'] != '0000-00-00')
                                    ) ||
                                    @$details['oferty_miejsce']
                                ) {
                                    ?>

                                    <div class="block">
                                        <div class="block-header">
                                            <h2 class="label">Składanie ofert</h2>
                                        </div>

                                        <div class="content">
                                            <div class="">
                                                <p>Oferty można składać do
                                                    <b><?= $this->Czas->dataSlownie($details['oferty_data_stop']) ?></b>,
                                                    do
                                                    godziny
                                                    <b><?= $details['oferty_godz'] ?></b><? if (@$details['oferty_miejsce']) { ?>, w:<? } ?>
                                                </p>
                                                <? if (@$details['oferty_miejsce']) { ?>
                                                    <p><?= $details['oferty_miejsce'] ?></p><? } ?>
                                            </div>
                                        </div>

                                    </div>

                                <? } ?>



                                <?
                                foreach ($text_details as $key => $value) {
                                    if ($value) {
                                        ?>

                                        <div class="block">
                                            <div class="block-header">
                                                <h2 class="label"><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_' . $key)); ?></h2>
                                            </div>

                                            <div class="content">

                                                <div class=""><?php echo(nl2br($value)); ?></div>

                                            </div>
                                        </div>

                                        <?
                                    }
                                } ?>

                                <p class="text-center"><a target="_blank"
                                                          href="http://bzp1.portal.uzp.gov.pl/index.php?ogloszenie=show&pozycja=<?= $details['data']['numer'] ?>&rok=<?= $details['data']['data'] ?>">Źródło</a>
                                </p>


                            </div>
                        </div>


                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-feed-main">
                <div class="object">
                    <? echo $this->Element('Dane.DataFeed/feed-min'); ?>
                </div>
            </div>


        </div>

    </div>

</div>

<?= $this->Element('dataobject/pageEnd'); ?>

<script type="text/javascript">
    var sources = <?= json_encode( $object->getLayer('sources') ) ?>;
</script>
