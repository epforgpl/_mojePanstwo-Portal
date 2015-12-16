<?

$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.letters-responses.js') ;

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
                            <strong><? echo ($pismo['from_user_type'] == 'account') ? $pismo['from_user_name'] : "Anonimowy użytkownik" ?></strong>
                        </p>
                        <? if ($pismo['sent']) { ?>
                            <p class="small"><strong>To pismo zostałe wysłane do
                                    adresata <?= $this->Czas->dataSlownie($pismo['sent_at']) ?>.</strong></p>
                        <? } else { ?>
                            <p class="small"><strong>To pismo nie zostało jeszcze wysłane.</strong></p>
                        <? } ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h1><span class="icon glyphicon glyphicon-comment"></span> <?= $response['Response']['title'] ?>
                    </h1>
                    <div class="letter-meta">
                        <p>Data:
                            <strong><?= dataSlownie($response['Response']['date']) ?></strong>
                        </p>
                    </div>

                    <div class="margin-top-20">
                        <p><?= $response['Response']['content'] ?></p>
                    </div>

                    <div class="margin-top-20">
                        <h2><span class="icon glyphicon glyphicon-comment"></span> Pliki</h2>
                        <? if(count($response['Response']['files'])) { ?>

                            <ul class="list-group">
                                <? foreach($response['Response']['files'] as $file) { ?>
                                    <li class="list-group-item">
                                        <span class="badge"><?= dataSlownie($file['ResponseFile']['created_at']) ?></span>
                                        <?= $file['ResponseFile']['filename'] ?>
                                    </li>
                                <? } ?>
                            </ul>

                        <? } else { ?>
                            <p>Brak plików</p>
                        <? } ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</header>

<?= $this->element('Start.pageEnd'); ?>
