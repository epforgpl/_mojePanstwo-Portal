<? if ($radny->getData('aktywny') == '0') { ?>
    <ul class="dataHighlights col-xs-12">

        <li class="dataHighlight col-sm-6 col-sm-3">
            <span class="label label-danger">Ta osoba nie jest już radnym</span>
        </li>
    </ul>
<? } ?>
<ul class="dataHighlights col-xs-12">
    <li class="dataHighlight col-sm-6 col-sm-3">
        <a href="<?= $radny->getUrl() ?>/komisje"><span class="icon icon-moon">&#xe613;</span>Komisje <span
                class="glyphicon glyphicon-chevron-right"></a>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <a href="<?= $radny->getUrl() ?>/dyzury"><span class="glyphicon glyphicon-list"></span>Dyżury <span
                class="glyphicon glyphicon-chevron-right"></a>
    </li>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <a href="<?= $radny->getUrl() ?>/obietnice"><span class="glyphicon glyphicon-list"></span>Obietnice wyborcze
            <span class="glyphicon glyphicon-chevron-right"></a>
    </li>

    <? if ($radny->getData('krs_osoba_id')) { ?>
        <li class="dataHighlight col-sm-6 col-sm-3">
            <a href="<?= $radny->getUrl() ?>/krs"><span class="icon icon-moon">&#xe611;</span>Powiązania
                w KRS <span class="glyphicon glyphicon-chevron-right"></a>
        </li>
    <? } ?>

    <li class="dataHighlight col-sm-6 col-sm-3">
        <a target="_blank" href="<?= $radny->getLayer('bip_url') ?>"><span
                class="glyphicon glyphicon-link"></span>Profil radnego w BIP <span
                class="glyphicon glyphicon-chevron-right"></a>
    </li>
</ul>