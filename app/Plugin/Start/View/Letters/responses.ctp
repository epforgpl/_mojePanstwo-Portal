<?

$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.letters-responses.js') ;

// dropzone
$this->Html->css(array('dropzone'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Combinator->add_libs('js', 'dropzone.js') ;

// datepicker
$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));

$href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug'];

?>

<?= $this->element('Start.pageBegin'); ?>


<header class="collection-header">
    <div class="overflow-auto">

        <div class="content col-xs-12 row pull-left lettersResponses">

            <span class="object-icon icon-applications-pisma"></span>
            <div class="object-icon-side titleBlock">
                <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                    <a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"><?= $pismo['nazwa'] ?></a>
                </h1>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <div class="letter-meta">
                        <p>Autor:
                            <b><? echo ($pismo['from_user_type'] == 'account') ? $pismo['from_user_name'] : "Anonimowy użytkownik" ?></b>
                        </p>
                        <? if ($pismo['sent']) { ?>
                            <p class="small"><b>To pismo zostałe wysłane do
                                    adresata <?= $this->Czas->dataSlownie($pismo['sent_at']) ?>.</b></p>
                        <? } else { ?>
                            <p class="small"><b>To pismo nie zostało jeszcze wysłane.</b></p>
                        <? } ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h1><span class="icon glyphicon glyphicon-comment"></span> Dodaj odpowiedź</h1>
                    <form class="letterResponseForm margin-top-10" method="post" data-url="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>/responses.json">

                        <div class="row margin-top-10">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="responseName">Tytuł:</label>
                                    <input maxlength="195" type="text" class="form-control" id="responseName" name="name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="responseDate">Data:</label>
                                    <input type="text" value="<?= date('Y-m-d') ?>" class="form-control datepickerResponseDate" id="responseDate"  name="date">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="responseContent">Treść:</label>
                            <textarea class="form-control" rows="7" id="responseContent" name="content"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="collectionDescription">Załączniki:</label>
                            <div class="dropzoneForm">
                                <div class="actions">
                                    <a class="btn btn-default btn-addfile" href="#" role="button">Dodaj załącznik</a>
                                </div>
                                <div id="preview"></div>
                            </div>
                        </div>

                        <div class="form-group overflow-hidden text-center margin-top-20">
                            <button class="btn auto-width btn-primary btn-icon" type="submit">
                                <span class="icon glyphicon glyphicon-ok"></span>
                                Zapisz
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>
</header>

<?= $this->element('Start.pageEnd'); ?>
