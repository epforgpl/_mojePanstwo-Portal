<?php $this->Combinator->add_libs('css', $this->Less->css('view-zamowieniapubliczne', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-zamowieniapubliczne'); ?>


<?= $this->Element('dataobject/pageBegin'); ?>

<div class="row">

    <div class="col-lg-3 objectSide">
        <div class="objectSideInner">


            <ul class="dataHighlights side">
                <li class="dataHighlight -block">
                    <?
                    if ($object->getData('status_id') == '0') {
                        ?>
                        <span class="label label-success">Zamówienie otwarte</span>
                    <?
                    } elseif ($object->getData('status_id') == '2') {
                        ?>
                        <span class="label label-danger">Zamówienie rozstrzygnięte</span>
                    <?
                    }
                    ?>
                </li>
                <? if ($object->getData('status_id') == '2') { ?>
                    <li class="dataHighlight big">
                        <p class="_label">Wartość udzielonego zamówienia</p>

                        <p class="_value"><?= _currency($object->getData('wartosc_cena')); ?></p>
                    </li>
                    <li class="dataHighlight" style="display: none;">
                        <p class="_label">Szacunkowa wartość zamówienia</p>

                        <p class="_value"><?= _currency($object->getData('wartosc_szacowana')); ?></p>
                    </li>
                <? } ?>
                <li class="dataHighlight">
                    <p class="_label">Zamawiający</p>

                    <p class="_value"><a
                            href="/dane/zamowienia_publiczne_zamawiajacy/<?= $object->getData('zamawiajacy_id'); ?>"><?= $object->getData('zamawiajacy_nazwa'); ?>
                            <br/><?= $object->getData('zamawiajacy_miejscowosc'); ?></a></p>
                </li>
                <li class="dataHighlight inl">
                    <p class="_label">Tryb</p>

                    <p class="_value"><?= $object->getData('zamowienia_publiczne_tryby.nazwa') ?></p>
                </li>
                <li class="dataHighlight inl">
                    <p class="_label">Rodzaj</p>

                    <p class="_value"><?= $object->getData('zamowienia_publiczne_rodzaje.nazwa') ?></p>
                </li>
				
				<? /*
                <? if (($object->getData('kryterium_kod') == 'A') || ($object->getData('kryterium_kod') == 'B')) { ?>
                    <li class="dataHighlight topborder">
                        <p class="_label">Kryteria</p>

                        <? if ($object->getData('kryterium_kod') == 'A') { ?>
                            <p class="_value">Najniższa cena</p>
                        <? } elseif (($object->getData('kryterium_kod') == 'B') && !empty($details['kryteria'])) { ?>

                            <ul class="_value ulx">
                                <? foreach ($details['kryteria'] as $kryterium) { ?>
                                    <li><?= $kryterium['nazwa'] ?> - <?= $kryterium['punkty'] ?>%</li>
                                <? } ?>
                            </ul>

                        <? } ?>

                    </li>
                <? } ?>

                <? if ($details['data_start'] && ($details['data_start'] != '0000-00-00')) { ?>
                    <li class="dataHighlight">
                        <p class="_label">Czas rozpoczęcia</p>

                        <p class="_value"><?= $this->Czas->dataSlownie($details['data_start']) ?></p>
                    </li>
                <? } ?>

                <? if ($details['data_stop'] && ($details['data_stop'] != '0000-00-00')) { ?>
                    <li class="dataHighlight">
                        <p class="_label">Czas trwania lub termin wykonania</p>

                        <p class="_value"><?= $this->Czas->dataSlownie($details['data_stop']) ?></p>
                    </li>
                <? } ?>
				
                <? if (@$details['czas_miesiace']) { ?>
                    <li class="dataHighlight">
                        <p class="_label">Czas trwania lub termin wykonania</p>

                        <p class="_value x"><?= pl_dopelniacz($details['czas_miesiace'], 'miesiąc', 'miesiące', 'miesięcy') ?></p>
                    </li>
                <? } ?>

                <? if (@$details['czas_dni']) { ?>
                    <li class="dataHighlight">
                        <p class="_label">Czas trwania lub termin wykonania</p>

                        <p class="_value x"><?= pl_dopelniacz($details['czas_dni'], 'dzień', 'dni', 'dni') ?></p>
                    </li>
                <? } ?>

                <? if (@$details['oferty_liczba_dni']) { ?>
                    <li class="dataHighlight">
                        <p class="_label">Termin związania ofertą</p>

                        <p class="_value x"><?= pl_dopelniacz($details['oferty_liczba_dni'], 'dzień', 'dni', 'dni') ?></p>
                    </li>
                <? } ?>


                <? */ ?>

                <li class="dataHighlight topborder -block">
                    <p class="_label">Źródło</p>

                    <p class="_value" id="sources"></p>
                </li>
            </ul>


            <? /*
                <h2><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_ZAMAWIAJACY')); ?></h2>

                <div class="content">
                    <ul>
                        <li class="title"><?php echo $object->getData('zamawiajacy_nazwa'); ?></li>
                        <li>
                            <a href="<?php echo (preg_match('/http\:\/\//', $object->getData('zamawiajacy_www'))) ? $object->getData('zamawiajacy_www') : 'http://' . $object->getData('zamawiajacy_www'); ?>"
                               target="_blank"><?php echo $object->getData('zamawiajacy_www'); ?></a></li>
                        <li>
                            <a href="mailto:<?php echo $object->getData('zamawiajacy_email'); ?>"><?php echo $object->getData('zamawiajacy_email'); ?></a>
                        </li>
                    </ul>
                </div>
				*/
            ?>


        </div>
    </div>

    <div class="col-lg-9 objectMain">
		
		<div class="row">
			<div class="col-lg-9 nopadding">
				
				<div class="object">
		            <?= $this->dataobject->feed($feed); ?>
		        </div>
        
			</div>
			<div class="col-lg-3">
				
				<ul class="object-actions-ul">
					<li>
						<p class="btn_cont">
							<button class="btn btn-success">Obserwuj...</button>
						</p>
						<p class="desc">
							Kliknij, aby otrzymywać powiadomienia o tym zamówieniu.
						</p>
					</li>
				</ul>
				
			</div>
			
		</div>
				
    </div>

</div>

<? /*
    <div class="object">
        <div class="documentMain col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_PRZEDMIOT')); ?></h2>
                </div>
                <div class="panel-body">
                    <?php echo($details['przedmiot']); ?>
                </div>
            </div>
        </div>
        <div class="documentInfo col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h2><?php echo __d('dane', __('LC_DANE_VIEW_ZAMOWIENIAPUBLICZNE_ZAMAWIAJACY')); ?></h2>
                </div>
                <div class="panel-body">
                    
                </div>
            </div>
        </div>
    </div>
    */
?>

<?= $this->Element('dataobject/pageEnd'); ?>

<script type="text/javascript">
    var sources = <?= json_encode( $object->getLayer('sources') ) ?>;
</script>