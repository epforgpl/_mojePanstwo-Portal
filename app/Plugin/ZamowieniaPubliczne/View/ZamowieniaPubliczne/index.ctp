<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne'))) ?>

<?php $this->Combinator->add_libs('js', '../plugins/highstock/js/highstock'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highstock/locals'); ?>
<?php $this->Combinator->add_libs('js', 'ZamowieniaPubliczne.zamowieniapubliczne') ?>
<?php $this->Combinator->add_libs('js', 'Dane.dataobjectsslider') ?>

<?= $this->Element('appheader', array('title' => 'Zamówienia publiczne', 'subtitle' => 'Sprawdzaj jak Państwo wydaje Twoje pieniądze', 'headerUrl' => 'zamowienia-publiczne.png')); ?>

<div class="container" id="zamowienia">

    <? /*
    <div class="main-alert alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Uwaga!</h4>

        <p>To jest eksperymentalna wersja aplikacji Zamówienia Publiczne, oparta na analize
            <b><?= $stats['progress'] ?>%</b> zamowień publicznych, ogłaszanych przez Urząd Zamówień
            Publicznych. Więcej danych i funkcjonalności pojawi się wkrótce.</p>
    </div>
    */
    ?>

    <div class="banner">
        <p>W ciągu <b>ostatniego miesiąca</b>, Twoje Państwo
            udzieliło <?= pl_dopelniacz($stats['liczba_zamowien'], 'zamówienie publiczne', 'zamówienia publiczne', 'zamówień publicznych') ?>
            , na kwotę:</p>


        <p class="number"><?= $this->Waluta->slownie($stats['suma_zamowien']) ?></p>

    </div>

    <div>

        <div class="row block zam-block">

            <? $i = 0;
            foreach ($stats['rodzaje'] as $rodzaj) {
                $i++; ?>
                <div class="col-lg-4 column">

                    <p class="text-center na"><span class="label label-primary"><?= $rodzaj['nazwa'] ?></span></p>

                    <p class="number small text-center"><?= $this->Waluta->slownie($rodzaj['suma_zamowien']) ?></p>


                </div>
                <? if ($i > 2) {
                    break;
                }
            } ?>

        </div>

        <div class="row block zam-block">

            <div class="col-lg-6 column">

                <div class="block-header">
                    <h2 class="label">Najwięcej zamówili:</h2>
                </div>

                <ul>
                    <? foreach ($stats['zamawiajacy'] as $zamawiajacy) { ?>
                        <li>
                            <p class="title"><a
                                    href="/dane/zamowienia_publiczne/?zamawiajacy_id[]=<?= $zamawiajacy['id'] ?>&status_id=2&data_publikacji=LAST_1M&search=web"
                                    title="<?= addslashes($zamawiajacy['nazwa']) ?>"><?= $this->Text->truncate($zamawiajacy['nazwa'], 100); ?></a>
                            </p>

                            <p class="desc"><?= pl_dopelniacz($zamawiajacy['liczba_zamowien'], 'zamówienie', 'zamówienia', 'zamówień') ?>
                                na kwotę <?= $this->Waluta->slownie($zamawiajacy['suma_zamowien']) ?></p>
                        </li>
                    <? } ?>
                </ul>

            </div>

            <div class="col-lg-6 column">

                <div class="block-header">
                    <h2 class="label">Najwięcej zamówień otrzymali:</h2>
                </div>

                <p class="soon">Dostępne wkrótce</p>

                <? /*
				<ul>
				<? foreach( $rodzaj['zamawiajacy'] as $zamawiajacy ) {?>
					<li>
						<p class="title"><a href="#" title="<?= addslashes($zamawiajacy['nazwa']) ?>"><?= $this->Text->truncate($zamawiajacy['nazwa'], 100); ?></a></p>
						<p class="desc"><?= pl_dopelniacz($zamawiajacy['liczba_zamowien'], 'zamówienie', 'zamówienia', 'zamówień') ?> na kwotę <?= $this->Waluta->slownie($zamawiajacy['wartosc']) ?></p>
					</li>
				<?}?>
				</ul>	
				*/
                ?>

            </div>


        </div>

    </div>




    <? /*
    <div class="banner">
        <h1><?php echo __d('zamowienia_publiczne', "LC_ZAMOWIENIA_PUBLICZNE_HEADLINE"); ?></h1>

        <p><?php echo __d('zamowienia_publiczne', "LC_ZAMOWIENIA_PUBLICZNE_SUBHEADLINE"); ?></p>
    </div>
	*/
    ?>


    <? /*
    <div class="dataobjectsSliderRow">
        <div class="row header">
            <div class="col-xs-12 col-sm-6 left">
                <h2>
                    <a href="/dane/zamowienia_publiczne?rodzaj_id=2"><?php echo __d('zamowienia_publiczne', "LC_ZAMOWIENIA_PUBLICZNE_USLUGI"); ?></a>
                </h2>
            </div>
            <div class="col-xs-6 col-xs-offset-6 col-sm-6 col-sm-offset-0 right">

            </div>
        </div>
        <div class="blockContent">
            <?php echo $this->dataobjectsSlider->render($uslugi, array('rowNumber' => 1)); ?>
        </div>
    </div>

    <div class="dataobjectsSliderRow">
        <div class="row header">
            <div class="col-xs-12 col-sm-6 left">
                <h2>
                    <a href="/dane/zamowienia_publiczne?rodzaj_id=3"><?php echo __d('zamowienia_publiczne', "LC_ZAMOWIENIA_PUBLICZNE_DOSTAWY_SPRZETU_I_MATERIALOW"); ?></a>
                </h2>
            </div>
            <div class="col-xs-6 col-xs-offset-6 col-sm-6 col-sm-offset-0 right">

            </div>
        </div>
        <div class="blockContent">
            <?php echo $this->dataobjectsSlider->render($dostawy, array('rowNumber' => 1)); ?>
        </div>
    </div>

    <div class="dataobjectsSliderRow">
        <div class="row header">
            <div class="col-xs-12 col-sm-6 left">
                <h2>
                    <a href="/dane/zamowienia_publiczne?rodzaj_id=1"><?php echo __d('zamowienia_publiczne', "LC_ZAMOWIENIA_PUBLICZNE_ROBOTY_BUDOWLANE"); ?></a>
                </h2>
            </div>
            <div class="col-xs-6 col-xs-offset-6 col-sm-6 col-sm-offset-0 right">

            </div>
        </div>
        <div class="blockContent">
            <?php echo $this->dataobjectsSlider->render($roboty, array('rowNumber' => 1)); ?>
        </div>
    </div>
    */
    ?>


</div>