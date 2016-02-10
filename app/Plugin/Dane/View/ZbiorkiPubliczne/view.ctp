<? 	echo $this->Combinator->add_libs('css', $this->Less->css('view-zbiorki_publiczne', array('plugin' => 'Dane'))); ?>
<?= $this->Element('dataobject/pageBegin') ?>

<div class="zbiorkiPubliczne margin-top-10">
    <div class="col-xs-12 col-md-3 objectSide">
        <ul class="dataHighlights overflow-auto">
            <?php

            $format_h = array(
                'dane_koszty_organizacji',
                'dane_koszty_ogolem',
                'dane_wynagrodzenia',
                'dane_koszty_adminstracyjne',
            );
            
            $format_date = array(
                'dane_termin_od',
                'dane_termin_do',
                'data_wplywu',
            );

            foreach(array(
                'stan_zbiorki' => 'Stan',
                'dane_sposob_przeprowadzenia' => 'Sposób przeprowadzenia',
                'dane_miejsce_zbiorki' => 'Miejsce',
                'dane_liczba_osob' => 'Liczba osób',
                'data_wplywu' => 'Data wpływu',
                'dane_termin_od' => 'Termin od',
                'dane_termin_do' => 'Termin do',
                'dane_cel_religijny' => 'Cel religijny',
            ) as $name => $label) {

                $field = $object->getData($name);
                if($field === false || $field === '')
                    continue;

                $numeric = in_array($name, $format_h);
                $date = in_array($name, $format_date);

            ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label"><?= $label ?></p>
                    <p class="_value">
                        <?
	                        if( $numeric )
	                        	echo number_format_h($field) . ' zł';
	                        elseif( $date )
	                        	echo dataSlownie($field);
	                        else
	                        	echo $field;	                        
                        ?>
                    </p>
                </li>
            <? } ?>
        </ul>

        <div class="margin-top-10">
            <p class="_src text-left">
                <a href="http://zbiorki.gov.pl/zbiorki/zbiorki/szczegoly-zbiorki.xhtml?zbiorka_nazwa=<?= urlencode($object->getData('nazwa_zbiorki')) ?>" target="_blank">
                    <span class="glyphicon glyphicon-link"></span> Źródło</a>
            </p>
        </div>
    </div>
    <div class="col-xs-12 col-md-9 objectMain">
		
		
		
        <? if ($dane_dodatkowe_informacje = $object->getData('dane_dodatkowe_informacje')) { ?>
            <div class="block block-simple col-xs-12">
                <header>Dodatkowe informacje</header>
                <section class="content textBlock descBlock">
                    <?= $dane_dodatkowe_informacje ?>
                </section>
            </div>
        <? } ?>

        <? if ($dane_koszty_dodatkowe_informacje = $object->getData('dane_koszty_dodatkowe_informacje')) { ?>
            <div class="block block-simple col-xs-12">
                <header>Koszty</header>
                <section class="content textBlock descBlock">
                    <?= $dane_koszty_dodatkowe_informacje ?>
                </section>
            </div>
        <? } ?>

        <? if ($spr_rozliczenie_dodatkowe_informacje = $object->getData('spr_rozliczenie_dodatkowe_informacje')) { ?>
            <div class="block block-simple col-xs-12">
                <header>Rozliczenie</header>
                <section class="content textBlock descBlock">
                    <?= $spr_rozliczenie_dodatkowe_informacje ?>
                </section>
            </div>
        <? } ?>

        <? if ($spr_przeprowadzenia_dodatkowe_informacje = $object->getData('spr_przeprowadzenia_dodatkowe_informacje')) { ?>
            <div class="block block-simple col-xs-12">
                <header>Sposób przeprowadzenia</header>
                <section class="content textBlock descBlock">
                    <?= $spr_przeprowadzenia_dodatkowe_informacje ?>
                </section>
            </div>
        <? } ?>
        
        <div class="block block-simple col-xs-12">
	        <header>Koszty zbiórki</header>
			<div class="_numbers row">
	            <?php
	
	            $format_h = array(
	                'dane_koszty_organizacji',
	                'dane_koszty_ogolem',
	                'dane_wynagrodzenia',
	                'dane_koszty_adminstracyjne',
	            );
	
	            foreach(array(
	                'dane_koszty_organizacji' => 'Koszty organizacji',
	                'dane_koszty_ogolem' => 'Koszty ogółem',
	                'dane_wynagrodzenia' => 'Wynagrodzenia',
	                'dane_koszty_adminstracyjne' => 'Koszty administracyjne',                
	            ) as $name => $label) {
	
	                $field = $object->getData($name);
	                if($field === false || $field === '')
	                    continue;
	
	                $numeric = in_array($name, $format_h);
	
	            ?>
	                <div class="_number col-sm-3 text-center">
	                    <p class="_label"><?= $label ?></p>
	                    <p class="_value">
	                        <?= $numeric ? number_format_h($field) . ' zł' : $field ?>
	                    </p>
	                </div>
	            <? } ?>
	        </div>
		</div>

    </div>
</div>

<? echo $this->Element('dataobject/pageEnd');
