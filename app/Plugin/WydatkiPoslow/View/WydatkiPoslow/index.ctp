<?php $this->Combinator->add_libs('css', $this->Less->css('new-look')) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('wydatki_poslow', array('plugin' => 'WydatkiPoslow'))); ?>
<?php $this->Combinator->add_libs('js', 'WydatkiPoslow.libs.js'); ?>
<?php $this->Combinator->add_libs('js', 'WydatkiPoslow.wydatki_poslow.js'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.naglosnij.js'); ?>

<div id="storyLine">
<div class="innerStory">
<div class="far">
    <div class="clouds"></div>
</div>
<div class="medium">
<div class="scene intro" data-scene="1">
    <div class="title">
        <h3>Sprawdź na co posłowie wydają publiczne pieniądze</h3>

    </div>
    <div class="scrollHint">
        <img src="/WydatkiPoslow/img/mysz.svg" class="scrollInfo"/>
        <img src="/WydatkiPoslow/img/poslanka.svg" class="poslankaBckgrnd"/>
        <img src="/WydatkiPoslow/img/posel.svg" class="poselBckgrnd"/>
	    <a target="_blank" class="wszystkie btn btn-primary" href="/dane/poslowie_biura_wydatki">Zobacz wszystkie dane w formie listy &raquo;</a>

        <div class="social"></div>

    </div>

	<? /*
    <a class="wyjazdyBtn" href="/wyjazdy_poslow" target="_self">Dodatkowo<br>sprawdź gdzie<br>i za ile
        wyjażdzają<br>posłowie<i class="glyphicon glyphicon-chevron-right"></i></a>
    */ ?>
</div>
<div class="scene sejm" data-scene="2">

    <div class="building"></div>


    <div class="stat wyplacane">
        <span data-toggle="tooltip" data-placement="bottom"
              title="Kwota obejmuje wydatki na uposażenia poselskie wraz z pochodnymi, dodatki do uposażeń, odprawy emerytalne oraz wynagrodzenie Prezydium Sejmu">Wynagrodzenie</span>

        <p class="srednio">
            <small class="l">Średnio na posła w 2013:</small>
        	<span class="number"><?= number_format((54889000+7305000+985000)/460, 0, '.', ' ') ?> <small>PLN</small></span>
        </p>

    </div>

    <div class="stat diety">
        <span>Dieta</span>

        <p class="srednio">
            <small class="l">Średnio na posła w 2013:</small>
        	<span class="number"><?= number_format((13607000)/460, 0, '.', ' ') ?> <small>PLN</small></span>
        </p>

    </div>

</div>
<div class="scene biuro" data-scene="3">

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 9,
	    'slug' => 'biura'
	)) ?>

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 1,
	    'slug' => 'pracownikow'
	)) ?>

    <? /*
    <div class="stat konserwacje">
        <span data-toggle="tooltip" data-placement="bottom"
              title="<?= $biura[13]['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[13]['poslowie_biura_wydatki.nazwa'] ?></span>
        <strong><?= number_format($biura[13]['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
            <small>PLN</small>
        </strong>

        <div class="sub">Średni miesięczny koszt poniesiony w 2013 r.</div>
    </div>
    <div class="stat naprawy">
        <span data-toggle="tooltip" data-placement="bottom"
              title="<?= $biura[14]['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[14]['poslowie_biura_wydatki.nazwa'] ?></span>
        <strong><?= number_format($biura[14]['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
            <small>PLN</small>
        </strong>

        <div class="sub">Średni miesięczny koszt poniesiony w 2013 r.</div>
    </div>
    */ ?>
    <div class="marker"></div>
</div>
<div class="scene sklep" data-scene="4">

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 10,
	    'slug' => 'materialy'
	)) ?>

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 11,
	    'slug' => 'srodki'
	)) ?>

    <div class="marker"></div>
</div>

<? /*
<div class="scene szpital" data-scene="5">
    <div class="stat korespondencja">
        <span data-toggle="tooltip" data-placement="bottom"
              title="<?= $biura[8]['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[8]['poslowie_biura_wydatki.nazwa'] ?></span>
        <strong><?= number_format($biura[8]['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
            <small>PLN</small>
        </strong>

        <div class="sub">Średni miesięczny koszt poniesiony w 2013 r.</div>
    </div>
    <div class="stat badania">
        <span data-toggle="tooltip" data-placement="bottom"
              title="<?= $biura[3]['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[3]['poslowie_biura_wydatki.nazwa'] ?></span>
        <strong><?= number_format($biura[3]['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
            <small>PLN</small>
        </strong>

        <div class="sub">Średni miesięczny koszt poniesiony w 2013 r.</div>
    </div>
    <div class="stat swiadczenia">
        <span data-toggle="tooltip" data-placement="bottom"
              title="<?= $biura[19]['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[19]['poslowie_biura_wydatki.nazwa'] ?></span>
        <strong><?= number_format($biura[19]['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
            <small>PLN</small>
        </strong>

        <div class="sub">Średni miesięczny koszt poniesiony w 2013 r.</div>
    </div>
</div>
<div class="scene bank" data-scene="6">
    <div class="stat rachunki">
        <span data-toggle="tooltip" data-placement="bottom"
              title="<?= $biura[20]['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[20]['poslowie_biura_wydatki.nazwa'] ?></span>
        <strong><?= number_format($biura[20]['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
            <small>PLN</small>
        </strong>

        <div class="sub">Średni miesięczny koszt poniesiony w 2013 r.</div>
    </div>
</div>
<? */ ?>
<div class="scene spotkanie" data-scene="7">
    <div class="name">
        <p>Spotkanie z posłem</p>
    </div>
    <div class="men"></div>

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 6,
	    'slug' => 'sala'
	)) ?>

    <div class="marker"></div>
</div>
<div class="scene tlumaczenia" data-scene="8">

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 7,
	    'slug' => 'przejazd'
	)) ?>

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 3,
	    'slug' => 'ekspertyzy'
	)) ?>

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 2,
	    'slug' => 'zlecenia'
	)) ?>

    <div class="marker"></div>
</div>
<div class="scene dom" data-scene="9">

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 4,
	    'slug' => 'telefonPosel'
	)) ?>


    <div class="stat prywatny">
        <span data-toggle="tooltip" data-placement="bottom"
              title="Posłom, którzy nie są zameldowani na pobyt stały w Warszawie i nie posiadają innego uprawnienia do zakwaterowania na terenie tego miasta przysługuje refundacja kosztów za najem kwatery prywatnej">Koszty wynajmu kwater prywatnych</span>

        <p class="srednio">
            <small class="l">Średnio na posła w 2013:</small>
        	<span class="number"><?= number_format((4239804)/460, 0, '.', ' ') ?> <small>PLN</small></span>
        </p>

    </div>

</div>
<div class="scene droga" data-scene="10">

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 8,
	    'slug' => 'taksowka'
	)) ?>

    <div class="marker"></div>
</div>
<div class="scene lotnisko" data-scene="11">
    <div class="building"></div>

    <?= $this->element('WydatkiPoslow.stat', array(
	    'id' => 12,
	    'slug' => 'loty'
	)) ?>

    <div class="marker"></div>
</div>
<div class="scene lot" data-scene="12"></div>
<div class="scene stats" data-scene="13">
    <div class="screen">

        <div class="scrollHint">
	        <img src="/WydatkiPoslow/img/jeszczeRaz.svg" class="scrollInfo repeat"/>
	        <img src="/WydatkiPoslow/img/poslanka.svg" class="poslankaBckgrnd"/>
	        <img src="/WydatkiPoslow/img/posel.svg" class="poselBckgrnd"/>
		    <a target="_blank" class="wszystkie btn btn-primary" href="/dane/poslowie_biura_wydatki">Zobacz wszystkie dane w formie listy &raquo;</a>

            <div class="social">
                <div>
	    </div>

            </div>
</div>
</div>
<div class="near">
    <div class="posel"></div>
    <div class="samochod"></div>
    <div class="taxi"></div>
    <div class="samolot"></div>
</div>
</div>
</div>