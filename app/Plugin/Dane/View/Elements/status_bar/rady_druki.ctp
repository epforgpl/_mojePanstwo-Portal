<ul class="dataHighlights col-xs-12">
    <?
    $tytul = $druk->getData('tytul');
    if (isset($tytul) && !empty($tytul)) { ?>
        <li class="dataHighlight big col-sm-6 col-sm-3">
            <p class="_label">Druk</p>

            <p class="_value"><?= $tytul; ?></p>
        </li>
    <? } ?>

    <?
    $date = $druk->getDate();
    if (isset($date) && !empty($date)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Data przedstawienia</p>

            <p class="_value"><?= dataSlownie($date); ?></p>
        </li>
    <? } ?>

    <?
    $autor_str = $druk->getData('autor_str');
    if (isset($autor_str) && !empty($autor_str)) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <p class="_label">Autor</p>

            <p class="_value"><?= $autor_str; ?></p>
        </li>
    <? } ?>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <a href="<?= $druk->getUrl() . '/tresc' ?>"><span class="icon icon-moon">&#xe610;</span>Treść
            druku<span class="glyphicon glyphicon-chevron-right"></span></a>
    </li>
</ul>