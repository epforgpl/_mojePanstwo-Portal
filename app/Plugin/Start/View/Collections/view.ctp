<?

$this->Combinator->add_libs('js', 'Start.collections-view.js');
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

echo $this->element('Start.pageBegin');

$accessDict = array(
    'prywatna',
    'publiczna'
);

?>

<form action="" method="post">
    <header class="collection-header">
        
        <ul class="breadcrumb">
		  <li><a href="/moje-kolekcje">Moje Kolekcje</a></li>
		  <li class="active">Kolekcja</li>
		</ul>
        
        <div class="overflow-auto">

            <div class="content pull-left">
                <i class="object-icon icon-datasets-kolekcje"></i>
                <div class="object-icon-side">
                    <input class="form-control h1-editable" type="text" name="nazwa" value="<?= $item->getData('nazwa') ?>"/>
                </div>
            </div>

            <ul class="buttons pull-right">
                <li>
                    <a
                        data-tooltip="true"
                        data-original-title="Ustawienia prywatności"
                        data-placement="bottom"
                        data-toggle="modal"
                        data-target="#accessOptions"
                        class="btn btn-default btnAccess btn">
                        <i class="glyphicon glyphicon-share" title="Ustawienia prywatności" aria-hidden="true"></i>
                    </a>
                </li>
                <li>
                    <input type="hidden" name="delete"/>
                    <button
                        data-tooltip="true"
                        data-original-title="Usuń kolekcję"
                        data-placement="bottom"
                        class="btn btn-default btnCollectionRemove btn"
                        type="submit">
                        <i class="glyphicon glyphicon-trash" title="Usuń kolekcję" aria-hidden="true"></i>
                    </button>
                </li>
                
            </ul>
        </div>
    </header>
</form>

<ul class="collection-meta">
    <li>
        <a href="#" data-toggle="modal" data-target="#accessOptions">
            Kolekcja <?= $accessDict[$item->getData('is_public')] ?>
        </a>
    </li>
    <? if($item->getData('object_id')) { ?>
        <li>Redakcja: <a href="#">Fundacja ePaństwo</a></li>
    <? } ?>
</ul>

<div class="modal fade" id="accessOptions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ustawienia prywatności</h4>
                </div>
                <div class="modal-body">
                    <? foreach($accessDict as $value => $label) { ?>
                        <div class="radio">
                            <input
                                id="access<?= $value ?>"
                                type="radio"
                                name="is_public"
                                value="<?= $value ?>"
                                <?= $value == ((int) $item->getData('is_public')) ? 'checked' : '' ?>>
                            <label for="access<?= $value ?>">
                                <?= ucfirst($label) ?>
                            </label>
                        </div>
                    <? } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
        </form>
    </div>
</div>

<? $note = $item->getData('kolekcje.notatka'); ?>
<div class="collection-main-note alert alert-info overflow-hidden note-editable<?= $note == '' ? ' empty' : '' ?>">
    <? if($note == '') { ?>
        <p class="text-center">
            <a href="#addnote" class="btn btn-link create-note">Dodaj notatkę</a>
        </p>
    <? } else { ?>
        <div class="content">
            <?= $note ?>
        </div>
        <button class="btn btn-sm pull-right btn-default btnNoteEdit btn" type="submit">
            Edytuj
        </button>
    <? } ?>
</div>

<div class="block block-simple col-sm-12 margin-top-0 collectionObjects" data-collection-id="<?= $item->getId() ?>">

    <div class="row collections-browser">
        <?= $this->element('Dane.DataBrowser/browser-content', array(
            'displayAggs' => false,
            'app_chapters' => false,
            'forceHideAggs' => true,
            'beforeItemElement' => 'Start.DataBrowser/collection-before',
            'afterItemElement' => 'Start.DataBrowser/collection-after',
            'paginatorPhrases' => array('dokument', 'dokumenty', 'dokumentów'),
            'noResultsPhrase' => 'Kolekcja jest pusta',
            'nopaging' => true,
        )); ?>
    </div>

</div>

<?= $this->element('Start.pageEnd'); ?>
