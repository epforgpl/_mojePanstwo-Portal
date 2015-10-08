<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>

<?php $this->Combinator->add_libs('js', 'Start.letters.js') ?>
<?php $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?php echo $this->Html->script('/Start/js/zeroclipboard', array('block' => 'scriptBlock')); ?>

<? $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

<?= $this->element('Start.pageBegin'); ?>

<form action="" method="post">
    <header class="collection-header">
        <div class="overflow-auto">
            <div class="content col-xs-12 row pull-left">
                <i class="object-icon icon-applications-pisma"></i>

                <div class="object-icon-side titleBlock">
                    <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                        <a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"><?= $pismo['nazwa'] ?></a>
                        <i class="glyphicon glyphicon-edit"></i>
                    </h1>

                    <div class="input-group hide">
                        <input type="text" class="form-control" name="pismoTitleInput" value="<?= $pismo['nazwa'] ?>">

                        <div class="input-group-btn">
                            <button class="btn btn-primary save" type="button">Zapisz</button>
                            <button class="btn btn-default cancel" type="button">Anuluj</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="letter-meta">
                            <p>Autor:
                                <b><? echo ($pismo['from_user_type'] == 'account') ? $pismo['from_user_name'] : "Anonimowy użytkownik" ?></b>
                            </p>
                            <? if ($pismo['sent']) { ?>
                                <p class="small"><b>To pismo zostałe wysłane do
                                        adresata <?= $this->Czas->dataSlownie($pismo['sent_at']) ?></b></p>
                            <? } else { ?>
                                <p class="small"><b>Przed wysłaniem pisma należy je zapisać</b></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="editor-tooltip">
                <div id="sendPismoModal" class="modal fade" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Wysyłanie pisma</h4>
                            </div>
                            <form action="<?= $href_base ?>" method="POST">
                                <div class="modal-body">

                                    <? if ($this->Session->read('Auth.User.id')) { ?>

                                        <p>Twoje pismo zostanie wysłane z adresu <span
                                                class="email">pisma@mojepanstwo.pl</span> na
                                            adres:</p>

                                        <p class="email email-big text-center"><?= $pismo['to_email'] ?></p>

                                        <div class="additional-desc">
                                            <p>W polu <b>CC</b> wiadomości zostanie podany Twój
                                                adres e-mail - otrzymasz więc kopię wysłanego
                                                pisma.
                                            </p>

                                            <p>W polu <b>Reply-to</b> wiadomości również
                                                zostanie podany Twój adres email, aby adresat
                                                przesłał odpowiedź bezpośrednio na Twój adres.
                                            </p>
                                        </div>

                                    <? } else { ?>

                                        <p>Twoje pismo zostanie wysłane z adresu <span
                                                class="email">pisma@mojepanstwo.pl</span> na
                                            adres:</p>

                                        <p class="email email-big text-center"><?= $pismo['to_email'] ?></p>

                                        <div class="form-group">
                                            <label for="senderName">Podaj swoje imię i nazwisko bądź nazwę
                                                instytucji:</label>
                                            <input name="name" class="form-control" type="text" id="senderName"
                                                   value="" required="required"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="senderEmail">Podaj swój adres e-mail:</label>
                                            <input name="email" class="form-control" type="email"
                                                   id="senderEmail" required="required"/>
                                        </div>

                                        <div class="additional-desc">
                                            <p>W polu <b>CC</b> wiadomości zostanie podany Twój
                                                adres e-mail - otrzymasz więc kopię wysłanego
                                                pisma.
                                            </p>

                                            <p>W polu <b>Reply-to</b> wiadomości również
                                                zostanie podany Twój adres email, aby adresat
                                                przesłał odpowiedź bezpośrednio na Twój adres.
                                            </p>
                                        </div>

                                    <? } ?>

                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Zamknij
                                    </button>
                                    <input name="send" value="Wyślij" type="submit" class="btn btn-primary"
                                           value="Wyślij"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <? if ($pismo['is_owner']) {
                    if (!$this->Session->read('Auth.User.id')) { ?>
                        <div class="alert alert-dismissable alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <h4>Uwaga!</h4>

                            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24
                                godziny. <a
                                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale
                                przechowywać pisma na
                                swoim koncie.</p>
                        </div>
                    <? } ?>
                    <ul class="form-buttons">
                        <? if ($pismo['access'] == 'private') { ?>
                            <li class="inner-addon col-xs-12">
                                <form action="" method="post">
                                    <input type="hidden" name="access" value="public">

                                    <p><b>To pismo jest prywatne.</b> Tylko Ty masz do niego dostęp.
                                        <button class="clean" type="submit">Kliknij, aby udostępnić to pismo
                                            publicznie.
                                        </button>
                                    </p>
                                </form>
                            </li>
                        <? } elseif ($pismo['access'] == 'public') { ?>
                            <li class="inner-addon col-xs-12">
                                <form action="" method="post">
                                    <input type="hidden" name="access" value="private">

                                    <p>
                                        <b>To pismo jest publiczne.</b>
                                        <button class="clean" type="submit">Kliknij, aby zmienić jego widoczność
                                            na prywatną.
                                        </button>
                                    </p>
                                </form>
                            </li>
                            <li class="inner-addon col-xs-12 col-sm-6 col-md-4">
                                <div class="form-group clipboard">
                                    <label for="clipboardCopy">Link do dokumentu</label>

                                    <div class="input-group">
                                        <input id="clipboardCopy" type="text" class="form-control"
                                               readonly="readonly"
                                               value="<?php echo Router::url($this->here, true); ?>"/>
                                        <span class="input-group-btn">
                                            <button id="clipboardCopyBtn"
                                                    class="btn btn-default glyphicon glyphicon-copy"
                                                    data-clipboard-text="<?php echo Router::url($this->here, true); ?>"
                                                    type="button"></button>
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li class="inner-addon col-xs-12 col-sm-6 col-md-4 shareIt">
                                <span><strong>Udostępnij</strong></span>

                                <div id="fb-root"></div>
                                <a class="btn btn-social-icon btn-facebook"
                                   href="http://www.facebook.com/sharer.php?u=<?php echo Router::url($this->here, true); ?>"
                                   target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a class="btn btn-social-icon btn-twitter" href="https://twitter.com/share"
                                   target="_blank"
                                   data-url="<?php echo Router::url($this->here, true); ?>"
                                   data-lang="<?php if (Configure::read('Config.language') == 'pol') {
                                       echo('pl');
                                   } else {
                                       echo('en');
                                   } ?>">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a class="btn btn-social-icon btn-wykop"
                                   href="http://www.wykop.pl/dodaj/link/?url=<?php echo Router::url($this->here, true); ?>&title=<?= $pismo['nazwa'] ?>"
                                   target="_blank">
                                    <img class="fa" src="/Start/img/wykop_logo.png" alt="wykop.pl"
                                         onerror="imgFixer(this)"/>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                <? } ?>
            </div>
            <ul class="buttons pull-right col-xs-12">
                <li class="inner-addon">
                    <form onsubmit="return confirm('Czy na pewno chcesz usunąć to pismo?');"
                          method="post"
                          action="/moje-pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>">
                        <button name="delete" type="submit" class="btn btn-icon btn-danger"><i
                                class="icon glyphicon glyphicon-trash"></i>Skasuj
                        </button>
                    </form>
                </li>
                <li class="inner-addon">
                    <a href="<?= $href_base . '/responses' ?>" target="_self"
                       class="btn btn-success btn-icon"><i
                            class="icon glyphicon glyphicon-comment"></i>Odpowiedzi</a>
                </li>
                <? if (!$pismo['sent']) { ?>
                    <li class="inner-addon">
                        <a href="<?= $href_base . '/edit' ?>" target="_self"
                           class="btn btn-default btn-icon"><i
                                class="icon glyphicon glyphicon-edit"></i>Edytuj</a>
                    </li>
                <? } ?>
                <? if ($pismo['to_email']) { ?>
                    <li class="inner-addon">
                        <? if (!$pismo['sent']) { ?>
                            <a title="Możesz wysłać pismo do adresata poprzez e-mail"
                               href="#" target="_self"
                               class="btn btn-primary sendPismo btn-icon"><i
                                    class="icon glyphicon glyphicon-send"></i>Wyślij...</a>
                        <? } ?>
                    </li>
                <? } ?>
            </ul>
        </div>
    </header>
</form>

<div id="stepper">
    <div class="content clearfix">
        <div class="col-xs-12 view norightpadding">
            <? echo $this->element('Start.letters-render'); ?>
        </div>
    </div>
</div>

<?= $this->element('Start.pageEnd'); ?>
