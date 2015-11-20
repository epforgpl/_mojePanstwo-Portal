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

            foreach(array(
                'stan_zbiorki' => 'Stan',
                'dane_miejsce_zbiorki' => 'Miejsce',
                'dane_liczba_osob' => 'Liczba osób',
                'dane_cel_religijny' => 'Cel religijny',
                'dane_koszty_organizacji' => 'Koszty organizacji',
                'dane_koszty_ogolem' => 'Koszty ogółem',
                'dane_wynagrodzenia' => 'Wynagrodzenia',
                'dane_koszty_adminstracyjne' => 'Koszty administracyjne',
                'dane_sposob_przeprowadzenia' => 'Sposób przeprowadzenia',
                'data_wplywu' => 'Data wpływu',
                'dane_termin_od' => 'Termin od',
                'dane_termin_do' => 'Termin do',
            ) as $name => $label) {

                $field = $object->getData($name);
                if($field === false || $field === '')
                    continue;

                $numeric = in_array($name, $format_h);

            ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label"><?= $label ?></p>
                    <p class="_value">
                        <?= $numeric ? number_format_h($field) . ' zł' : $field ?>
                    </p>
                </li>
            <? } ?>
        </ul>
    </div>
    <div class="col-xs-12 col-md-9 objectMain">

        <? if ($dane_opis_celu = $object->getData('dane_opis_celu')) { ?>
            <div class="block block-simple col-xs-12">
                <header>Opis celu</header>
                <section class="content textBlock descBlock">
                    <?= $dane_opis_celu ?>
                </section>
            </div>
        <? } ?>

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

    </div>
</div>

<? echo $this->Element('dataobject/pageEnd');
