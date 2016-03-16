<? echo $this->Html->css($this->Less->css('gamification')); ?>
<? $this->Combinator->add_libs('js', array('gamification')); ?>

<div class="modal fade gamification" id="gaminification-exit" tabindex="-1" role="dialog"
     aria-labelledby="gamification-exit-label">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Już wychodzisz?</h4>
                <p>Zobacz więcej możliwości portalu</p>
            </div>
            <div class="modal-body homepage">
                <ul class="appsList">
                    <li class="col-xs-12 col-md-4">
                        <a href="/ngo" class="appBorder">
                            <div class="mainpart">
                                <img class="icon" src="/Ngo/icon/icon_ngo.svg">
                                <strong>NGO</strong>
                            </div>
                            <div class="subpart">
                                <p class="title">Znajdź oraz zarządzaj kontem swojej organizacji i docieraj do
                                    wspierających</p>
                            </div>
                        </a>
                    </li>
                    <li class="col-xs-12 col-md-4">
                        <a href="/prawo" class="appBorder">
                            <div class="mainpart">
                                <img class="icon" src="/prawo/icon/icon_prawo.svg">
                                <strong>Prawo</strong>
                            </div>
                            <div class="subpart">
                                <p class="title">Przeglądaj ujednolicone teksty polskiego prawa</p>
                            </div>
                        </a>
                    </li>
                    <li class="col-xs-12 col-md-4">
                        <a href="/podatki" class="appBorder">
                            <div class="mainpart">
                                <img class="icon" src="/podatki/icon/icon_podatki.svg">
                                <strong>Jak są wydawane moje podatki?</strong>
                            </div>
                            <div class="subpart">
                                <p class="title">Sprawdź, ile podatków płacisz oraz na co są wydawane</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-footer text-center">
                <a href="/" type="button" class="btn btn-primary btn-lg">Zobacz wszystkie</a>
            </div>
        </div>
    </div>
</div>
