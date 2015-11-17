<a href="/dane/poslowie_biura_wydatki/<?= $id ?>,<?= $biura[$id]['slug'] ?>" target="_blank">
    <div class="stat <?= $slug ?>">
        <span><?= $biura[$id]['data']['poslowie_biura_wydatki.nazwa'] ?></span>

        <p class="srednio">
            <small class="l">Średnio na posła w 2013:</small>
            <span
                class="number"><?= number_format($biura[$id]['data']['poslowie_biura_wydatki.wartosc_koszt_posel'], 0, '.', ' ') ?>
                <small>PLN</small></span>
        </p>

        <p class="najwiecej">
            <small class="l">Najwięcej w 2013:</small>
            <span
                class="number"><?= number_format($biura[$id]['data']['poslowie_biura_wydatki.wartosc_koszt_posel_max'], 0, '.', ' ') ?>
                <small>PLN</small></span>
        </p>

        <p class="nposel">
            <img onerror="imgFixer(this)"
                 src="http://resources.sejmometr.pl/mowcy/a/3/<?= $biura[$id]['data']['ludzie_poslowie.mowca_id'] ?>.jpg"/>
            <span><?= $biura[$id]['data']['poslowie.nazwa'] ?> (<?= $biura[$id]['data']['sejm_kluby.skrot'] ?>)</span>
        </p>

    </div>
</a>
