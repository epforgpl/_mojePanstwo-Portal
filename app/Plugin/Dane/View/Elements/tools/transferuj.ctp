<?
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'] . '/';
?>


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

            <form action="https://secure.tpay.com" method="POST" accept-charset="utf-8">
                <fieldset>
                    <div class="modal-body">
                        <? /*TODO: all hidden to Controller*/ ?>
                        <input type="hidden" name="id" value="21638" required>
                        <input type="hidden" name="opis" value="<?= $podmiotId; ?>" required>

                        <input type="hidden"
                               value="<?= $protocol . $domainName; ?>dane/krs_podmioty/<?= $podmiotId ?>?transaction_confirmation"
                               name="wyn_url">
                        <input type="hidden" value="biuro@epf.org.pl" name="wyn_email">
                        <input type="hidden"
                               value="<?= $protocol . $domainName; ?>dane/krs_podmioty/<?= $podmiotId ?>"
                               name="pow_url">

                        <div class="form-group">
                            <label for="transferujModalKwota">Kwota</label>
                            <div class="input-group">
                                <div class="input-group-addon">PLN</div>
                                <input type="number" name="kwota" class="form-control" id="transferujModalKwota"
                                       min="0.01" step="0.01" value="0.01">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transferujModalOpis">Opis transakcji</label>
                                <textarea name="opisUser" class="form-control" id="transferujModalOpis"
                                          placeholder="Krótki opis dla odbiorcy"></textarea>
                        </div>

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
                        <input type="submit" class="btn btn-primary" name="Przejdź do płatności"
                               value="Wyślij darowiznę">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
