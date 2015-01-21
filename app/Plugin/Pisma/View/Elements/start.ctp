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
                <label><input name="szablon_id" value="35" type="radio">Wniosk o udostępnienie
                    informacji publicznej</label>
            </div>
            <div class="radio">
                <label><input name="szablon_id" value="40" type="radio">Skarga na bezczynność organu</label>
            </div>

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

            <input type="hidden" name="adresat_id"/>

            <div class="list adresaciList content" style="display: none">
                <ul class="ul-raw"></ul>
            </div>
            <span
                class="help-block">Na podstawie wybranego adresata, uzupełnimy dane teleadresowe w Twoim piśmie.</span>
        </div>
    </div>
</fieldset>