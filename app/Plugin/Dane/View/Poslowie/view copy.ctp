<?= $this->Element('dataobject/pageBegin'); ?>

<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-poslowie.js');
echo $this->Html->script('../plugins/TimelineJS/build/js/storyjs-embed.js', array('block' => 'scriptBlock'));

function progress($statMin, $statMax, $poselGlobalStat, $poselTargetStat, $numberType = '')
{
    $progressWidth = $statMax - $statMin;
    $firstStat = ($poselTargetStat < $poselGlobalStat) ? $poselTargetStat : $poselGlobalStat;
    $secondStat = ($poselTargetStat < $poselGlobalStat) ? $poselGlobalStat : $poselTargetStat;
    $firstClass = 'global';
    $secondClass = ($poselTargetStat < $poselGlobalStat) ? 'bad' : 'good';
    $firstIndicator = ($poselTargetStat < $poselGlobalStat) ? 'glyphicon-chevron-left' : 'glyphicon-chevron-right';
    $secondIndicator = ($poselTargetStat < $poselGlobalStat) ? 'glyphicon-chevron-right' : 'glyphicon-chevron-left';
    $barHeight = 240;
    $barHeightMargin = 14;
    if ($numberType == '%') {
        $firstHeight = (floatval((floatval(($firstStat * $statMax) / 100)) - $statMin) * 100) / floatval($progressWidth);
        $secondHeight = ((floatval((floatval(($secondStat * $statMax) / 100)) - $statMin) * 100) / floatval($progressWidth)) - $firstHeight;
    } else {
        $firstHeight = (floatval($firstStat - $statMin) * 100) / floatval($progressWidth);
        $secondHeight = ((floatval($secondStat - $statMin) * 100) / floatval($progressWidth)) - $firstHeight;
    }
    $restHeight = 100 - $firstHeight - $secondHeight;

    $progressHTML = '<div class="graphStats">';
    $progressHTML .= '<div class="progressGraph" data-stats-posel="' . $poselTargetStat . '" data-stats-avg="' . $poselGlobalStat . '" data-min="' . $statMin . '" data-max="' . $statMax . '">';
    $progressHTML .= '<div class="progress vertical">';
    $progressHTML .= '<div class="progress-bar space" style="height: ' . $restHeight . '%">';
    $progressHTML .= '</div>';
    $progressHTML .= '<div class="progress-bar ' . $secondClass . '" style="height: ' . $secondHeight . '%">';
    $progressHTML .= '<span class="sr-only">' . $secondStat . $numberType . '</span>';
    $progressHTML .= '</div>';
    $progressHTML .= '<div class="progress-bar ' . $firstClass . '" style="height: ' . $firstHeight . '%">';
    $progressHTML .= '<span class="sr-only">' . $firstStat . $numberType . '</span>';
    $progressHTML .= '</div>';
    $progressHTML .= '</div>';
    $progressHTML .= '<div class="progress-bar-indicator glyphicon ' . $firstIndicator . '" style="top:' . ($barHeight - $barHeightMargin / 2 - (($firstHeight / 100) * $barHeight)) . 'px"><span>' . $firstStat . $numberType . '</span></div>';
    $progressHTML .= '<div class="progress-bar-indicator glyphicon ' . $secondIndicator . '" style="top:' . ($barHeight - $barHeightMargin / 2 - ((($firstHeight + $secondHeight) / 100) * $barHeight)) . 'px"><span>' . $secondStat . $numberType . '</span></div>';
    $progressHTML .= '</div>';
    $progressHTML .= '</div>';

    return $progressHTML;
}

?>

    <div class="container poslowie">
        <div class="col-xs-12">
            <div class="row">
                <div class="row">
                    <div id="timeline-embed" data-source="<?= $object->getId() ?>"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 poslowieStatistic">
                    <h3><?php echo __d('dane', 'LC_DANE_POSLOWIE_STATYSTYKI_PRAC'); ?></h3>

                    <div class="info col-xs-12">
                        <div class="checkPoselStats">
                            <span class="glyphicon glyphicon-chevron-left"></span>

                            <p><?php echo $object->getData('nazwa'); ?></p>
                        </div>
                        <div class="globalPoselStats">
                            <span class="glyphicon glyphicon-chevron-right"></span>

                            <p><?php echo __d('dane', 'LC_DANE_POSLOWIE_STATYSTYCZNY_POSEL'); ?></p>
                        </div>
                    </div>

                    <div class="statistic col-xs-4 col-md-2">
                        <?= progress($stats[0][0]['ilosc_wystapien_min'], $stats[0][0]['ilosc_wystapien_max'], $stats[1]['s_poslowie_stats']['avg_ilosc_wystapien'], $object->getData('liczba_wypowiedzi'), '%'); ?>
                        <h4><?php echo __d('dane', 'LC_DANE_POSLOWIE_WYSTAPIENIA'); ?></h4>
                    </div>

                    <div class="statistic col-xs-4 col-md-2">
                        <?= progress($stats[0][0]['frekwencja_min'], $stats[0][0]['frekwencja_max'], $stats[1]['s_poslowie_stats']['avg_frekwencja'], $object->getData('frekwencja'), '%') ?>
                        <h4><?php echo __d('dane', 'LC_DANE_POSLOWIE_FREKWENCJA'); ?></h4>
                    </div>

                    <div class="statistic col-xs-4 col-md-2">
                        <?= progress($stats[0][0]['zbuntowanie_min'], $stats[0][0]['zbuntowanie_max'], $stats[1]['s_poslowie_stats']['avg_zbuntowanie'], $object->getData('zbuntowanie'), '%') ?>
                        <h4><?php echo __d('dane', 'LC_DANE_POSLOWIE_ZBUNTOWANIE'); ?></h4>
                    </div>

                    <div class="statistic col-xs-4 col-md-2">
                        <?= progress($stats[0][0]['liczba_projektow_ustaw_min'], $stats[0][0]['liczba_projektow_ustaw_max'], $stats[1]['s_poslowie_stats']['avg_projekty_ustaw'], $object->getData('liczba_projektow_ustaw')); ?>
                        <h4><?php echo __d('dane', 'LC_DANE_POSLOWIE_WNIESIONE_PROJEKTY_USTAW'); ?></h4>
                    </div>

                    <div class="statistic col-xs-4 col-md-2">
                        <?= progress($stats[0][0]['liczba_projektow_uchwal_min'], $stats[0][0]['liczba_projektow_uchwal_max'], $stats[1]['s_poslowie_stats']['avg_projekty_uchwal'], $object->getData('liczba_projektow_uchwal')); ?>
                        <h4><?php echo __d('dane', 'LC_DANE_POSLOWIE_WNIESIONE_PROJEKTY_UCHWAL'); ?></h4>
                    </div>

                    <div class="statistic col-xs-4 col-md-2">
                        <?= progress($stats[0][0]['p_glosow_min'], $stats[0][0]['p_glosow_max'], $stats[1]['s_poslowie_stats']['avg_poparcie_w_okregu'], $object->getData('procent_glosow')) ?>
                        <h4><?php echo __d('dane', 'LC_DANE_POSLOWIE_POPARCIA_W_OKREGU'); ?></h4>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 poslowiePosition">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 country">
                            <h3><?= __d('dane', 'LC_DANE_POSLOWIE_POSITION_STANOWISKA') ?></h3>
                            <? foreach ($info["stanowiska"] as $stanowisko) {
                                echo '<p>' . $stanowisko["wypowiedzi_funkcje"]["nazwa"] . '</p>';
                            } ?>
                        </div>
                        <div class="col-xs-12 col-md-6 rest">
                            <h3><?= __d('dane', 'LC_DANE_POSLOWIE_POSITION_KOMISJESTANOWISKA') ?></h3>
                            <? foreach ($info["komisje_stanowiska"] as $komisje_stanowisko) {
                                $sliceBlock = '<div class="slice">';
                                $sliceBlock .= '<strong>' . __d('dane', 'LC_DANE_POSLOWIE_KOMISJESTANOWISKO_NAZWA') . ':</strong> ' .
                                    '<p>' . $komisje_stanowisko["s_komisje"]["nazwa"] . '</p>';
                                $sliceBlock .= '<strong>' . __d('dane', 'LC_DANE_POSLOWIE_KOMISJESTANOWISKO_STANOWISKO') . ':</strong> ' .
                                    '<p>' . $komisje_stanowisko["s_komisje_funkcje"]["stanowisko"] . '</p>';
                                $sliceBlock .= '<strong>' . __d('dane', 'LC_DANE_POSLOWIE_KOMISJESTANOWISKO_CZAS') . '</strong> ' .
                                    '<p><small>' . __d('dane', 'LC_DANE_POSLOWIE_KOMISJESTANOWISKO_OD') . '</small> ' . $komisje_stanowisko["s_poslowie_komisje"]["od"];
                                if (isset($komisje_stanowisko["s_poslowie_komisje"]["do"]) && ($komisje_stanowisko["s_poslowie_komisje"]["do"] != '0000-00-00')) {
                                    $sliceBlock .= ' <small>' . __d('dane', 'LC_DANE_POSLOWIE_KOMISJESTANOWISKO_DO') . '</small> ' . $komisje_stanowisko["s_poslowie_komisje"]["do"];
                                }
                                $sliceBlock .= '</p>';
                                $sliceBlock .= '</div>';

                                echo $sliceBlock;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($krs)) { ?>
                <div class="row">
                    <div class="col-xs-12 poslowieConnection">
                        <div class="row">
                            <?php if (!empty($krs['biznes'])) { ?>
                                <div class="col-xs-12 business">
                                    <h3><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_BIZNES') ?></h3>
                                    <?php foreach ($krs['biznes'] as $business) { ?>
                                        <div class="col-xs-12 col-md-6 slice">
                                            <div class="where">
                                                <strong
                                                    class="nazwa"><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_FIRMA') ?>
                                                    :</strong>

                                                <p><?= $business['organizacja']['nazwa'] ?></p>

                                                <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_FORMA') ?>
                                                    :</strong>

                                                <p><?= $business['organizacja']['forma_prawna_str'] ?></p>

                                                <? if (isset($business['organizacja']['kapital_zakladowy']) && (($business['organizacja']['kapital_zakladowy'] != '0.00'))) { ?>
                                                    <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_KAPITAL') ?>
                                                        :</strong>

                                                    <p><?= number_format($business['organizacja']['kapital_zakladowy'], 2, ',', ' ') ?>
                                                        <small>PLN</small>
                                                    </p>
                                                <?php } ?>

                                                <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_DATA') ?>
                                                    :</strong>

                                                <p><?= $this->czas->dataSlownie($business['organizacja']['data_rejestracji']) ?></p>
                                            </div>
                                            <div class="whom">
                                                <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHOM_ROLA') ?>
                                                    :</strong>

                                                <p><?= $business['rola']['label'] ?></p>

                                                <? if (isset($business['rola']['udzialy_str']) && ($business['rola']['udzialy_str'] != '')) { ?>
                                                    <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHOM_UDZIAL') ?>
                                                        :</strong>

                                                    <p><?= $business['rola']['udzialy_str'] ?></p>
                                                <? } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <?php if (!empty($krs['ngo'])) { ?>
                                <div class="col-xs-12 ngo">
                                    <h3><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_NGO') ?></h3>
                                    <?php foreach ($krs['ngo'] as $business) { ?>
                                        <div class="col-xs-12 col-md-6 slice">
                                            <div class="where">
                                                <strong
                                                    class="nazwa"><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_NGO') ?>
                                                    :</strong>

                                                <p><?= $business['organizacja']['nazwa'] ?></p>

                                                <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_FORMA') ?>
                                                    :</strong>

                                                <p><?= $business['organizacja']['forma_prawna_str'] ?></p>

                                                <? if (isset($business['organizacja']['cel_dzialania']) && (($business['organizacja']['cel_dzialania'] != ''))) { ?>
                                                    <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_CEL_DZIALANIA') ?>
                                                        :</strong>
                                                    <p class="format"><?= $business['organizacja']['cel_dzialania'] ?></p>
                                                <?php } ?>

                                                <? if (isset($business['organizacja']['kapital_zakladowy']) && (($business['organizacja']['kapital_zakladowy'] != '0.00'))) { ?>
                                                    <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_KAPITAL') ?>
                                                        :</strong>

                                                    <p><?= number_format($business['organizacja']['kapital_zakladowy'], 2, ',', ' ') ?>
                                                        <small>PLN</small>
                                                    </p>
                                                <?php } ?>

                                                <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHERE_DATA') ?>
                                                    :</strong>

                                                <p><?= $this->czas->dataSlownie($business['organizacja']['data_rejestracji']) ?></p>
                                            </div>
                                            <div class="whom">
                                                <strong><?= __d('dane', 'LC_DANE_POSLOWIE_POWIAZANIA_WHOM_ROLA') ?>
                                                    :</strong>

                                                <p><?= $business['rola']['label'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-xs-12 poslowieAdditionalInfo">
                    <div class="row">
                        <div class="col-xs-12 col-md-4 wspolpracownicy">
                            <h3><?= __d('dane', 'LC_DANE_WSPOLPRACOWNICY') ?></h3>
                            <? foreach ($info['wspolpracownicy'] as $wspolpracownicy) {
                                echo '<p><a href="/dane/poslowie_wspolpracownicy/' . $wspolpracownicy["s_poslowie_wsp"]["id"] . '" target="_self">' . $wspolpracownicy["s_poslowie_wsp"]["nazwa"] . ' (' . $wspolpracownicy["s_poslowie_wsp"]["funkcja"] . ')</a></p>';
                            } ?>
                        </div>
                        <div class="col-xs-12 col-md-4 oswiadczenia">
                            <h3><?= __d('dane', 'LC_DANE_OSWIADCZENIA_MAJATKOWE') ?></h3>
                            <? foreach ($info['oswiadczenia_majatkowe'] as $oswiadczenia_majatkowe) {
                                echo '<p><a href="/dane/poslowie_oswiadczenia_majatkowe/' . $oswiadczenia_majatkowe["s_poslowie_oswmaj"]["id"] . '" target="_self">' . $oswiadczenia_majatkowe["s_poslowie_oswmaj"]["label"] . ' (' . $this->czas->dataSlownie($oswiadczenia_majatkowe["s_poslowie_oswmaj"]["data"]) . ')</a></p>';
                            } ?>
                        </div>
                        <div class="col-xs-12 col-md-4 rejestr">
                            <h3><?= __d('dane', 'LC_DANE_REJESTR_KORZYSCI') ?></h3>
                            <? foreach ($info['rejestr_korzysci'] as $rejestr_korzysci) {
                                echo '<p><a href="/dane/poslowie_rejestr_korzysci/' . $rejestr_korzysci["s_poslowie_korzysci"]["label"] . '" target="_self">' . $rejestr_korzysci["s_poslowie_korzysci"]["label"] . ' (' . $this->czas->dataSlownie($rejestr_korzysci["s_poslowie_korzysci"]["data"]) . ')</a></p>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 poslowieBiuro">
                    <h3><?php echo __d('dane', 'LC_DANE_POSLOWIE_BIURA_POSELSKIE'); ?></h3>
                    <?php $biuro_html = $object->getData('biuro_html');
                    echo str_replace('<table>', '<table class="table table-hover">', $biuro_html); ?>
                </div>
            </div>

        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>