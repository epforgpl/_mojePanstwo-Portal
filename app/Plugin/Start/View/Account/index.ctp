<?
echo $this->Html->css($this->Less->css('app'));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport')));

$this->Combinator->add_libs('js', 'Paszport.paszport-profile.js');

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">
        <div class="container">
            <div class="header-wrap">
                <h1 class="pull-left smaller">Ustawienia konta</h1>
            </div>
        </div>

        <div class="dataBrowser upper margin-top-25">
            <div class="container">

            </div>
            <div class="dataBrowser margin-top-0 lower">
                <div class="container">
                    <div class="dataBrowserContent">
                        <div class="row">
                            <div class="col-xs-8 dataBrowser-wrap">

                                <div class="mainForm">
                                    <form>
                                        <div class="form-group">
                                            <label for="inputUserName">Nazwa użytkownika</label>

                                            <div class="form-user-edit" data-field="username">
                                                <a href="#" title="Edytuj">
                                                    <strong><?= $user['username']; ?></strong>
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">Adres E-mail</label>

                                            <div class="form-user-edit" data-field="email">
                                                <a href="#" title="Edytuj">
                                                    <strong><?= $user['email']; ?></strong>
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div>
                                            <? if ($canCreatePassword) { ?>
                                                <div class="form-group">
                                                    <label for="inputPassword">Utwórz hasło</label>
                                                    <div id="form-user-create-password">
                                                        <a href="#" title="Edytuj">
                                                            ******
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            <? } else { ?>
                                                <div class="form-group">
                                                    <label for="inputPassword">Hasło</label>
                                                    <div id="form-user-edit-password">
                                                        <a href="#" title="Edytuj">
                                                            ******
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <input id="accountIsNgo" name="is_ngo" type="checkbox"
                                                       value="1" <?= AuthComponent::user('is_ngo') == '1' ? 'checked' : '' ?>/>
                                                <label for="accountIsNgo">
                                                    Działam w organizacji pozarządowej
                                                </label>
                                            </div>
                                        </div>
                                    </form>

                                    <button type="button" id="deletePaszportButton"
                                            class="btn btn-default remove-button margin-top-20" data-toggle="modal"
                                            data-target=".delete-paszport-modal" <? if ($canCreatePassword) echo 'disabled' ?>>
                                        <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                                        Usuń konto
                                    </button>

                                    <? if ($canCreatePassword) { ?>
                                        <p class="help-block">Opcja usunięcia konta dostępna po utworzeniu hasła.</p>
                                    <? } ?>
                                    <div class="modal fade delete-paszport-modal" tabindex="-1" role="dialog"
                                         aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myLargeModalLabel">Usuwanie konta</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Wprowadź aktualne hasło aby potwierdzić operację usunięcia
                                                        konta.</p>

                                                    <div class="form-group">
                                                        <label for="inputDeletePassword">Hasło</label>
                                                        <input id="inputDeletePassword" value="" type="password"
                                                               class="form-control"
                                                               name="deletePassword">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Anuluj
                                                    </button>
                                                    <button type="button" id="submitDeletePaszport"
                                                            class="btn btn-primary">Potwierdź
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
