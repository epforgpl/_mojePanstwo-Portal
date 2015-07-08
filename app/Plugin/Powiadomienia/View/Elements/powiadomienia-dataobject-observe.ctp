<?php
$this->Combinator->add_libs('js', 'Powiadomienia.modal-observe');
?>
<div class="modal fade" id="observeModal" tabindex="-1" role="dialog" aria-labelledby="observeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="observeModalLabel">Obserwuj</h4>
            </div>
            <form action="/dane/subscriptions" method="post">
                <div class="modal-body">
                    <p class="header">Otrzymuj powiadomienia o nowych danych związanych z "<span></span>"</p>

                    <div class="alert alert-danger" role="alert">
                        <p>Prosze zaznaczyć przynajmniej jeden kanał do obserwowania</p>
                    </div>
                    <input type="hidden" name="dataset" value=""/>
                    <input type="hidden" name="object_id" value=""/>

                    <div class="options loading">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary btn-icon submit">
                        <i class="icon" data-icon="&#xe604;"></i>Zapisz</a>
                    <a href="#" class="btn btn-link unobserve">Przestań obserwować</a>
                </div>
            </form>
        </div>
    </div>
</div>