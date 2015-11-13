<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start'))); ?>
<?php

$accessDict = array(
    'prywatna',
    'publiczna'
);

?>

<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?php echo $this->Html->script('/Start/js/zeroclipboard', array('block' => 'scriptBlock')); ?>

<? $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>


<div class="container">
    <div class="row">
        <div class="col-md-9">
            <header class="collection-header">

                <div class="overflow-auto margin-top-10">

                    <div class="content pull-left">
                        <i class="object-icon icon-applications-pisma"></i>

                        <div class="object-icon-side">
                            <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                                <? /*<a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">*/ ?>
                                <?= $pismo['nazwa'] ?>
                                <? /*</a>*/ ?>
                            </h1>
                        </div>
                    </div>

                </div>
            </header>

            <ul class="collection-meta">
                <li>Pismo <?= $pismo['is_public'] ? 'publiczne' : 'prywatne'; ?></li>
            </ul>

            <div class="letter-table">
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Od:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['from_user_name'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Do:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['to_name'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Temat:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['tytul'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text">
                            <?= $pismo['content'] ?>
                        </div>
                    </div>
                </div>
                <? if ($pismo['sent']) { ?>
                    <div class="row sent">
                        <div class="col-sm-12">
                            <p>Wysłane <?= dataSlownie($pismo['sent_at']) ?>.</p>
                        </div>
                    </div>
                <? } ?>
            </div>


            <? if (!$pismo['sent']) { ?>

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

                                        <p class="text-center">Twoje pismo zostanie wysłane z adresu <span
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
                                            data-dismiss="modal">Anuluj
                                    </button>

                                    <button name="send" value="Wyślij" type="submit"
                                            class="btn btn-warning btn-icon auto-width"><i
                                            class="icon glyphicon glyphicon glyphicon-send"></i>Wyślij pismo
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="lettersSend">
                    <div class="row margin-top-20">
                        <div class="col-md-12">

                            <p class="text-center">
                                <button data-action="send" class="btn btn-primary btn-icon auto-width"><i
                                        class="icon glyphicon glyphicon glyphicon-send"></i>Wyślij pismo...
                                </button>
                            </p>

                        </div>
                    </div>
                </div>

            <? } ?>

            <div class="lettersResponses">
                <div class="row margin-top-20">
                    <div class="col-md-12">

                        <ul class="responses">
                            <? if (isset($responses) && is_array($responses) && count($responses)) { ?>
                                <? foreach ($responses as $response) { ?>
                                    <li class="response">
                                        <h2>
                                            <?= $response['Response']['title'] ?>
                                            <span class="date"><?= dataSlownie($response['Response']['date']) ?></span>
                                        </h2>

                                        <div class="content">
                                            <?= $response['Response']['content'] != '' ? htmlspecialchars($response['Response']['content']) : 'Brak treści' ?>
                                        </div>
                                        <? if (count($response['files'])) { ?>
                                            <div class="files">
                                                <? foreach ($response['files'] as $file) { ?>
                                                    <div class="file">
                                                        <a target="_blank"
                                                           href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>/attachment/<?= $file['ResponseFile']['id'] ?>"><span
                                                                class="glyphicon glyphicon-download-alt"></span>
                                                            <?= $file['ResponseFile']['src_filename'] != '' ? $file['ResponseFile']['src_filename'] : 'Brak nazwy' ?>
                                                        </a>
                                                    </div>
                                                <? } ?>
                                            </div>
                                        <? } ?>
                                    </li>
                                <? } ?>
                            <? } ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>