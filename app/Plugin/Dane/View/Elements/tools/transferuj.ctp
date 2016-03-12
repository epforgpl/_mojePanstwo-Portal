
<div class="banner transferuj block<? if (isset($class)) echo " " . $class; ?>">
    <?php echo $this->Html->image('Dane.banners/money.svg', array('width' => '82', 'alt' => 'Wesprzyj darowizną organizację', 'class' => 'pull-right')); ?>
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

            <form action="/transactions/transactions/formSubmitAction" method="POST" accept-charset="utf-8">
                <input type="hidden" name="krs_pozycje_id" value="<?= $object->getId() ?>"/>
                <fieldset>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="transferujModalKwota">Kwota</label>
                            <div class="input-group">
                                <div class="input-group-addon">PLN</div>
                                <input type="number" name="amount" class="form-control" id="transferujModalKwota"
                                       min="0.01" step="0.01" value="0.01">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transferujModalOpis">Wiadomość</label>
                                <textarea name="message" class="form-control" id="transferujModalOpis"
                                          placeholder="Krótka wiadomość dla odbiorcy"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="transferujModalEmail">Adres email</label>
                            <input type="email" name="email" class="form-control" id="transferujModalEmail"
                                   placeholder="Podaj swój adres email">
                        </div>
                        <div class="form-group">
                            <label for="transferujModalNazwisko">Nazwisko</label>
                            <input type="text" name="surname" class="form-control" id="transferujModalNazwisko"
                                   placeholder="Nazwisko">
                        </div>
                        <div class="form-group">
                            <label for="transferujModalImie">Imię</label>
                            <input type="text" name="firstname" class="form-control" id="transferujModalImie"
                                   placeholder="Imię">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                        <input type="submit" class="btn btn-primary" value="Wyślij darowiznę">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
