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

<header class="collection-header">

    <ul class="breadcrumb">
      <li><a href="/moje-kolekcje">Moje Kolekcje</a></li>
      <li class="active">Kolekcja</li>
    </ul>

    <div class="overflow-auto">

        <div class="content pull-left">
            <span class="object-icon icon-datasets-kolekcje"></span>
            <div class="object-icon-side">
                <input class="form-control h1-editable" type="text" name="nazwa" value="<?= $item->getData('nazwa') ?>"/>
            </div>
        </div>


        <form action="" method="post">
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
        </form>
    </div>
</header>


<ul class="collection-meta">
    <li>
        <a href="#" data-toggle="modal" data-target="#accessOptions">
            Kolekcja <?= $accessDict[$item->getData('is_public')] ?>
        </a>
    </li>
    <? if($item->getData('object_id')) { ?>
        <li>Redakcja: <a href="#">#<?= $item->getData('object_id') ?></a></li>
    <? } ?>
</ul>

<div class="modal fade" id="accessOptions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="well bs-component mp-form margin-top-0 margin-bottom-0">
                <div class="modal-body padding-bottom-0 margin-bottom-0">
                    <form action="" class="form-horizontal" method="post">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg-12">
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
                            </div>
                            <div class="form-group">
                                <div class="col-lg-9">
                                    <button type="reset" data-dismiss="modal" class="btn btn-default">Anuluj</button>
                                    <button type="submit" class="btn btn-md btn-primary btn-icon"><span
                                            class="icon glyphicon glyphicon-pencil"></span>Zapisz
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

<? $note = $item->getData('description'); ?>
<div class="collection-main-note alert alert-info overflow-hidden note-editable<?= $note == '' ? ' empty' : '' ?>">
    <? if($note == '') { ?>
        <p class="text-center">
            <a href="#addnote" class="btn btn-link create-note">Dodaj notatkę</a>
        </p>
    <? } else { ?>
        <div class="content">
            <?= $note ?>
        </div>

        <button
        	type="submit"
            data-tooltip="true"
            data-original-title="Edytuj"
            data-placement="bottom"
            class="btn btn-default btnNoteEdit btn">
            <i class="glyphicon glyphicon-edit" title="Edytuj notatkę" aria-hidden="true"></i>
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
            'innerParams' => array(
	            'collection' => array(
	            	'id' => $item->getId(),
	            ),
            ),
        )); ?>
    </div>

</div>

<?= $this->element('Start.pageEnd'); ?>
