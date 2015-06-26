<div class="opt btn btn-default btn-xs addBackgroundBtn"><?= ($customBackground) ? 'Zmień' : 'Dodaj' ?> obrazek tła</div>

<div class="modal modalAdmin fade" id="modalAdminAddBackground" tabindex="-1" role="dialog"
     aria-labelledby="modalAdminAddBackgroundLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= ($customBackground) ? 'Zmień' : 'Dodaj' ?> obrazek
                    tła</h4>
            </div>
            <div class="modal-body">
                <div class="image-editor">
                    <div class="cropit-image-preview"<? if ($customBackground) {
                        echo ' data-image="/pages/cover/' . $dataset . '/' . $object_id . '.jpg"';
                    } ?>></div>
                    <p>Zalecany rozmiar: 1500x400px</p>
                    <span class="btn btn-default btn-file">Przeglądaj<input type="file"
                                                                            class="cropit-image-input"/></span>
                </div>
            </div>
            <div class="modal-footer">
                <? if ($customBackground) { ?>
                    <button type="button" class="btn btn-link delete" data-type="cover">Usuń tło</button>
                <? } ?>
                <button type="button" class="btn btn-primary export">Dodaj</button>
            </div>
        </div>
    </div>
</div>