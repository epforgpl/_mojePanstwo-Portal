<?php $this->Combinator->add_libs('js', 'Media.twitter-account-suggestion'); ?>

<a href="#" data-toggle="modal" data-target="#twitterAccountSuggestionModal">Zaproponuj nowe konto</a>

<div class="modal fade" id="twitterAccountSuggestionModal" tabindex="-1" role="dialog"
     aria-labelledby="uprawnieniaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Zaproponuj nowe konto</h4>
            </div>
            <form class="form-horizontal" method="post">
                <div class="modal-body margin-sides-20">
                    <div class="form-group">
                        <label for="inputName">Nazwa</label>
                        <input required="required" autocomplete="off" type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="inputSurname">Typ</label>
                        <select class="form-control" name="type_id">
                            <?php foreach($types as $i => $type) { if($i == 0) continue; ?>
                                <option value="<?= $i ?>"><?= $type ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-icon text-center">
                        <i class="icon" data-icon="&#xe604;"></i>Wyślij
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
