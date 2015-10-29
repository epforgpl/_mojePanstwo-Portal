<?

$this->Combinator->add_libs('js', 'Start.collections-view.js');
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

echo $this->element('Start.pageBegin'); ?>

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
                    <input type="hidden" name="delete"/>
                    <button
                        data-tooltip="true"
                        data-original-title="Usuń kolekcję"
                        data-placement="bottom"
                        class="btn btn-default btnRemove btn"
                        type="submit">
                        <i class="glyphicon glyphicon-share" title="Usuń kolekcję" aria-hidden="true"></i>
                    </button>
                </li>
                <li>
                    <input type="hidden" name="delete"/>
                    <button
                        data-tooltip="true"
                        data-original-title="Usuń kolekcję"
                        data-placement="bottom"
                        class="btn btn-default btnRemove btn"
                        type="submit">
                        <i class="glyphicon glyphicon-trash" title="Usuń kolekcję" aria-hidden="true"></i>
                    </button>
                </li>
                
            </ul>
        </div>
    </header>
</form>


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

<ul class="collection-meta">
	<li>Kolekcja prywatna</li>
	<li>Redakcja: <a href="#">Fundacja ePaństwo</a></li>
</ul>

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
