<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));
$this->Combinator->add_libs('js', 'Podatki.podatki.js');
?>

<div id="podatki">
    <div class="container">
        <div class="content col-xs-12 row">
            <h1 class="text-center"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>

            <h2 class="text-center"><?= __d('podatki', 'LC_PODATKI_SUBHEADLINE'); ?></h2>
            <hr/>
            <p class="col-xs-12 col-sm-10 col-sm-offset-1"><?= __d('podatki', 'LC_PODATKI_INFORMATION', '#co_to_kwota_brutto'); ?></p>

            <div class="section">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3">
                    <div class="form-group" data-number="1">
                        <label
                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_O_PRACE'); ?></label>
                        <input type="text" class="form-control" id="przychody_umowa_o_prace_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <button
                        class="btn btn-primary pull-right"><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?></button>
                </div>
            </div>
            <div class="section">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3">
                    <div class="form-group" data-number="1">
                        <label
                            for="przychody_umowa_zlecenie_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_ZLECENIE'); ?></label>
                        <input type="text" class="form-control" id="przychody_umowa_zlecenie_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <button
                        class="btn btn-primary pull-right"><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?></button>
                </div>
            </div>
            <div class="section">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3">
                    <div class="form-group" data-number="1">
                        <label
                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_UMOWA_DZIELO'); ?></label>
                        <input type="text" class="form-control" id="przychody_umowa_o_prace_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>
                    <button
                        class="btn btn-primary pull-right"><?= __d('podatki', 'LC_PODATKI_ADD_NEW_UMOWA'); ?></button>
                </div>
            </div>
            <div class="section">
                <div class="form-inline col-xs-12 col-sm-6 col-sm-offset-3">
                    <div class="form-group" data-number="1">
                        <label
                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA'); ?></label>
                        <input type="text" class="form-control" id="przychody_umowa_o_prace_1">
                    </div>
                    <span class="info"><?= __d('podatki', 'LC_PODATKI_INFO_FULL'); ?></span>

                    <div class="checkbox">
                        <input type="checkbox"/>
                        <label> Warunki preferencyjne</label>
                    </div>
                    <div class="form-group" data-number="1">
                        <label
                            for="przychody_umowa_o_prace_1"><?= __d('podatki', 'LC_PODATKI_PRZYCHODY_DZIALALNOSC_GOSPODARCZA_KOSZT'); ?></label>
                        <input type="text" class="form-control" id="przychody_umowa_o_prace_1">
                    </div>
                    <button
                        class="btn btn-primary pull-right"><?= __d('podatki', 'LC_PODATKI_ADD_NEW_DZIALALNOSC'); ?></button>
                </div>
            </div>
            <div class="action pull-right">
                <button class="btn btn-success btn-lg">Oblicz</button>
            </div>
        </div>
    </div>
</div>
