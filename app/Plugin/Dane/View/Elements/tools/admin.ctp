<?php $this->Combinator->add_libs('css', $this->Less->css('tool-uprawnienia', array('plugin' => 'Dane'))) ?>

<div class="banner uprawnienia block">
    <?php echo $this->Html->image('Dane.banners/zarzadzanie.svg', array('width' => '69', 'alt' => 'Aktualny odpis z KRS za darmo', 'class' => 'pull-right')); ?>
    <p><strong>Zarządzaj profilem</strong> tej organizacji</p>

    <div class="btn btn-sm btn-primary" data-toggle="modal" data-target="#uprawnieniaModal">Poproś o uprawnienia</button>
</div>

    <div class="modal fade" id="uprawnieniaModal" tabindex="-1" role="dialog" aria-labelledby="uprawnieniaModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Zostań oficjalnym właścicielem</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Portal MojePaństwo.pl pomaga Twojej organizacji docierać do osób zainteresowanych Waszymi
                        działaniami. Jak również usprawnia pracę samej organizacji oferując specjalne narzędzia dostępne
                        tylko dla oficjalnych partnerów. Aby uzyskać taki status należy wypełnić poniższy formularz a
                        skontaktujemy się w celu potwierdzenia profilu i uaktywnimy nowe funkcje. W chwili obecnej
                        poszukujemy 25 partnerów, którzy wspólnie z nami przejdą testy działań wersji beta portalu.
                    </p>

                    <form class="form-horizontal" method="post">
                        <div class="form-group">
                            <label for="inputName">Imię</label>


                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputName"
                                   name="firstname">

                        </div>
                        <div class="form-group">
                            <label for="inputSurname">Nazwisko</label>


                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputSurname"
                                   name="lastname">

                        </div>
                        <div class="form-group">
                            <label for="inputPosition">Funkcja</label>

                            <input required="required" autocomplete="off" type="text" class="form-control"
                                   id="inputPosition" name="position">
                        </div>

                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input required="required" autocomplete="off" type="email" class="form-control"
                                   id="inputEmail"
                                   name="email">
                        </div>
                        <div class="form-group">
                            <label for="inputPhone">Telefon</label>
                            <input required="required" autocomplete="off" type="phone" class="form-control"
                                   id="inputPhone"
                                   name="phone">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-icon text-center">
                                <i class="icon" data-icon="&#xe604;"></i>Wyślij
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>