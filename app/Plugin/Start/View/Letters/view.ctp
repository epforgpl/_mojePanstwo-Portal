<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letter', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start'))); ?>

<?
echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<?
// dropzone
$this->Html->css(array('dropzone'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Combinator->add_libs('js', 'dropzone.js');

// datepicker
$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));

// tinymce
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

$accessDict = array(
    'prywatne',
    'publiczne'
);

$this->Combinator->add_libs('js', 'Start.letters-responses-editor.js');

$share_url = 'https://mojepanstwo.pl/dane/pisma/' . $pismo['numeric_id'];

if ($pismo['object_id']) {
    $share_url = 'https://mojepanstwo.pl/dane/' . $pismo['page_dataset'] . '/' . $pismo['page_object_id'] . ',' . $pismo['page_slug'] . '/pisma/' . $pismo['numeric_id'];
}
?>
<?php $this->Combinator->add_libs('js', 'Start.pismo.js') ?>
<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?php echo $this->Html->script('/Start/js/zeroclipboard', array('block' => 'scriptBlock')); ?>

<? $href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>


<div class="app-content-wrap">
    <div class="objectsPage">

        <?= $this->element('letters/header') ?>

        <?= $this->element('letters/menu', array(
            'plugin' => 'Start',
            'active' => 'view',
        )); ?>

        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="block">
                        <section class="content">
                            <div class="letter-render">
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-8">
                                        <div class="nadawca"><?= nl2br($pismo['from_str']); ?></div>
                                    </div>
                                    <div class="col-md-4">
                                        <?
                                        $parts = array();
                                        if ($pismo['miejscowosc'])
                                            $parts[] = $pismo['miejscowosc'];
                                        if ($pismo['data_pisma'])
                                            $parts[] = dataSlownie($pismo['data_pisma'], array(
                                                'relative' => false,
                                            ));
                                        ?>
                                        <div class="miejsce_data"><?= implode(', ', $parts) ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-7">
                                        <div class="adresat"><?= $pismo['to_str']; ?></div>
                                    </div>
                                </div>
                                <h2 class="tytul"><?= $pismo['title']; ?></h2>
                                <div class="tresc"><?= $pismo['content']; ?></div>
                                <div class="row">
                                    <div class="col-md-5 col-md-offset-7">
                                        <div class="podpis"><?= nl2br($pismo['podpis']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="lettersResponses">
                        <div class="row margin-top-20">
                            <div class="col-md-12">
                                <ul class="responses">
                                    <? if (isset($responses) && is_array($responses) && count($responses)) { ?>
                                        <? foreach ($responses as $response) { ?>
                                            <li class="response"
                                                data-letter-id="<?= $response['Response']['letter_id'] ?>"
                                                data-letter-slug="<?= $pismo['slug'] ?>"
                                                data-id="<?= $response['Response']['id'] ?>"
                                                data-title="<?= $response['Response']['title'] ?>"
                                                data-date="<?= $response['Response']['date'] ?>"
                                                data-files="<?= htmlspecialchars(json_encode($response['files'])) ?>"
                                                data-content="<?= htmlspecialchars($response['Response']['content']) ?>">
                                                <ul class="buttons">
                                                    <li>
                                                        <button
                                                            data-tooltip="true"
                                                            data-original-title="Edytuj odpowiedź"
                                                            data-placement="bottom"
                                                            class="btn btn-default editAction">
                                                            <i class="glyphicon glyphicon-edit" title="Edytuj odpowiedź"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button
                                                            data-tooltip="true"
                                                            data-original-title="Usuń odpowiedź"
                                                            data-placement="bottom"
                                                            class="btn btn-default btn">
                                                            <i class="glyphicon glyphicon-trash" title="Usuń odpowiedź"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </li>
                                                </ul>
                                                <h2>
                                                    <?= $response['Response']['title'] ?>
                                                    <span
                                                        class="date"><?= dataSlownie($response['Response']['date']) ?></span>
                                                </h2>

                                                <div class="content">
                                                    <?= $response['Response']['content'] != '' ? $response['Response']['content'] : 'Brak treści' ?>
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

                                <? if ($pismo['sent']) { ?>
                                    <p class="buttons text-center">
                                        <button
                                            data-action="add_response"
                                            data-letter-alphaid="<?= $pismo['alphaid'] ?>"
                                            data-letter-slug="<?= $pismo['slug'] ?>"
                                            class="btn btn-success btn-icon width-auto">
                                            <span class="icon glyphicon glyphicon-plus-sign"></span>Dodaj odpowiedź na
                                            pismo
                                        </button>
                                    </p>
                                <? } ?>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">

                    <? if ($pismo['is_public']) { ?>
                        <div class="shareList">
                            <p>Podziel się pismem:</p>
                            <ul class="share share-center">
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>"
                                       onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>', 'mywin',
                                           'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                       class="btn btn-social-icon btn-sm btn-facebook"><span
                                            class="fa fa-facebook"></span></a>
                                </li>
                                <li><a href="https://twitter.com/home?status=<?= $share_url ?>"
                                       onclick="window.open('https://twitter.com/home?status=<?= $share_url ?>', 'mywin',
                                           'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                       class="btn btn-social-icon btn-sm btn-twitter"><span
                                            class="fa fa-twitter"></span></a></li>
                                <li><a href="http://www.wykop.pl/dodaj/link/?url=<?= $share_url ?>"
                                       onclick="window.open('http://www.wykop.pl/dodaj/link/?url=<?= $share_url ?>', 'mywin',
                                           'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                       class="btn btn-social-icon btn-sm btn-wykop"></a></li>
                            </ul>
                            <p class="_label">Pismo dostępne pod adresem:</p>
                            <input class="form-control" type="text" readonly="readonly" value="<?= $share_url ?>"/>
                        </div>
                    <? } ?>

                    <?= $this->element('letters/side', array('plugin' => 'Start',)); ?>

                    <? if (!$pismo['is_public']) { ?>
                        <button class="btn btn-primary btn-icon width-auto margin-top-15" data-toggle="modal"
                                data-target="#accessOptions">
                            <i class="icon glyphicon glyphicon-eye-open"></i>Opublikuj pismo...
                        </button>

                        <div class="modal fade" id="accessOptions" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="well bs-component mp-form margin-top-0 margin-bottom-0">
                                        <div class="modal-body padding-bottom-0 margin-bottom-0">
                                            <form action="" id="form-visibility" class="form-horizontal" method="post">
                                                <fieldset>
                                                    <legend>Widoczność pisma</legend>
                                                    <div class="form-group">
                                                        <div class="col-lg-12" id="visibility_inputs"
                                                             data-value="<?= $pismo['is_public'] ? '1' : '0' ?>">
                                                            <? foreach ($accessDict as $value => $label) { ?>
                                                                <div class="radio">
                                                                    <input
                                                                        id="access<?= $value ?>"
                                                                        type="radio"
                                                                        name="is_public"
                                                                        value="<?= $value ?>"
                                                                        <?= ((int)$pismo['is_public'] == $value) ? 'checked' : '' ?>>
                                                                    <label for="access<?= $value ?>">
                                                                        <?= ucfirst($label) ?>
                                                                    </label>
                                                                </div>
                                                            <? } ?>
                                                        </div>

                                                    </div>
                                                    <div
                                                        class="form-group form-visibility-display"<? if (!$pismo['is_public']) { ?> style="display: none;"<? } ?>>
                                                        <div class="col-lg-12">
                                                            <p class="_label"><? if ($pismo['is_public']) { ?>Twoje pismo jest dostępne pod adresem:<? } else { ?>Twoje pismo będzie dostępne pod adresem:<? } ?></p>

                                                            <div><input class="form-control" type="text"
                                                                        readonly="readonly"
                                                                        value="<?= $share_url ?>"/></div>

                                                            <a class="anonymize col-xs-12 margin-top-10"
                                                               href="<?= '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug'] . '/anonymize'; ?>"
                                                               target="_self"><? if ($pismo['is_public']) { ?>Anonimizuj to pismo<? } else { ?>Chcesz zanonimizować to pismo przed opublikowaniem?<? } ?></a>

                                                        </div>
                                                    </div>
                                                    <div class="form-group margin-top-20">
                                                        <div class="col-lg-9">
                                                            <button type="reset" data-dismiss="modal"
                                                                    class="btn btn-default">Anuluj
                                                            </button>
                                                            <button type="submit" name="save"
                                                                    class="btn btn-md btn-primary btn-icon"><i
                                                                    class="icon glyphicon glyphicon-ok"></i>Zapisz
                                                            </button>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>

                    <? if (!$pismo['sent']) { ?>
                        <button data-action="send" class="lettersSend btn btn-primary btn-icon width-auto margin-top-15"
                                data-toggle="modal" data-target="#sendPismoModal">
                            <i class="icon glyphicon glyphicon-send"></i>Wyślij pismo...
                        </button>

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
                                                    class="btn btn-primary btn-icon width-auto"><i
                                                    class="icon glyphicon glyphicon-send"></i>Wyślij pismo
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <? } ?>

                </div>
            </div>

        </div>
    </div>
</div>
