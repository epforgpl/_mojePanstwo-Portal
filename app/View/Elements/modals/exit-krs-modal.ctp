<? echo $this->Html->css($this->Less->css('modals/exit-modal')); ?>
<? $this->Combinator->add_libs('js', array('modals/exit-modal')); ?>

<div class="modal fade gamification gamification-ngo" id="gaminification-exit" tabindex="-1" role="dialog"
     aria-labelledby="gamification-exit-label" data-node="krs">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Podobał się KRS?</h4>
                <p>Poznaj zestaw narzędzi, które przygotowaliśmy, aby pomóc Ci stać się skutecznym działaczem.</p>
            </div>
            <div class="modal-body homepage">
                <ul class="appsList">
                    <li class="col-xs-12 col-md-4">
                        <a href="/ngo" class="appBorder">
                            <div class="mainpart">
                                <img class="icon" src="/podatki/icon/side_podatki.svg">
                            </div>
                            <div class="subpart">
                                <p class="title">Dodatkowe źródło dofinansowań</p>
                            </div>
                        </a>
                    </li>
                    <li class="col-xs-12 col-md-4">
                        <a href="/prawo" class="appBorder">
                            <div class="mainpart">
                                <img class="icon" src="/orzecznictwo/icon/side_orzecznictwo.svg">
                            </div>
                            <div class="subpart">
                                <p class="title">Bieżące źródło wiedzy prawnej</p>
                            </div>
                        </a>
                    </li>
                    <li class="col-xs-12 col-md-4">
                        <a href="/podatki" class="appBorder">
                            <div class="mainpart">
                                <img class="icon" src="/krs/icon/side_krs.svg">
                            </div>
                            <div class="subpart">
                                <p class="title">Instytuje publiczne w jednym miejscu</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-footer text-center">
                <a href="/" type="button" class="btn btn-primary btn-lg">Chcę poznać narzędzia</a>
            </div>
        </div>
    </div>
</div>
