<div class="opt btn btn-default addLogoBtn"><?= ($customLogo) ? 'Zmień' : 'Dodaj' ?> logo</div>

<div class="modal modalAdmin fade" id="modalAdminAddLogo" tabindex="-1" role="dialog"
     aria-labelledby="modalAdminAddLogoLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= ($customLogo) ? 'Zmień' : 'Dodaj' ?> logo</h4>
            </div>
            <div class="modal-body">
                <div class="image-editor">
                    <div class="cropit-image-preview"<? if ($customLogo) {
                        echo ' data-image="/pages/logo/' . $dataset . '/' . $object_id . '.png"';
                    } ?>></div>
                    <p>Zalecany rozmiar: 180x180px</p>
                    <span class="btn btn-default btn-file">Przeglądaj<input type="file"
                                                                            class="cropit-image-input"/></span>
                </div>
            </div>
            <div class="modal-footer">
                <? if ($customLogo) { ?>
                    <button type="button" class="btn btn-link delete" data-type="logo">Usuń logo</button>
                <? } ?>
                <button type="button" class="btn btn-primary export">Dodaj</button>
            </div>
        </div>
    </div>
</div>