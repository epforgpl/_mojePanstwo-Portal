<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));
$this->Combinator->add_libs('js', 'Podatki.podatki.js');
?>

<div id="podatki" class="appBanner">
    <div class="container">
        <div class="content col-xs-12 row">
            <form method="post">
                <h1 class="appTitle"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>

                <h2 class="appSubtitle"><?= __d('podatki', 'LC_PODATKI_SUBHEADLINE'); ?></h2>
                <hr/>
                <p class="col-xs-12 col-sm-10 col-sm-offset-1"><?= __d('podatki', 'LC_PODATKI_INFORMATION', '#co_to_kwota_brutto'); ?></p>

                <div class="section">
                    <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3" data-number="1">
                        <div class="form-group">
                            <label
                                for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?></label>
                            <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01" name="umowa_o_prace[]"
                                   title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                                   id="przychody_umowa_o_prace_1">
                        </div>
                        <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                        <button class="btn btn-primary btn-icon pull-right" data-type="przychody_umowa_o_prace"><i
                                class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                        </button>
                    </div>
                </div>
                <div class="section">
                    <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3" data-number="1">
                        <div class="form-group">
                            <label
                                for="przychody_umowa_zlecenie_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_ZLECENIE'); ?></label>
                            <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01" name="umowa_zlecenie[]"
                                   title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                                   id="przychody_umowa_zlecenie_1">
                        </div>
                        <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                        <button class="btn btn-primary btn-icon pull-right" data-type="przychody_umowa_zlecenie"><i
                                class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                        </button>
                    </div>
                </div>
                <div class="section">
                    <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3" data-number="1">
                        <div class="form-group">
                            <label
                                for="przychody_umowa_o_dzielo_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_DZIELO'); ?></label>
                            <input type="number" pattern="[0-9]+([\.|,][0-9]{2}+)?" step="0.01" name="umowa_o_dzielo[]"
                                   title="<?= __d('podatki', 'LC_PODATKI_INPUT_FLOAT'); ?>" class="form-control"
                                   id="przychody_umowa_o_dzielo_1">
                        </div>
                        <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                        <button class="btn btn-primary btn-icon pull-right" data-type="przychody_umowa_o_dzielo"><i
                                class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?>
                        </button>
                    </div>
                </div>
                <div class="section">
                    <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3" data-number="1">
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
                        <button class="btn btn-primary btn-icon pull-right"
                                data-type="przychody_dzialalnosc_gospodarcza"><i
                                class="icon glyphicon glyphicon-plus"></i><?= __d('podatki', 'LC_PODATKI_ADD_NEW_DZIALALNOSC'); ?>
                        </button>
                    </div>
                </div>
                <div class="action pull-right">
                    <button class="btn btn-success btn-lg" type="submit">Oblicz</button>
                </div>
            </form>
        </div>
    </div>
</div>
