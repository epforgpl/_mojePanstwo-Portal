<a href="<? if (isset($id) && isset($biura[$id]['slug'])) { ?>/dane/poslowie_biura_wydatki/<?= $id ?>,<?= $biura[$id]['slug'] ?><? } else {
    echo '#';
}; ?>" target="_blank">
    <div class="stat <?= $slug ?>">

        <? /*<span data-toggle="tooltip" data-placement="bottom" title="<?= $biura[$id]['data']['poslowie_biura_wydatki.nazwa'] ?>"><?= $biura[$id]['data']['poslowie_biura_wydatki.nazwa'] ?></span>*/ ?>

        <? if (isset($biura[$id]['data']['poslowie_biura_wydatki.nazwa'])) { ?>
            <span><?= $biura[$id]['data']['poslowie_biura_wydatki.nazwa'] ?></span>
        <? } ?>

        <? if (isset($biura[$id]['data']['poslowie_biura_wydatki.wartosc_koszt_posel'])) { ?>
            <p class="srednio">
                <small class="l">Średnio na posła w 2013:</small>
            <span
                class="number"><?= number_format($biura[$id]['data']['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
                <small>PLN</small></span>
            </p>
        <? } ?>

        <? if (isset($biura[$id]['data']['poslowie_biura_wydatki.wartosc_koszt_posel_max'])) { ?>
            <p class="najwiecej">
                <small class="l">Najwięcej w 2013:</small>
            <span
                class="number"><?= number_format($biura[$id]['data']['poslowie_biura_wydatki.wartosc_koszt_posel_max'], 0, '.', ' ') ?>
                <small>PLN</small></span>
            </p>
        <? } ?>

        <p class="nposel">
            <? if (isset($biura[$id]['data']['ludzie_poslowie.mowca_id'])) { ?>
                <object data="/error/avatar.gif" type="image/png">
                    <img
                        src="http://resources.sejmometr.pl/mowcy/a/3/<?= $biura[$id]['data']['ludzie_poslowie.mowca_id'] ?>.jpg"/>
                </object>
            <? } ?>
            <? if (isset($biura[$id]['data']['poslowie.nazwa'])) { ?>
                <span><?= $biura[$id]['data']['poslowie.nazwa'] ?>
                    (<? if (isset($biura[$id]['data']['sejm_kluby.skrot'])) {
                        echo '(' . $biura[$id]['data']['sejm_kluby.skrot'] . ')';
                    } ?></span>
            <? } ?>
        </p>

    </div>
</a>