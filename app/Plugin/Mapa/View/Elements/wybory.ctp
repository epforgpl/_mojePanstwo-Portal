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
                    <? if ($counters['sejm'] || $counters['senat'] || $counters['obwody']) {
                    if (isset($widget) && isset($_GET["redirect"])) { ?>
                        <script type="text/javascript">
                            try {
                                var params = {
                                    sejm_okreg_id: "<?= $array_column_sejm; ?>",
                                    senat_okreg_id: "<?= $array_column_senat; ?>",
                                    miejsce_id: "<?= $mapParams['data']['miejsca.id'] ?>"
                                };

                                if (params.sejm_okreg_id !== 0 && params.senat_okreg_id !== 0)
                                    parent.location.href = "http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm_i_senat/" + params.sejm_okreg_id + ',' + params.senat_okreg_id + '?miejsce_id=' + params.miejsce_id;
                            } catch (e) {
                            }
                        </script>
                    <? } ?>
                        <ul class="wybory meta">
                            <? if ($counters['sejm'] === 1) { ?>
                                <li>
                                    <label>Okręg do Sejmu:</label>
                                    <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $mapParams['elections']['sejm'][0]['key'] ?>"
                                       target="_parent"><?= $mapParams['elections']['sejm'][0]['key'] ?></a>
                                </li>
                            <? }
                            if ($counters['senat'] === 1) { ?>
                                <li>
                                    <label>Okręg do Senatu:</label>
                                    <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/senat/<?= $mapParams['elections']['senat'][0]['key'] ?>"
                                       target="_parent"><?= $mapParams['elections']['senat'][0]['key'] ?></a>
                                </li>
                            <? }
                            if ($counters['obwody'] === 1) { ?>
                                <li>
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
