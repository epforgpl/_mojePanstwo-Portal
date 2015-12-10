<? if (@$mapParams['mode'] == 'place') {
    if (@$mapParams['data'] && $mapParams['data']['miejsca.typ_id'] >= 2) {
        $counters = array(
            'sejm' => count(@$mapParams['elections']['sejm']),
            'senat' => count(@$mapParams['elections']['senat']),
            'obwody' => count(@$mapParams['elections']['obwody']),
        );

        if ($counters['sejm'] || $counters['senat'] || $counters['obwody']) {
            $ils = array();
            $array_column_sejm = array_column($mapParams['elections']['sejm'], 'key');
            $array_column_senat = array_column($mapParams['elections']['senat'], 'key');

            $array_column_sejm = (count($array_column_sejm) == 1) ? $array_column_sejm[0] : '0';
            $array_column_senat = (count($array_column_senat) == 1) ? $array_column_senat[0] : '0';

            if (isset($mapParams['elections']['obwody']))
                $ils = array_column($mapParams['elections']['obwody'], 'key');
            ?>
            <li class="accord accord-fullheight wyboryDetail<? if (!isset($widget)) {
                echo ' closed';
            } else {
                echo ' widget';
            } ?>"
                data-obwody="<?= @implode(',', $ils) ?>"
                data-sejm="<?= $array_column_sejm ?>"
                data-senat="<?= $array_column_senat ?>"
                data-miejsce="<?= $mapParams['data']['miejsca.id'] ?>"
                data-redirect="<?= (isset($_GET["redirect"])) ? true : false; ?>">
                <header>
                    <span class="arrow"></span>

                    <h2>Wybory parlamentarne 2015</h2>
                </header>
                <section class="dcontent">
                    <? if ($counters['sejm'] || $counters['senat'] || $counters['obwody']) { ?>
                        <ul class="wybory meta">
                            <? if ($counters['sejm'] > 0) { ?>
                                <li class="sejm">
                                    <label>Okręg do Sejmu:</label>
                                    <?
                                    if (gettype($mapParams['elections']['sejm']) == "string") { ?>
                                        <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $mapParams['elections']['sejm'] ?>"
                                           target="_parent"><?= $mapParams['elections']['sejm'] ?></a>
                                    <? } else {
                                        $sejmArray = array();
                                        foreach ($mapParams['elections']['sejm'] as $obwod_sejm) {
                                            $sejmArray[] = $obwod_sejm['key'];
                                        }
                                        sort($sejmArray);
                                        while (list($key, $val) = each($sejmArray)) { ?>
                                            <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $val ?>"
                                               target="_parent"><?= $val ?></a>
                                            <? if ($key !== count($sejmArray) - 1) echo '<span class="pull-left">, </span>';
                                        }
                                    } ?>
                                </li>
                            <? }
                            if ($counters['senat'] > 0) { ?>
                                <li class="senat">
                                    <label>Okręg do Senatu:</label>
                                    <?
                                    if (gettype($mapParams['elections']['senat']) == "string") { ?>
                                        <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $mapParams['elections']['senat'] ?>"
                                           target="_parent"><?= $mapParams['elections']['senat'] ?></a>
                                    <? } else {
                                        $senatArray = array();
                                        foreach ($mapParams['elections']['senat'] as $obwod_senat) {
                                            $senatArray[] = $obwod_senat['key'];
                                        }
                                        sort($senatArray);
                                        while (list($key, $val) = each($senatArray)) { ?>
                                            <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/senat/<?= $val ?>"
                                               target="_parent"><?= $val ?></a>
                                            <? if ($key !== count($senatArray) - 1) echo '<span class="pull-left">, </span>';
                                        }
                                    } ?>
                                </li>
                            <? }
                            if ($counters['obwody'] === 1) { ?>
                                <li class="obwod">
                                    <button
                                        data-target="<?= $mapParams['elections']['obwody'][0]['key'] ?>"
                                        disabled="disabled"
                                        class="btn-obwod btn btn-warning btn-sm margin-top-10">
                                        Pokaż lokal wyborczy
                                    </button>
                                </li>
                            <? } ?>
                        </ul>
                    <? } else { ?>
                        <p class="_msg">Użyj dokładniejszej lokalizacji, aby odnaleźć
                            właściwe okręgi wyborcze.</p>
                    <? } ?>
                </section>
            </li>
        <? }
    }
} ?>
