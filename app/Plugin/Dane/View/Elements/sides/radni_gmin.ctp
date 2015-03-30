<div class="objectSideInner rrs">

    <? if ($radny->getData('aktywny') == '0') { ?>
        <div class="block">

            <ul class="dataHighlights side">

                <li class="dataHighlight">
                    <span class="label label-danger">Ta osoba nie jest już radnym</span>
                </li>

                <? /*
            <li class="dataHighlight">
                <p class="_label">Pozycja na liście</p>

                <p class="_value"><?= $radny->getData('pozycja'); ?></p>
            </li>

            <li class="dataHighlight">
                <p class="_label">Rok urodzenia</p>

                <p class="_value"><?= $radny->getData('rok_urodzenia'); ?></p>
            </li>
            */ ?>

            </ul>

        </div>
    <? } ?>

    <?
    /*

    $details = $radny->getLayer('details');
    $opis = preg_replace('/\<a (.*?)\>(.*?)\<\/a\>/i', '', $details['opis_html']);
    $opis = str_ireplace(array('- <br>'), '<br/>', $opis);

    if( $opis ) {
?>
    <div id="info" class="block">

        <div class="block-header">
            <h2 class="label">Życiorys</h2>
        </div>

        <div class="content">
            <?= stripslashes($opis) ?>
        </div>
    </div>
<? } */ ?>

    <div class="block">

        <div class="block-header">
            <h2 class="label">Aktywności</h2>
        </div>

        <ul class="dataHighlights side">

            <? if ($radny->getData('liczba_wystapien')) { ?>
                <li class="dataHighlight">
                    <a href="<?= $radny->getUrl() ?>/wystapienia"><span
                            class="icon icon-moon">&#xe615;</span>Wystąpienia <span
                            class="glyphicon glyphicon-chevron-right"></a>
                </li>
            <? } ?>

            <li class="dataHighlight">
                <a href="<?= $radny->getUrl() ?>/glosowania"><span class="glyphicon glyphicon-list"></span>Wyniki
                    głosowań <span class="glyphicon glyphicon-chevron-right"></a>
            </li>

            <? if ($radny->getData('liczba_interpelacji')) { ?>
                <li class="dataHighlight">
                    <a href="<?= $radny->getUrl() ?>/interpelacje"><span
                            class="icon icon-moon">&#xe614;</span>Interpelacje <span
                            class="glyphicon glyphicon-chevron-right"></a>
                </li>
            <? } ?>

            <li class="dataHighlight">
                <a href="<?= $radny->getUrl() ?>/komisje"><span class="icon icon-moon">&#xe613;</span>Przynależność
                    do komisji <span class="glyphicon glyphicon-chevron-right"></a>
            </li>
            
            <li class="dataHighlight">
                <a href="<?= $radny->getUrl() ?>/dyzury"><span class="glyphicon glyphicon-list"></span>Dyżury <span class="glyphicon glyphicon-chevron-right"></a>
            </li>

        </ul>

    </div>

    <? if ($radny->getData('liczba_oswiadczen') || $radny->getData('krs_osoba_id')) { ?>

        <div class="block">

            <div class="block-header">
                <h2 class="label">Informacje</h2>
            </div>

            <ul class="dataHighlights side">

                <? if ($radny->getData('liczba_oswiadczen')) { ?>
                    <li class="dataHighlight">
                        <a href="<?= $radny->getUrl() ?>/oswiadczenia"><span
                                class="icon icon-moon">&#xe61b;</span>Oświadczenia majątkowe <span
                                class="glyphicon glyphicon-chevron-right"></a>
                    </li>
                <? } ?>

                <? if ($radny->getData('krs_osoba_id')) { ?>
                    <li class="dataHighlight">
                        <a href="<?= $radny->getUrl() ?>/krs"><span class="icon icon-moon">&#xe611;</span>Powiązania
                            w KRS <span class="glyphicon glyphicon-chevron-right"></a>
                    </li>
                <? } ?>

            </ul>

        </div>

    <? } ?>

    <div class="block">

        <ul class="dataHighlights side">

            <li class="dataHighlight">
                <a target="_blank" href="<?= $radny->getLayer('bip_url') ?>"><span
                        class="glyphicon glyphicon-link"></span>Profil radnego w BIP <span
                        class="glyphicon glyphicon-chevron-right"></a>
            </li>

        </ul>

    </div>


</div>