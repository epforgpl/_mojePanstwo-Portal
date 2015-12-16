<?php
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start')));

$accessDict = array(
    'prywatne',
    'publiczne'
);
$href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug'];

$share_url = 'https://mojepanstwo.pl/dane/pisma/' . $pismo['numeric_id'];
if ($pismo['object_id']) {
    $share_url = 'https://mojepanstwo.pl/dane/' . $pismo['page_dataset'] . '/' . $pismo['page_object_id'] . ',' . $pismo['page_slug'] . '/pisma/' . $pismo['numeric_id'];
}

$this->Combinator->add_libs('js', 'Start.rangy/rangy-core.js');
$this->Combinator->add_libs('js', 'Start.rangy/rangy-classapplier.js');
$this->Combinator->add_libs('js', 'Start.rangy/rangy-textrange.js');
$this->Combinator->add_libs('js', 'Start.rangy/rangy-highlighter.js');
$this->Combinator->add_libs('js', 'Start.letters-anonymize.js');
?>
<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?= $this->element('Start.pageBegin'); ?>

<header class="collection-header">
    <ul class="breadcrumb">
        <li><a href="/moje-pisma">Moje Pisma</a></li>
        <li><a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">Pismo</a></li>
        <li class="active">Anonimizacja</li>
    </ul>
    <div class="overflow-auto">
        <div class="content pull-left">
            <span class="object-icon icon-applications-pisma"></span>

            <div class="object-icon-side">
                <h1 data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                    <? if ($pismo['is_owner']) { ?>
                        <input data-url="/start/letters/setDocumentName/<?= $pismo['alphaid'] ?>"
                               class="form-control h1-editable" type="text" name="nazwa"
                               value="<?= $pismo['nazwa'] ?>"/>
                    <? } else { ?>
                        <?= $pismo['nazwa'] ?>
                    <? } ?>
                </h1>
            </div>
        </div>


    </div>
</header>

<div class="alert alert-success margin-top-15">
    <h4>Anonimizacja</h4>

    <p>Zaznacz fragmenty pisma, których nie chcesz ujawnić publicznie. Gdy będziesz gotowy, naciśnij przycisk "Opublikuj
        pismo" na dole ekranu.</p>
</div>

<div class="letter-table">
    <div class="row">
        <div class="col-sm-2">
            <p class="_label">Od:</p>
        </div>
        <div class="col-sm-10">
            <p><?= $pismo['page_name'] ? $pismo['page_name'] : $pismo['from_user_name'] ?></p>
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
            <div class="text anonymize">
                <?= $pismo['content'] ?>
            </div>
        </div>
    </div>

</div>

<form id="anonimizePublicForm" method="post" action="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
<div class="text-center">
    <a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>" class="btn btn-default">Anuluj</a>
    <input type="hidden" name="is_public" value="1" />
    <input type="hidden" name="save" value="1" />
    <input type="hidden" name="public_content" id="public_content_input" value="" />
    <button type="button" name="save" class="btn btn-md btn-primary btn-icon anonimizePublicBtn"><i
            class="icon glyphicon glyphicon-ok"></i>Anonimizuj i publikuj pismo
    </button>
</div>
</form>

<?= $this->element('Start.pageEnd'); ?>
