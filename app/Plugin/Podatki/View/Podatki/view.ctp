<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));
$this->Combinator->add_libs('js', 'Podatki.podatki.js');

// __d('podatki', 'LC_PODATKI_INFORMATION', '#co_to_kwota_brutto');
?>

<div id="podatki">
    <div class="appBanner bottom-border col-xs-12">
        <h1 class="appTitle"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>

        <p class="appSubtitle"><?php echo ($result) ? __d('podatki', 'LC_PODATKI_RESULTS_SUBHEADLINE') : __d('podatki', 'LC_PODATKI_SUBHEADLINE'); ?></p>
    </div>

    <form method="post">
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-2" data-number="1">
                    <div class="form-group">
                        <label
                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="umowa_o_prace[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_umowa_o_prace_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <button class="btn btn-link btn-xs btn-icon pull-right" data-type="przychody_umowa_o_prace">
                        <i
                            class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-2" data-number="1">
                    <div class="form-group">
                        <label
                            for="przychody_umowa_zlecenie_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_ZLECENIE'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="umowa_zlecenie[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_umowa_zlecenie_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <button class="btn btn-link btn-xs btn-icon pull-right"
                            data-type="przychody_umowa_zlecenie"><i
                            class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-2" data-number="1">
                    <div class="form-group">
                        <label
                            for="przychody_umowa_o_dzielo_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_DZIELO'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="umowa_o_dzielo[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_umowa_o_dzielo_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <button class="btn btn-link btn-xs btn-icon pull-right"
                            data-type="przychody_umowa_o_dzielo"><i
                            class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-2" data-number="1">
                    <div class="form-group">
                        <label
                            for="przychody_dzialalnosc_gospodarcza_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="dzialalnosc_gospodarcza[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_dzialalnosc_gospodarcza_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>

                    <div class="checkbox">
                        <input type="hidden" id="warunki_preferencyjne_1_hidden" value="N"
                               name="warunki_preferencyjne[]">
                        <input type="checkbox" id="warunki_preferencyjne_1" value="Y"
                               name="warunki_preferencyjne[]">
                        <label
                            for="warunki_preferencyjne_1"><?= __d('podatki', 'LC_PODATKI_WARUNKI_PREFERENCYJNE'); ?></label>
                    </div>

                    <div class="form-group">
                        <label
                            for="przychody_dzialalnosc_gospodarcza_koszt_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA_KOSZT'); ?></label>
                        <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01"
                               name="dzialalnosc_gospodarcza_koszt[]"
                               title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                               id="przychody_dzialalnosc_gospodarcza_koszt_1">
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
            <div class="progress">
                <div class="progress-bar progress-bar-us"
                     data-template='<div class="tooltip progress-bar-us" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US'); ?>: <strong><?= $result_sum['us']; ?> zł (<?= $this->Number->toPercentage(($result_sum['us'] / $result_sum['total']) * 100) ?>)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top"
                     style="width: <?= $this->Number->toPercentage(($result_sum['us'] / $result_sum['total']) * 100) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US'); ?>
                        : <strong><?= $result_sum['us']; ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['us'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                </div>
                <div class="progress-bar progress-bar-us-pracodawca"
                     data-template='<div class="tooltip progress-bar-us-pracodawca" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US_PRACODAWCA'); ?>: <strong><?= $result_sum['us_pracodawca']; ?> zł (<?= $this->Number->toPercentage(($result_sum['us_pracodawca'] / $result_sum['total']) * 100) ?>)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top"
                     style="width: <?= $this->Number->toPercentage(($result_sum['us_pracodawca'] / $result_sum['total']) * 100) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US_PRACODAWCA'); ?>
                        : <strong><?= $result_sum['us_pracodawca']; ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['us_pracodawca'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                </div>
                <div class="progress-bar progress-bar-zus"
                     data-template='<div class="tooltip progress-bar-zus" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?>: <strong><?= $result_sum['zus']; ?> zł (<?= $this->Number->toPercentage(($result_sum['zus'] / $result_sum['total']) * 100) ?>)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top"
                     style="width: <?= $this->Number->toPercentage(($result_sum['zus'] / $result_sum['total']) * 100) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?>
                        : <strong><?= $result_sum['zus']; ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['zus'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                </div>
                <div class="progress-bar progress-bar-pit"
                     data-template='<div class="tooltip progress-bar-pit" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?>: <strong><?= $result_sum['pit']; ?> zł (<?= $this->Number->toPercentage(($result_sum['pit'] / $result_sum['total']) * 100) ?>)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top"
                     style="width: <?= $this->Number->toPercentage(($result_sum['pit'] / $result_sum['total']) * 100) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?>
                        : <strong><?= $result_sum['pit']; ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['pit'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                </div>
                <div class="progress-bar progress-bar-vat"
                     data-template='<div class="tooltip progress-bar-vat" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?>: <strong><?= $result_sum['vat']; ?> zł (<?= $this->Number->toPercentage(($result_sum['vat'] / $result_sum['total']) * 100) ?>)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top"
                     style="width: <?= $this->Number->toPercentage(($result_sum['vat'] / $result_sum['total']) * 100) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?>
                        : <strong><?= $result_sum['vat']; ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['vat'] / $result_sum['total']) * 100) ?>
                            )</strong></strong></span>
                </div>
                <div class="progress-bar progress-bar-akcyza"
                     data-template='<div class="tooltip progress-bar-akcyza" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='<?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?>: <strong><?= $result_sum['akcyza']; ?> zł (<?= $this->Number->toPercentage(($result_sum['akcyza'] / $result_sum['total']) * 100) ?>)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top"
                     style="width: <?= $this->Number->toPercentage(($result_sum['akcyza'] / $result_sum['total']) * 100) ?>">
                    <span class="sr-only"><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?>
                        : <strong><?= $result_sum['akcyza']; ?> zł
                            (<?= $this->Number->toPercentage(($result_sum['akcyza'] / $result_sum['total']) * 100) ?>
                            )</strong></span>
                </div>
            </div>
            <div class="info_numbers">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_BRUTTO'); ?></small>
                    <strong><?= $result_sum['brutto']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_NETTO'); ?></small>
                    <strong><?= $result_sum['netto']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-newline">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US'); ?></small>
                    <strong><?= $result_sum['us']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_US_PRACODAWCA'); ?></small>
                    <strong><?= $result_sum['us_pracodawca']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?></small>
                    <strong><?= $result_sum['zus']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?></small>
                    <strong><?= $result_sum['pit']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?></small>
                    <strong><?= $result_sum['vat']; ?> zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?></small>
                    <strong><?= $result_sum['akcyza']; ?> zł</strong>
                </div>
            </div>
            <div class="row items">
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
