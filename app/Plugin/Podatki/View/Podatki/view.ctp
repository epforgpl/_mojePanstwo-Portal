<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highcharts-more');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highcharts-3d');
$this->Combinator->add_libs('js', '../plugins/highstock/extras/draggable-points');
$this->Combinator->add_libs('js', '../plugins/highstock/extras/custom-events');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js', 'Bdl.bdl-click.js');
$this->Combinator->add_libs('js', 'Podatki.podatki.js');

echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">

		<form id="podatki" method="post">
		    <div class="container">
		        <div class="appBanner margin-top-20">
		            <h1 class="appTitle"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>

		            <p class="appSubtitle"><?= __d('podatki', 'LC_PODATKI_SUBHEADLINE'); ?></p>

		            <p class="margin-top-20"><?= __d('podatki', 'LC_PODATKI_INFORMATION'); ?> <a href="#" data-toggle="modal"
		                                                                                         data-target="#metodologia_modal"
		                                                                                         target="_blank">Zobacz
		                    metodologię obliczeń &raquo;</a></p>
		        </div>

		        <div class="sections userSetup">
		            <div class="section">
		                <div class="row"
		                     data-number="<?= (isset($post['umowa_o_prace'])) ? count($post['umowa_o_prace']) : 1 ?>">
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-5 col-md-offset-0 text-right">
		                        <label
		                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?>
		                            :</label>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-0 text-center inputpadding">
		                        <input type="text" autocomplete="off" name="umowa_o_prace[]"
		                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control currency"
		                               id="przychody_umowa_o_prace_1"
		                               value="<? if (isset($post['umowa_o_prace'][0]) && (float)str_replace(',', '.', $post['umowa_o_prace'][0]) > 0) {
		                                   echo number_format((float)str_replace(',', '.', $post['umowa_o_prace'][0]), 2, ',', '');
		                               } ?>">
		                    </div>
                            <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-3 button_container">
		                        <a href="#<?= str_replace(' ', '_', strtolower(__d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'))); ?>"
		                           class="btn btn-link btn-xs" data-type="przychody_umowa_o_prace">
		                            <span
		                                class="icon glyphicon glyphicon-plus"></span><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
		                        </a>
		                    </div>
		                </div>
		                <? if (isset($post['umowa_o_prace'][1])) {
		                    for ($i = 1; $i <= count($post['umowa_o_prace']); $i++) {
		                        if (!empty($post['umowa_o_prace'][$i]) && $post['umowa_o_prace'][$i] !== 0) {
		                            ?>
		                            <div class="additional row" data-number="<?= $i; ?>">
		                                <div
                                            class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-5 text-center inputpadding">
		                                    <input type="text" autocomplete="off" class="form-control currency"
		                                           name="umowa_o_prace[]"
		                                           title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>"
		                                           id="przychody_umowa_o_prace_<?= $i; ?>"
		                                           value="<? if (isset($post['umowa_o_prace'][$i]) && (float)str_replace(',', '.', $post['umowa_o_prace'][$i]) > 0) {
		                                               echo number_format((float)str_replace(',', '.', $post['umowa_o_prace'][$i]), 2, ',', '');
		                                           } ?>">
		                                </div>
		                                <div class="col-xs-2 col-sm-4 col-md-3">
		                                    <a class="closeAdditional glyphicon glyphicon-remove" aria-hidden="true"
		                                       href="#usuń"></a>
		                                </div>
		                            </div>
		                            <?
		                        }
		                    }
		                } ?>
		            </div>

		            <div class="section">
		                <div class="row"
		                     data-number="<?= (isset($post['umowa_zlecenie'])) ? count($post['umowa_zlecenie']) : 1 ?>">
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-5 col-md-offset-0 text-right">
		                        <label
		                            for="przychody_umowa_zlecenie_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_ZLECENIE'); ?>
		                            :</label>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-0 text-center inputpadding">
		                        <input type="text" autocomplete="off" name="umowa_zlecenie[]"
		                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control currency"
		                               id="przychody_umowa_zlecenie_1"
		                               value="<? if (isset($post['umowa_zlecenie'][0]) && (float)str_replace(',', '.', $post['umowa_zlecenie'][0]) > 0) {
		                                   echo number_format((float)str_replace(',', '.', $post['umowa_zlecenie'][0]), 2, ',', '');
		                               } ?>">
		                    </div>
                            <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-3 button_container">
		                        <a href="#<?= str_replace(' ', '_', strtolower(__d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'))); ?>"
		                           class="btn btn-link btn-xs" data-type="przychody_umowa_zlecenie">
		                            <span
		                                class="icon glyphicon glyphicon-plus"></span><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
		                        </a>
		                    </div>
		                </div>
		                <? if (isset($post['umowa_zlecenie'][1])) {
		                    for ($i = 1; $i <= count($post['umowa_zlecenie']); $i++) {
		                        if (!empty($post['umowa_zlecenie'][$i]) && $post['umowa_zlecenie'][$i] !== 0) {
		                            ?>
		                            <div class="additional row" data-number="<?= $i; ?>">
		                                <div
                                            class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-5 text-center inputpadding">
		                                    <input type="text" autocomplete="off" class="form-control currency"
		                                           name="umowa_zlecenie[]"
		                                           title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>"
		                                           id="przychody_umowa_zlecenie_<?= $i; ?>"
		                                           value="<? if (isset($post['umowa_zlecenie'][$i]) && (float)str_replace(',', '.', $post['umowa_zlecenie'][$i]) > 0) {
		                                               echo number_format((float)str_replace(',', '.', $post['umowa_zlecenie'][$i]), 2, ',', '');
		                                           } ?>">
		                                </div>
		                                <div class="col-xs-2 col-sm-4 col-md-3">
		                                    <a class="closeAdditional glyphicon glyphicon-remove" aria-hidden="true"
		                                       href="#usuń"></a>
		                                </div>
		                            </div>
		                            <?
		                        }
		                    }
		                } ?>
		            </div>

		            <div class="section">
		                <div class="row"
		                     data-number="<?= (isset($post['umowa_o_dzielo'])) ? count($post['umowa_o_dzielo']) : 1 ?>">
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-5 col-md-offset-0 text-right">
		                        <label
		                            for="przychody_umowa_o_dzielo_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_DZIELO'); ?>
		                            :</label>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-0 text-center inputpadding">
		                        <input type="text" autocomplete="off" name="umowa_o_dzielo[]"
		                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control currency"
		                               id="przychody_umowa_o_dzielo_1"
		                               value="<? if (isset($post['umowa_o_dzielo'][0]) && (float)str_replace(',', '.', $post['umowa_o_dzielo'][0]) > 0) {
		                                   echo number_format((float)str_replace(',', '.', $post['umowa_o_dzielo'][0]), 2, ',', '');
		                               } ?>">
		                    </div>
                            <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-md-3 button_container">
		                        <a href="#<?= str_replace(' ', '_', strtolower(__d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'))); ?>"
		                           class="btn btn-link btn-xs" data-type="przychody_umowa_o_dzielo">
		                            <span
		                                class="icon glyphicon glyphicon-plus"></span><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
		                        </a>
		                    </div>
		                </div>
		                <? if (isset($post['umowa_o_dzielo'][1])) {
		                    for ($i = 1; $i <= count($post['umowa_o_dzielo']); $i++) {
		                        if (!empty($post['umowa_o_dzielo'][$i]) && $post['umowa_o_dzielo'][$i] !== 0) {
		                            ?>
		                            <div class="additional row" data-number="<?= $i; ?>">
		                                <div
                                            class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-5 text-center inputpadding">
		                                    <input type="text" autocomplete="off" class="form-control currency"
		                                           name="umowa_o_dzielo[]"
		                                           title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>"
		                                           id="przychody_umowa_o_dzielo_<?= $i; ?>"
		                                           value="<? if (isset($post['umowa_o_dzielo'][$i]) && (float)str_replace(',', '.', $post['umowa_o_dzielo'][$i]) > 0) {
		                                               echo number_format((float)str_replace(',', '.', $post['umowa_o_dzielo'][$i]), 2, ',', '');
		                                           } ?>">
		                                </div>
		                                <div class="col-xs-2 col-sm-4 col-md-3">
		                                    <a class="closeAdditional glyphicon glyphicon-remove" aria-hidden="true"
		                                       href="#usuń"></a>
		                                </div>
		                            </div>
		                            <?
		                        }
		                    }
		                } ?>
		            </div>
		            <div class="section dzialalnoscGospodarcza">
		                <? $dzialanoscGospExist = ((isset($post['dzialalnosc_gospodarcza']) && !empty($post['dzialalnosc_gospodarcza'][0])) || (isset($post['dzialalnosc_gospodarcza_koszt']) && !empty($post['dzialalnosc_gospodarcza_koszt'][0]))) ? true : false; ?>

                        <p class="text-center<? if ($dzialanoscGospExist) { ?> hide<? } ?>">
		                    <a href="#"><?= __d('podatki', 'LC_PODATKI_DZIALANOSC_GOSPODARCZA_QUESTION'); ?></a>
		                </p>

                        <div class="row"<? if (!$dzialanoscGospExist) { ?> style="display: none"<? } ?>>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-5 col-md-offset-0 text-right">
		                        <label
		                            for="przychody_dzialalnosc_gospodarcza_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA'); ?></label>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-0 text-center inputpadding">
		                        <input type="text" autocomplete="off" name="dzialalnosc_gospodarcza[]"
		                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control currency"
		                               id="przychody_dzialalnosc_gospodarcza_1"
		                               value="<? if (isset($post['dzialalnosc_gospodarcza'][0]) && (float)str_replace(',', '.', $post['dzialalnosc_gospodarcza'][0]) > 0) {
		                                   echo number_format((float)str_replace(',', '.', $post['dzialalnosc_gospodarcza'][0]), 2, ',', '');
		                               } ?>">
		                    </div>
		                    <div class="col-xs-2 col-sm-4 col-md-3">
		                        <a class="closeAdditional glyphicon glyphicon-remove show" aria-hidden="true"
		                           href="#zamknij"></a>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-3 col-md-offset-5 checkbox">
		                        <input type="hidden" id="warunki_preferencyjne_1_hidden" value="N"
		                               name="warunki_preferencyjne[]">
		                        <input type="checkbox" id="warunki_preferencyjne_1" value="Y"
		                               name="warunki_preferencyjne[]"<? if (isset($post['warunki_preferencyjne']) && $post['warunki_preferencyjne'][0] == 'Y') echo ' checked'; ?>>
		                        <label
		                            for="warunki_preferencyjne_1"><?= __d('podatki', 'LC_PODATKI_WARUNKI_PREFERENCYJNE'); ?></label>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-5 col-md-offset-0 text-right">
		                        <label
		                            for="przychody_dzialalnosc_gospodarcza_koszt_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA_KOSZT'); ?></label>
		                    </div>
                            <div
                                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-0 text-center inputpadding">
		                        <input type="text" autocomplete="off" name="dzialalnosc_gospodarcza_koszt[]"
		                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control currency"
		                               id="przychody_dzialalnosc_gospodarcza_koszt_1"
		                               value="<? if (isset($post['dzialalnosc_gospodarcza_koszt'][0]) && (float)str_replace(',', '.', $post['dzialalnosc_gospodarcza_koszt'][0]) > 0) {
		                                   echo number_format((float)str_replace(',', '.', $post['dzialalnosc_gospodarcza_koszt'][0]), 2, ',', '');
		                               } ?>">
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>

            <div class="main_button_container text-center">
		        <button class="btn btn-success btn-lg btn-icon" type="submit"><i
		                class="icon glyphicon glyphicon-refresh"></i><span>Oblicz</span>
		        </button>
		    </div>
		    <? if (isset($wydatki)) { ?>
		        <div class="splitTable">
		            <div class="container">
		                <div class="col-xs-12 col-sm-4">
		                    <div class="block">
		                        <span class="text">Twój pracodawca płaci</span>
		                    <span class="cost"><? if ((float)str_replace(',', '.', $result['zus_pracodawca']) > 0) {
		                            echo number_format((float)str_replace(',', '.', $result['zus_pracodawca']), 0, ',', ' ');
		                        } else {
		                            echo '0';
		                        } ?> zł</span>
		                        <span class="text">podatków od wynagrodzenia</span>
		                    </div>
		                    <ul>
		                        <? if ((float)str_replace(',', '.', $result['zus_pracodawca']) > 0) { ?>
		                            <li>
		                                <strong><?= number_format((float)str_replace(',', '.', $result['zus_pracodawca']), 0, ',', ' ') ?>
		                                    zł</strong> <?= __d('podatki', 'LC_PODATKI_RESULTS_PIE_ZUS') ?>
		                            </li>
		                        <? } ?>
		                    </ul>
		                </div>
		                <div class="col-xs-12 col-sm-4">
		                    <div class="block">
		                        <span class="text">Ty płacisz</span>
		                    <span
		                        class="cost"><? if ((float)str_replace(',', '.', $result['zus']) + (float)str_replace(',', '.', $result['zdrow']) + (float)str_replace(',', '.', $result['pit']) > 0) {
		                            echo number_format((float)str_replace(',', '.', $result['zus']) + (float)str_replace(',', '.', $result['zdrow']) + (float)str_replace(',', '.', $result['pit']), 0, ',', ' ');
		                        } else {
		                            echo '0';
		                        } ?> zł</span>
		                        <span class="text">podatków od wynagrodzenia</span>
		                    </div>
		                    <ul>
		                        <? if ((float)str_replace(',', '.', $result['zus']) > 0) { ?>
		                            <li><strong><?= number_format((float)str_replace(',', '.', $result['zus']), 0, ',', ' ') ?>
		                                    zł</strong> <?= __d('podatki', 'LC_PODATKI_RESULTS_PIE_ZUS') ?></li>
		                        <? } ?>
		                        <? if ((float)str_replace(',', '.', $result['zdrow']) > 0) { ?>
		                            <li>
		                                <strong><?= number_format((float)str_replace(',', '.', $result['zdrow']), 0, ',', ' ') ?>
		                                    zł</strong> <?= __d('podatki', 'LC_PODATKI_RESULTS_PIE_ZDROW') ?></li>
		                        <? } ?>
		                        <? if ((float)str_replace(',', '.', $result['pit']) > 0) { ?>
		                            <li><strong><?= number_format((float)str_replace(',', '.', $result['pit']), 0, ',', ' ') ?>
		                                    zł</strong> <?= __d('podatki', 'LC_PODATKI_RESULTS_PIE_PIT') ?></li>
		                        <? } ?>
		                    </ul>
		                </div>
		                <div class="col-xs-12 col-sm-4">
		                    <div class="block">
		                        <span class="text">Ty płacisz</span>
		                    <span
		                        class="cost"><? if ((float)str_replace(',', '.', $result['vat']) + (float)str_replace(',', '.', $result['akcyza']) > 0) {
		                            echo number_format((float)str_replace(',', '.', $result['vat']) + (float)str_replace(',', '.', $result['akcyza']), 0, ',', ' ');
		                        } else {
		                            echo '0';
		                        } ?> zł</span>
		                        <span class="text">podatków od konsumpcji</span>
		                    </div>
		                    <ul>
		                        <? if ((float)str_replace(',', '.', $result['vat']) > 0) { ?>
		                            <li><strong><?= number_format((float)str_replace(',', '.', $result['vat']), 0, ',', ' ') ?>
		                                    zł</strong> <?= __d('podatki', 'LC_PODATKI_RESULTS_PIE_VAT') ?>
		                            </li>
		                        <? } ?>
		                        <? if ((float)str_replace(',', '.', $result['akcyza']) > 0) { ?>
		                            <li>
		                                <strong><?= number_format((float)str_replace(',', '.', $result['akcyza']), 0, ',', ' ') ?>
		                                    zł</strong> <?= __d('podatki', 'LC_PODATKI_RESULTS_PIE_AKCYZA') ?>
		                            </li>
		                        <? } ?>
		                    </ul>
		                </div>

                        <div class="col-xs-12 text-center h3">
		                    <p><? if (isset($result['netto'])) {
		                            $kwota_podatku = ((float)str_replace(',', '.', $result['zus']) + (float)str_replace(',', '.', $result['zus_pracodawca']) + (float)str_replace(',', '.', $result['zdrow']) + (float)str_replace(',', '.', $result['pit']) + (float)str_replace(',', '.', $result['vat']) + (float)str_replace(',', '.', $result['akcyza']));
		                            echo __d('podatki', 'LC_PODATKI_RESULTS_MIESIECZNIE %s', number_format($kwota_podatku, 0, ',', ' '));
		                        } ?>
		                    </p>
		                </div>
		            </div>
		        </div>
		    <? } ?>
		    <div class="stripe scroll<?php if ($result == false) { ?>blocked" style="display: none;<? } ?>">
		        <div class="container">
		            <? if (isset($wydatki)) { ?>
		                <div class="row items bdlClickEngine" data-bdllabel="false">
		                    <h2 class="text-center"><?= __d('podatki', 'LC_PODATKI_RESULTS_WYDAWANE_PODATKI'); ?>:</h2>
		                    <? foreach ($wydatki['dzialy'] as $dzial) { ?>
		                        <div data-id="<?= $dzial['id'] ?>" class="bdlBlock col-xs-12 col-sm-6 col-md-3">
		                            <div class="item more">
		                                <div class="inner<? if (isset($dzial['subdzialy'])) { ?> clickable<? } ?>">
		                                    <div class="logo">
		                                        <span class="icon-dzialy-<?= $dzial['id']; ?>"></span>
		                                    </div>
		                                    <div class="details">
		                                        <span
		                                            class="detail"><?= number_format(($dzial['kwota'] / $wydatki['suma']) * $kwota_podatku, 0, ',', ' '); ?>
		                                            zł</span>
		                                    </div>
		                                    <div class="title">
		                                        <div class="nazwa"><?= $dzial['nazwa']; ?><span class="glyphicon"></span></div>
		                                    </div>
		                                    <? if (isset($dzial['subdzialy'])) { ?>
		                                        <div class="text">
		                                            <ul class="wskazniki">
		                                                <? foreach ($dzial['subdzialy'] as $subdzial) { ?>
		                                                    <li>
		                                                        <div class="row">
		                                                            <div
		                                                                class="wskaznikWartosc col-xs-1 text-right"><?= number_format(($subdzial['kwota'] / $wydatki['suma']) * $kwota_podatku, 0, ',', ' '); ?>
		                                                                zł
		                                                            </div>
		                                                            <div class="wskaznikText col-xs-11">
		                                                                <span class="href"><?= $subdzial['nazwa'] ?></span>
		                                                            </div>
		                                                        </div>
		                                                    </li>
		                                                <? } ?>
		                                            </ul>
		                                        </div>
		                                    <? } ?>
		                                </div>
		                            </div>
		                        </div>
		                    <? } ?>
		                </div>

                        <?
		                foreach ($wydatki['dzialy'] as &$d)
		                    if ($d['id'] == '109')
		                        $d['nazwa'] = 'Gospodarka komunalna i ochrona środowiska';
		                ?>

                        <div class="pie_chart_block">
		                    <div id="pie_chart" class="pie_chart margin-top-30" data-suma="<?= $wydatki['suma'] ?>"
		                         data-podatek="<?= $kwota_podatku ?>"
		                         data-series='<?= json_encode($wydatki['dzialy']) ?>'></div>
		                    <div class="moneyLeft" data-sum="<?= round($kwota_podatku) ?>">Pozostało:
		                        <span><?= round($kwota_podatku) ?></span></div>
		                </div>

                        <h3 class="text-center col-xs-12 userChartTitle">W jaki sposób Ty wydałbyś swoje podatki?</h3>
		                <div class="btn btn-primary userChart btn-icon margin-top-5 width-auto"><i
		                        class="icon glyphicon glyphicon-cog"></i>Zbuduj swój
		                    wykres
		                </div>
		                <div class="userChartBlock hide col-xs-12 col-md-8 col-md-offset-2">
		                    <p>Niebieskie słupki obrazują to jak Twoje pieniądze są wydawane w rzeczywistości. Pomarańczowe
		                        słupki to Twoje preferencje. Ustal wysokości pomarańczowych słupków, podaj swoje dane w
		                        formularzu
		                        poniżej i kliknij przycisk "Wyślij"</p>
		                    <div class="form-horizontal">
		                        <div class="form-group col-xs-12">
		                            <label for="inputSex" class="col-sm-4 control-label">Podaj swą płeć</label>
		                            <div class="col-sm-6">
		                                <select class="form-control" id="inputSex" name="plec">
		                                    <option value="" selected></option>
		                                    <option value="M">Mężczyzna</option>
		                                    <option value="K">Kobieta</option>
		                                </select>
		                            </div>
		                        </div>
		                        <div class="form-group col-xs-12">
		                            <label for="inputAge" class="col-sm-4 control-label">Podaj swój wiek</label>
		                            <div class="col-sm-6">
		                                <input type="number" class="form-control" id="inputAge" name="wiek" min="1"
		                                       max="150">
		                            </div>
		                        </div>
		                    </div>
		                    <p class="text-center col-xs-12">Dane są anonimowe i zostaną wykorzystane w ramach projektu
		                        badawczego "Jak wydawane są moje podatki".</p>
		                    <div class="col-xs-12 margin-top-10">
		                        <div class="btn btn-default userChartCancel userOptions">Anuluj</div>
		                        <div type="button" class="btn btn-primary userChartSave userOptions">Wyślij</div>
		                        <div class="btn btn-default userChartCancel hide">Zamknij</div>
		                        <div class="alert hide"></div>
		                    </div>
		                </div>
		            <? } ?>
		        </div>
		    </div>
		    <?php if ($result != false) { ?>
		        <div class="main_button_container text-center">
		            <a class="btn btn-success btn-lg btn-icon" href="/podatki"><i
		                    class="icon glyphicon glyphicon-repeat"></i><span>Nowe obliczenia</span>
		            </a>
		        </div>
		    <? } ?>

            <div class="modal fade" id="metodologia_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		        <div class="modal-dialog" role="document">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
		                            aria-hidden="true">&times;</span></button>
		                    <h4 class="modal-title" id="myModalLabel">Metodologia</h4>
		                </div>
		                <div class="modal-body">
		                    <div class="row">
		                        <div class="col-xs-12 text-justify">
		                            <p>
		                                Obliczenia podatków i składek odzwierciedlają stan prawny z 2014 roku. Podatek VAT
		                                płacony przez konsumentów jest obliczony na podstawie szacunków przeciętnej stawki
		                                podatku VAT dla gospodarstw domowych o różnych poziomach dochodu przedstawionych w
		                                raporcie „VAT w wydatkach gospodarstw domowych”, przygotowanym przez Centrum Analiz
		                                Ekonomicznych CenEA. Dla obliczenia wysokości akcyzy przyjęto uproszczenie, zgodnie z
		                                którym wysokość płaconej akcyzy stanowi połowę wysokości płaconego podatku VAT.
		                                Uproszczenie to wynika ze struktury dochodów budżetu państwa. Składki na ubezpieczenie
		                                społeczne płacone przez pracodawcę obejmują też składki na Fundusz Pracy i Fundusz
		                                Gwarantowanych Świadczeń Pracowniczych. Przyjęto stawkę wypadkową w wysokości 1,93%.
		                                W przypadku umowy zlecenie założono, że nie jest opłacana składka na ubezpieczenie
		                                chorobowe. Dla umowy zlecenie i umowy o dzieło przyjęto 20% kosztów uzyskania przychodu
		                                oraz pomniejszono podatek PIT o 1/12 rocznej kwoty zmniejszającej podatek (46 zł).
		                            </p>

                                    <p>Struktura wydatków państwa została opracowana na podstawie danych za 2013 rok. W tym celu
		                                wykorzystano następujące źródła danych: sprawozdanie z wykonania budżetu państwa za 2013
		                                rok; raport NIK „Analiza wykonania budżetu państwa i założeń polityki pieniężnej w 2013
		                                roku”; informacje NIK o wynikach kontroli wykonania budżetu państwa w poszczególnych
		                                częściach budżetowych oraz wyników kontroli planów finansowych poszczególnych agencji,
		                                funduszy, itp.; informacje o wykonaniu planów finansowych Funduszu Ubezpieczeń
		                                Społecznych oraz Funduszu Emerytalno-Rentowego rolników; roczne sprawozdanie z wykonania
		                                planu finansowego NFZ; sprawozdanie z wykonania planu wydatków budżetowych jednostek
		                                samorządu terytorialnego oraz sprawozdanie z wykonania planów finansowych
		                                samorządowych zakładów budżetowych (dane zbiorcze dla wszystkich JST); informacje
		                                otrzymane bezpośrednio z Ministerstwa Finansów w trybie dostępu do informacji
		                                publicznej.
		                            </p>

                                    <p>Wszystkie kwoty zaokrąglono do pełnych złotych.</p>
		                            <p>W razie dalszych pytań prosimy o kontakt na adres: <a href="mailto:ibs@ibs.org.pl">ibs@ibs.org.pl</a>
		                            </p>
		                        </div>
		                    </div>
		                </div>
		                <div class="modal-footer">
		                    <button type="button" class="btn btn-success" data-dismiss="modal">Zamknij</button>
		                </div>
		            </div>
		        </div>
		    </div>


            <div class="footer text-center">
		        <div class="customObject krakow903 col-xs-12" id="fundatorzy">
		            <div class="part">
		                <div class="logotypy">
		                    <a target="_blank" href="http://www.eeagrants.org/" title="Link do strony EEA Grants">
		                        <img class="image" src="/img/partnerzy/norway_grants.png" alt="Logo EEA Grants"/>
		                    </a>
		                    <a target="_blank" href="http://www.batory.org.pl/"
		                       title="Link do strony Fundacji im. Stefana Batorego">
		                        <img class="image" src="/img/partnerzy/fundacja_batorego.png" alt="Logo Fundacji Batorego"/>
		                    </a>
		                    <a target="_blank" href="http://www.pcyf.org.pl/"
		                       title="Link do strony Polskiej Fundacji Dzieci i Młodzieży">
		                        <img class="image" src="/img/partnerzy/polska_fundacja_dzieci_i_mlodziezy.png"
		                             alt="Logo Polskiej Fundacji Dzieci i Młodzieży"/>
		                    </a>
		                    <a target="_blank" href="http://www.ibs.org.pl/"
		                       title="Link do strony Fundacji Naukowej Instytutu Badań Strukturalnych">
		                        <img class="image" src="/Podatki/img/logotyp_ibs.png"
		                             alt="Logo Fundacji Naukowej Instytutu Badań Strukturalnych">
		                    </a>
		                </div>
		            </div>
		        </div>
		    </div>
		</form>

    </div>
</div>
