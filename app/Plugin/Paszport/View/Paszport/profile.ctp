<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>
<? $this->Combinator->add_libs('js', 'Paszport.paszport-profile.js'); ?>
<?= $this->Element('appheader'); ?>
<div class="objectsPage">
    <div class="container">
        <div class="row editProfile">
            <div class="col-md-8">
                <h3>Podstawowe informacje</h3>
                <form>
                    <div class="form-group">
                        <label for="inputUserName">Nazwa użytkownika</label>
                        <div class="form-user-edit" data-field="username">
                            <a href="#" title="Edytuj">
                                <b><?= $user['username']; ?></b>
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Adres E-mail</label>
                        <div class="form-user-edit" data-field="email">
                            <a href="#" title="Edytuj">
                                <b><?= $user['email']; ?></b>
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="inputPassword">Hasło</label>
                            <div id="form-user-edit-password">
                                <a href="#" title="Edytuj">
                                    ******
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <h3>Dodatkowe opcje</h3>
                <button type="button" class="btn btn-default remove-button">
                    <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    Usuń paszport
                </button>
            </div>
            <div class="col-md-4">
                <!-- miejsce na avatar -->
            </div>
        </div>
    </div>
</div>