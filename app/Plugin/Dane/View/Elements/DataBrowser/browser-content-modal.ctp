<div class="modal modal-api-call">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-cog"></span> REST API</h4>
            </div>
            <div class="modal-body">

                <? if (isset($dataBrowser['api_call'])) { ?>

                    <p>Aby pobrać dane widoczne na tym ekranie, wyślij żądanie HTTP GET pod adres:</p>

                    <a class="modal-api-call-link" target="_blank"
                       href="<?= $dataBrowser['api_call'] ?>"><?= htmlspecialchars($dataBrowser['api_call']) ?></a>

                <? } ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>