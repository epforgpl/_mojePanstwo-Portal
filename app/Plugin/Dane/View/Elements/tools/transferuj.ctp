<div class="banner transferuj block<? if (isset($class)) echo " " . $class; ?>">
    <?php echo $this->Html->image('Dane.banners/pisma.svg', array('width' => '92', 'alt' => 'Stwórz pismo do organizacji', 'class' => 'pull-right')); ?>
    <p><?= isset($label) ? $label : '<strong>Wesprzyj</strong> darowizną organizację'; ?></p>
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#transferujModal">Wyślij
        darowiznę
    </button>
</div>

<div class="modal fade" id="transferujModal" tabindex="-1" role="dialog" aria-labelledby="transferujModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="transferujModalLabel"></h4>
            </div>
            <form action="https://secure.tpay.com" method="post" accept-charset="utf-8">
                <fieldset>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $transferuj_id; ?>" required>

                        <div class="form-group">
                            <label for="transferujModalKwota">Kwota</label>
                            <input type="number" name="kwota" class="form-control" id="transferujModalKwota"
                                   value="0.00" required>
                        </div>
                        <div class="form-group">
                            <label for="transferujModalOpis">Opis transakcji</label>
                            <input type="text" name="opis" class="form-control" id="transferujModalOpis"
                                   placeholder="Opis transakcji" maxlength="128" required>
                        </div>

                        <span class="col-xs-12 small">Poniższe pola są opcjonalne</span>
                        <div class="form-group">
                            <label for="transferujModalEmail">Adres email</label>
                            <input type="email" name="email" class="form-control" id="transferujModalEmail"
                                   placeholder="Podaj swój adres email">
                        </div>
                        <div class="form-group">
                            <label for="transferujModalNazwisko">Nazwisko</label>
                            <input type="text" name="nazwisko" class="form-control" id="transferujModalNazwisko"
                                   placeholder="Nazwisko">
                        </div>
                        <div class="form-group">
                            <label for="transferujModalImie">Imię</label>
                            <input type="text" name="imie" class="form-control" id="transferujModalImie"
                                   placeholder="Imię">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="Przejdź do płatności">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
