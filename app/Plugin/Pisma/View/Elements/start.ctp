<?php $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-button.js') ?>

<fieldset>
    <div class="form-group szablony">
        <label for="szablonSelect" class="col-lg-2 control-label">Szablon</label>

        <div class="col-lg-10">
            <div class="radio">
                <label><input name="szablon_id" value="0" checked="" type="radio">Brak
                    szablonu</label>
            </div>
            <div class="radio">
                <label><input name="szablon_id" value="35"
                              type="radio"<?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] == 35) {
                        echo ' checked="checked"';
                    } ?>>Wniosk o udostępnienie
                    informacji publicznej</label>
            </div>
            <div class="radio">
                <label><input name="szablon_id" value="40"
                              type="radio"<?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] == 40) {
                        echo ' checked="checked"';
                    } ?>>Skarga na bezczynność organu</label>
            </div>
            <?php if (!empty($pismo['szablon_id']) && $pismo['szablon_id'] != 35 && $pismo['szablon_id'] != 40) { ?>
                <div class="radio">
                    <label><input name="szablon_id" value="<?php echo $pismo['szablon_id'] ?>" type="radio"
                                  checked="checked"><?php echo $pismo['nazwa'] ?></label>
                </div>
            <?php }; ?>

            <div class="templates_browser">
                <a href="#" class="pisma-list-button pisma-list-button-no-jump">Zobacz wszystkie
                    szablony &raquo;</a>
            </div>

        </div>
    </div>
</fieldset>

<fieldset>
    <div class="form-group adresaci">
        <label for="adresatSelect" class="col-lg-2 control-label">Adresat</label>

        <div class="col-lg-10">
            <input class="form-control input-lg" id="adresatSelect"
                   placeholder="Zacznij pisać aby znaleźć adresata..."
                   type="text" autocomplete="off"/>

            <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
                echo ' value="' . $pismo['adresat_id'] . '"';
            } ?>>

            <div class="list adresaciList content" style="display: none">
                <ul class="ul-raw"></ul>
            </div>
            <span
                class="help-block">Na podstawie wybranego adresata, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
        </div>
    </div>
</fieldset>