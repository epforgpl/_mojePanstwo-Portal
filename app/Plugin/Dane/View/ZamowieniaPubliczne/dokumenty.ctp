<?php $this->Combinator->add_libs('css', $this->Less->css('view-zamowieniapubliczne', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-zamowieniapubliczne'); ?>


<?
	
	echo $this->Element('dataobject/pageBegin');

	echo $this->Element('Dane.dataobject/subobject', array(
	    'menu' => false,
	    'object' => $dokument,
	    'objectOptions' => array(
	        'hlFields' => array(),
	        'bigTitle' => true,
	    ),
	    'back' => array(
	        'href' => $object->getUrl(),
	        'title' => 'Wszystkie aktualności dotyczące tego zamówienia',
	    ),
	    'titleTag' => 'p',
	));

?>

<div class="row">

    <div class="col-lg-12 objectMain">
	

        <div class="block-group">

			<? /*
            <? if ($object->getData('tryb_id') == 6) { ?>
                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Warunki licytacji elektronicznej</h2>
                    </div>
                    <div class="content">
                        <div class="textBlock">

                            <p>Wnioski o dopuszczenie do udziału w licytacji można składać do
                                <b><?= $this->Czas->dataSlownie($details['le_data_skl']) ?></b>, do godziny
                                <b><?= $details['le_godz_skl'] ?></b>, w:</p>

                            <p><?= @$details['le_miejsce_skl'] ?></p>

                            <p>Licytacja odbędzie się na stronie <a target="_blank"
                                                                    href="$details['le_adres_aukcja']"><?= $details['le_adres_aukcja'] ?></a><? if ($details['le_adres_opis']) { ?> (
                                    <a target="_blank" href="<?= $details['le_adres_opis'] ?>">dodatkowe
                                        informacje</a>)<? } ?>.</p>

                            <? if ($details['le_term_otw']) { ?><p>Termin otwarcia
                                licytacji: <?= $details['le_term_otw'] ?>
                                .</p><? } ?>
                            <? if ($details['le_term_war_zam']) { ?><p>Termin zamknięcia
                                licytacji: <?= $details['le_term_war_zam'] ?>.</p><? } ?>
                        </div>
                    </div>
                </div>
            <? } ?>


            <?
            $czesci = $object->getLayer('czesci');
            $liczba_czesci = $czesci ? count($czesci) : 0;


            if (!$liczba_czesci) {
                ?>

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Przedmiot zamówienia</h2>
                    </div>
                    <div class="content">
                        <div class="textBlock"><?php echo(nl2br($details['przedmiot'])); ?></div>
                    </div>
                </div>

            <?
            }

            if (!empty($czesci)) {
                foreach ($czesci as $czesc) {
                    ?>

                    <? if ($liczba_czesci == 0) { ?>

                        <div class="block">
                            <div class="block-header">
                                <h2 class="label">Przedmiot zamówienia</h2>
                            </div>
                            <div class="content">
                                <div class="textBlock"><?php echo(nl2br($details['przedmiot'])); ?></div>
                            </div>
                        </div>

                    <? } else { ?>
                        <div class="block">

                            <? if ($liczba_czesci > 1) { ?>
                                <div class="block-header">
                                    <h2 class="label">Część #<?= $czesc['numer'] ?> - <?= $czesc['nazwa'] ?></h2>
                                </div>
                            <? } ?>


                            <div class="content nopadding">
                                <div class="textBlock">

                                    <? if (!empty($czesc['wykonawcy']) || @$czesc['cena']) { ?>
                                        <div class="row header-details dataHighlights">

                                            <? if (!empty($czesc['wykonawcy'])) { ?>
                                                <div class="dataHighlight col-lg-8">
                                                    <p class="_label">Wykonawca</p>
                                                    <? foreach ($czesc['wykonawcy'] as $wykonawca) { ?>
                                                        <p class="_value"><a
                                                                href="/dane/zamowienia_publiczne_wykonawcy/<?= $wykonawca['id'] ?>"><?= $wykonawca['nazwa']; ?></a>
                                                        </p>
                                                    <? } ?>
                                                </div>
                                            <? } ?>

                                            <? if ($liczba_czesci > 1 && $czesc['cena']) { ?>
                                                <div class="dataHighlight col-lg-4">
                                                    <p class="_label">Cena</p>

                                                    <p class="_value big"><?= _currency($czesc['cena']); ?></p>
                                                </div>
                                            <? } ?>

                                        </div>
                                    <? } ?>

                                    <div class="row part-details dataHighlights">

                                        <? if ((@$czesc['kryterium'] == 'A') || (@$czesc['kryterium'] == 'B')) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Kryteria</p>

                                                <? if ($czesc['kryterium'] == 'A') { ?>
                                                    <p class="_value">Najniższa cena</p>
                                                <? } elseif (($czesc['kryterium'] == 'B') && !empty($czesc['kryteria'])) { ?>

                                                    <ul class="_value">
                                                        <? foreach ($czesc['kryteria'] as $kryterium) { ?>
                                                            <li><?= $kryterium['nazwa'] ?>
                                                                - <?= $kryterium['punkty'] ?>%
                                                            </li>
                                                        <? } ?>
                                                    </ul>

                                                <? } ?>

                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['cena_min']) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Cena najtańszej oferty</p>

                                                <p class="_value"><?= _currency($czesc['cena_min']); ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['cena_max']) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Cena najdroższej oferty</p>

                                                <p class="_value"><?= _currency($czesc['cena_max']); ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['wartosc']) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Szacunkowa wartość zamówienia (bez VAT)</p>

                                                <p class="_value"><?= _currency($czesc['wartosc']); ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['liczba_ofert']) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Liczba otrzymanych ofert</p>

                                                <p class="_value"><?= $czesc['liczba_ofert']; ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['liczba_ofert']) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Liczba odrzuconych ofert</p>

                                                <p class="_value"><?= $czesc['liczba_odrzuconych_ofert']; ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['data_zam'] && ($czesc['data_zam'] != '0000-00-00')) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Data udzielenia zamówienia</p>

                                                <p class="_value"><?= $this->Czas->dataSlownie($czesc['data_zam']) ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['czas_mies']) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Czas trwania lub termin wykonania</p>

                                                <p class="_value x"><?= pl_dopelniacz($czesc['czas_mies'], 'miesiąc', 'miesiące', 'miesięcy') ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['data_rozpoczecia'] && ($czesc['data_rozpoczecia'] != '0000-00-00')) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Termin rozpoczęcia</p>

                                                <p class="_value"><?= $this->Czas->dataSlownie($czesc['data_rozpoczecia']) ?></p>
                                            </div>
                                        <? } ?>

                                        <? if (@$czesc['data_zakonczenia'] && ($czesc['data_zakonczenia'] != '0000-00-00')) { ?>
                                            <div class="dataHighlight col-lg-4">
                                                <p class="_label">Termin wykonania</p>

                                                <p class="_value"><?= $this->Czas->dataSlownie($czesc['data_zakonczenia']) ?></p>
                                            </div>
                                        <? } ?>

                                    </div>

                                    <? if (isset($czesc['opis'])) { ?>
                                        <p class="opis"><?= nl2br($czesc['opis']) ?></p>
                                    <? } ?>

                                </div>
                            </div>

                        </div>

                        <? if ($liczba_czesci <= 1) { ?>
                            <div class="block">
                                <div class="block-header">
                                    <h2 class="label">Przedmiot zamówienia</h2>
                                </div>
                                <div class="content">
                                    <div class="textBlock"><?php echo(nl2br($details['przedmiot'])); ?></div>
                                </div>
                            </div>
                        <? } ?>

                    <? } ?>

                <?
                }
            }
            ?>
            */ ?>

            
            
            <?= $this->element('objects/zamowienia_publiczne_dokumenty/typy/' . $dokument->getData('typ_id')); ?>			
			

        </div>


    </div>

</div>


<?= $this->Element('dataobject/pageEnd'); ?>

<script type="text/javascript">
    var sources = <?= json_encode( $object->getLayer('sources') ) ?>;
</script>