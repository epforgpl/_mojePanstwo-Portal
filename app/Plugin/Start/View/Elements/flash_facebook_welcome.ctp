<?php

$this->Combinator->add_libs('js', 'Start.flash-facebook-welcome.js');

?>

<div class="modal fade" id="modalFacebookWelcome">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Witaj na Moim Państwie
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Jako nowo zarejestrowany użytkownik zalecamy <strong>ustawienie prywatnego hasła</strong> oraz
                    podanie podstawowych informacji. Aby to zrobić przejdź do Ustawień konta.
                </p>
                <div class="text-center margin-top-20">
                    <a class="btn btn-lg  btn-primary" href="/konto" role="button">
                        Ustawienia konta
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zrobię to później</button>
            </div>
        </div>
    </div>
</div>

