<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highcharts-more');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js', 'Podatki.podatki.js');
?>

<div id="podatki">
    <div class="appBanner bottom-border col-xs-12">
        <h1 class="appTitle"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>

        <p class="appSubtitle"><?= __d('podatki', 'LC_PODATKI_SUBHEADLINE'); ?></p>
    </div>

    <form method="post">
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-7 col-sm-offset-2"
                     data-number="<?= (isset($post['umowa_o_prace'])) ? count($post['umowa_o_prace']) : 1 ?>">
                    <div class="form-group col-xs-10 col-sm-11">
                        <label
                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="umowa_o_prace[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_umowa_o_prace_1"
                               value="<?= @$post['umowa_o_prace'][0]; ?>">
                    </div>
                    <span class="info col-xs-10 col-sm-11"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <? if (isset($post['umowa_o_prace'][1])) {
                        for ($i = 1; $i <= count($post['umowa_o_prace']); $i++) {
                            if (!empty($post['umowa_o_prace'][$i])) {
                                ?>
                                <div class="additional" style="" data-number="<?= $i; ?>">
                                    <div class="form-group col-xs-10 col-sm-11">
                                        <input type="number" class="form-control" patern="[0-9]+([.|,][0-9]{2}+)?"
                                               step="0.01" name="umowa_o_prace[]"
                                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>"
                                               id="przychody_umowa_o_prace_<?= $i; ?>"
                                               value="<?= @$post['umowa_o_prace'][$i]; ?>">
                                    </div>
                                    <span class="closeAdditional glyphicon glyphicon-remove col-xs-2 col-sm-1"
                                          aria-hidden="true"></span>
                                </div>
                                <?
                            }
                        }
                    } ?>
                    <button class="btn btn-link btn-xs btn-icon pull-right" data-type="przychody_umowa_o_prace">
                        <i class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-7 col-sm-offset-2"
                     data-number="<?= (isset($post['umowa_zlecenie'])) ? count($post['umowa_zlecenie']) : 1 ?>">
                    <div class="form-group col-xs-10 col-sm-11">
                        <label
                            for="przychody_umowa_zlecenie_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_ZLECENIE'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="umowa_zlecenie[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_umowa_zlecenie_1"
                               value="<?= @$post['umowa_zlecenie'][0]; ?>">
                    </div>
                    <span class="info col-xs-10 col-sm-11"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <? if (isset($post['umowa_zlecenie'][1])) {
                        for ($i = 1; $i <= count($post['umowa_zlecenie']); $i++) {
                            if (!empty($post['umowa_zlecenie'][$i])) {
                                ?>
                                <div class="additional" style="" data-number="<?= $i; ?>">
                                    <div class="form-group col-xs-10 col-sm-11">
                                        <input type="number" class="form-control" patern="[0-9]+([.|,][0-9]{2}+)?"
                                               step="0.01" name="umowa_zlecenie[]"
                                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>"
                                               id="przychody_umowa_zlecenie_<?= $i; ?>"
                                               value="<?= @$post['umowa_zlecenie'][$i]; ?>">
                                    </div>
                                    <span class="closeAdditional glyphicon glyphicon-remove col-xs-2 col-sm-1"
                                          aria-hidden="true"></span>
                                </div>
                                <?
                            }
                        }
                    } ?>
                    <button class="btn btn-link btn-xs btn-icon pull-right"
                            data-type="przychody_umowa_zlecenie"><i
                            class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-7 col-sm-offset-2"
                     data-number="<?= (isset($post['umowa_o_dzielo'])) ? count($post['umowa_o_dzielo']) : 1 ?>">
                    <div class="form-group col-xs-10 col-sm-11">
                        <label
                            for="przychody_umowa_o_dzielo_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_DZIELO'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="umowa_o_dzielo[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_umowa_o_dzielo_1" value="<?= @$post['umowa_o_dzielo'][0]; ?>">
                    </div>
                    <span class="info col-xs-10 col-sm-11"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <? if (isset($post['umowa_o_dzielo'][1])) {
                        for ($i = 1; $i <= count($post['umowa_o_dzielo']); $i++) {
                            if (!empty($post['umowa_o_dzielo'][$i])) {
                                ?>
                                <div class="additional" style="" data-number="<?= $i; ?>">
                                    <div class="form-group col-xs-10 col-sm-11">
                                        <input type="number" class="form-control" patern="[0-9]+([.|,][0-9]{2}+)?"
                                               step="0.01" name="umowa_o_dzielo[]"
                                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>"
                                               id="przychody_umowa_o_dzielo_<?= $i; ?>"
                                               value="<?= @$post['umowa_o_dzielo'][$i]; ?>">
                                    </div>
                                    <span class="closeAdditional glyphicon glyphicon-remove col-xs-2 col-sm-1"
                                          aria-hidden="true"></span>
                                </div>
                                <?
                            }
                        }
                    } ?>
                    <button class="btn btn-link btn-xs btn-icon pull-right"
                            data-type="przychody_umowa_o_dzielo"><i
                            class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-7 col-sm-offset-2" data-number="1">
                    <div class="form-group col-xs-10 col-sm-11">
                        <label
                            for="przychody_dzialalnosc_gospodarcza_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="dzialalnosc_gospodarcza[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_dzialalnosc_gospodarcza_1"
                               value="<?= @$post['dzialalnosc_gospodarcza'][0] ?>">
                    </div>
                    <span class="info col-xs-10 col-sm-11"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>

                    <div class="checkbox col-xs-10 col-sm-11">
                        <input type="hidden" id="warunki_preferencyjne_1_hidden" value="N"
                               name="warunki_preferencyjne[]">
                        <input type="checkbox" id="warunki_preferencyjne_1" value="Y"
                               name="warunki_preferencyjne[]" <? if (isset($post['warunki_preferencyjne']) && $post['warunki_preferencyjne'][0] == 'Y') echo 'checked'; ?>
                        ">
                        <label
                            for="warunki_preferencyjne_1"><?= __d('podatki', 'LC_PODATKI_WARUNKI_PREFERENCYJNE'); ?></label>
                    </div>

                    <div class="form-group col-xs-10 col-sm-11">
                        <label
                            for="przychody_dzialalnosc_gospodarcza_koszt_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA_KOSZT'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="dzialalnosc_gospodarcza_koszt[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_dzialalnosc_gospodarcza_koszt_1"
                               value="<?= @$post['dzialalnosc_gospodarcza_koszt'][0] ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="action">
                <button class="btn btn-primary btn-lg btn-icon" type="submit"><i
                        class="icon glyphicon glyphicon-refresh"></i>Oblicz podatki
                </button>
            </div>
        </div>
    </form>

    <?php if ($result) { ?>
        <div id="results" class="container">
            <? /* <div class="progress">
                <? if ($result_sum['us'] > 0) { ?>
                    <div class="progress-bar progress-bar-us"
                         data-template='<div class="tooltip progress-bar-us" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                         title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US'); ?>: <strong><?= number_format($result_sum['us'], 2, '.', ' '); ?> zł (<?= $this->Number->toPercentage(($result_sum['us'] / $result_sum['total']) * 100) ?>)</strong>'
                         data-html="true" data-toggle="tooltip" data-placement="top"
                         style="width: <?= $this->Number->toPercentage((($result_sum['us'] / $result_sum['total']) * 100) - 0.005) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US'); ?>
                        : <strong><?= number_format($result_sum['us'], 2, '.', ' '); ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['us'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                    </div>
                <? } ?>
                <? if ($result_sum['us_pracodawca'] > 0) { ?>
                    <div class="progress-bar progress-bar-us-pracodawca"
                         data-template='<div class="tooltip progress-bar-us-pracodawca" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                         title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US_PRACODAWCA'); ?>: <strong><?= number_format($result_sum['us_pracodawca'], 2, '.', ' '); ?> zł (<?= $this->Number->toPercentage(($result_sum['us_pracodawca'] / $result_sum['total']) * 100) ?>)</strong>'
                         data-html="true" data-toggle="tooltip" data-placement="top"
                         style="width: <?= $this->Number->toPercentage((($result_sum['us_pracodawca'] / $result_sum['total']) * 100) - 0.005) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US_PRACODAWCA'); ?>
                        : <strong><?= number_format($result_sum['us_pracodawca'], 2, '.', ' '); ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['us_pracodawca'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                    </div>
                <? } ?>
                <? if ($result_sum['zus'] > 0) { ?>
                    <div class="progress-bar progress-bar-zus"
                         data-template='<div class="tooltip progress-bar-zus" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                         title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?>: <strong><?= number_format($result_sum['zus'], 2, '.', ' '); ?> zł (<?= $this->Number->toPercentage(($result_sum['zus'] / $result_sum['total']) * 100) ?>)</strong>'
                         data-html="true" data-toggle="tooltip" data-placement="top"
                         style="width: <?= $this->Number->toPercentage((($result_sum['zus'] / $result_sum['total']) * 100) - 0.005) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?>
                        : <strong><?= number_format($result_sum['zus'], 2, '.', ' '); ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['zus'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                    </div>
                <? } ?>
                <? if ($result_sum['pit'] > 0) { ?>
                    <div class="progress-bar progress-bar-pit"
                         data-template='<div class="tooltip progress-bar-pit" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                         title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?>: <strong><?= number_format($result_sum['pit'], 2, '.', ' '); ?> zł (<?= $this->Number->toPercentage(($result_sum['pit'] / $result_sum['total']) * 100) ?>)</strong>'
                         data-html="true" data-toggle="tooltip" data-placement="top"
                         style="width: <?= $this->Number->toPercentage((($result_sum['pit'] / $result_sum['total']) * 100) - 0.005) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?>
                        : <strong><?= number_format($result_sum['pit'], 2, '.', ' '); ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['pit'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                    </div>
                <? } ?>
                <? if ($result_sum['vat'] > 0) { ?>
                    <div class="progress-bar progress-bar-vat"
                         data-template='<div class="tooltip progress-bar-vat" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                         title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?>: <strong><?= number_format($result_sum['vat'], 2, '.', ' '); ?> zł (<?= $this->Number->toPercentage(($result_sum['vat'] / $result_sum['total']) * 100) ?>)</strong>'
                         data-html="true" data-toggle="tooltip" data-placement="top"
                         style="width: <?= $this->Number->toPercentage((($result_sum['vat'] / $result_sum['total']) * 100) - 0.005) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?>
                        : <strong><?= number_format($result_sum['vat'], 2, '.', ' '); ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['vat'] / $result_sum['total']) * 100) ?>
                            )</strong></strong></span>
                    </div>
                <? } ?>
                <? if ($result_sum['akcyza'] > 0) { ?>
                    <div class="progress-bar progress-bar-akcyza"
                         data-template='<div class="tooltip progress-bar-akcyza" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                         title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?>: <strong><?= number_format($result_sum['akcyza'], 2, '.', ' '); ?> zł (<?= $this->Number->toPercentage(($result_sum['akcyza'] / $result_sum['total']) * 100) ?>)</strong>'
                         data-html="true" data-toggle="tooltip" data-placement="top"
                         style="width: <?= $this->Number->toPercentage((($result_sum['akcyza'] / $result_sum['total']) * 100) - 0.005) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?>
                        : <strong><?= number_format($result_sum['akcyza'], 2, '.', ' '); ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['akcyza'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                    </div>
                <? } ?>
            </div> */ ?>

            <div class="info_numbers text-center">
                <div class="col-xs-12">
                    <h3><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_BRUTTO'); ?>:</h3>
                    <strong><?= number_format($result_sum['brutto'], 2, '.', ' '); ?> zł</strong>
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_BRUTTO_INFO'); ?></small>
                </div>
                <hr/>
                <div class="row items">
                    <? $blockSize = 'col-xs-12 col-sm-6 col-md-4'; ?>

                    <div class="block <?= $blockSize; ?>">
                        <div class="item">
                            <div class="inner">
                                <div class="details">
                                    <span class="detail"><?= number_format($result_sum['us'], 2, '.', ' '); ?> zł</span>
                                </div>
                                <div class="title">
                                    <div
                                        class="nazwa"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block <?= $blockSize; ?>">
                        <div class="item">
                            <div class="inner">
                                <div class="details">
                                    <span
                                        class="detail"><?= number_format($result_sum['us_pracodawca'], 2, '.', ' '); ?>
                                        zł</span>
                                </div>
                                <div class="title">
                                    <div
                                        class="nazwa"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US_PRACODAWCY'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block <?= $blockSize; ?>">
                        <div class="item">
                            <div class="inner">
                                <div class="details">
                                    <span class="detail"><?= number_format($result_sum['zus'], 2, '.', ' '); ?>
                                        zł</span>
                                </div>
                                <div class="title">
                                    <div
                                        class="nazwa"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block <?= $blockSize; ?>">
                        <div class="item">
                            <div class="inner">
                                <div class="details">
                                    <span class="detail"><?= number_format($result_sum['pit'], 2, '.', ' '); ?>
                                        zł</span>
                                </div>
                                <div class="title">
                                    <div
                                        class="nazwa"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block <?= $blockSize; ?>">
                        <div class="item">
                            <div class="inner">
                                <div class="details">
                                    <span class="detail"><?= number_format($result_sum['vat'], 2, '.', ' '); ?>
                                        zł</span>
                                </div>
                                <div class="title">
                                    <div
                                        class="nazwa"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block <?= $blockSize; ?>">
                        <div class="item">
                            <div class="inner">
                                <div class="details">
                                    <span class="detail"><?= number_format($result_sum['akcyza'], 2, '.', ' '); ?>
                                        zł</span>
                                </div>
                                <div class="title">
                                    <div
                                        class="nazwa"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="col-xs-12">
                    <h3><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_NETTO'); ?>:</h3>
                    <strong><?= number_format($result_sum['netto'], 2, '.', ' '); ?> zł</strong>
                </div>
                <hr/>
            </div>
            <div class="row items">
                <h3 class="text-center"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_WYDAWANE_PODATKI'); ?></h3>

                <div class="block col-xs-12 col-sm-6 col-md-3">
                    <div data-id="5" class="item more">
                        <a data-title="Oświata i wychowanie" class="inner" href="#5">
                            <div class="logo">
                                <i class="icon-dzialy-5"></i>
                            </div>
                            <div class="details">
                                <span class="detail">262&nbsp;mln</span>
                            </div>
                            <div class="title">
                                <div class="nazwa">Oświata i wychowanie</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="block col-xs-12 col-sm-6 col-md-3">
                    <div data-id="5" class="item more">
                        <a data-title="Oświata i wychowanie" class="inner" href="#5">
                            <div class="logo">
                                <i class="icon-dzialy-5"></i>
                            </div>
                            <div class="details">
                                <span class="detail">262&nbsp;mln</span>
                            </div>
                            <div class="title">
                                <div class="nazwa">Oświata i wychowanie</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
</div>
