<?

$this->Combinator->add_libs('js', 'Start.collections-view.js');
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

echo $this->element('Start.pageBegin'); ?>

<form action="" method="post">
    <header class="collection-header">
        <div class="overflow-auto">

            <div class="content pull-left">
                <i class="object-icon icon-datasets-kolekcje"></i>
                <div class="object-icon-side">
	                <h1><?= $item->getData('nazwa') ?></h1>
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
                        <i class="glyphicon glyphicon-trash" title="Usuń kolekcję" aria-hidden="true"></i>
                    </button>
                </li>
                <li>
                    <a
                        data-tooltip="true"
                        data-original-title="Edytuj kolekcję"
                        data-placement="bottom"
                        class="btn btn-default"
                        href="<?= $item->getUrl(); ?>/edytuj">
                        <i class="glyphicon glyphicon-edit" title="Edytuj kolekcję" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
    </header>
</form>

<div class="block block-simple col-sm-12 margin-top-0 collectionObjects" data-collection-id="<?= $item->getId() ?>">

    <div class="row collections-browser">
        <?= $this->element('Dane.DataBrowser/browser-content', array(
            'displayAggs' => false,
            'app_chapters' => false,
            'forceHideAggs' => true,
            'beforeItemElement' => 'Dane.DataBrowser/checkbox',
            'paginatorPhrases' => array('dokument', 'dokumenty', 'dokumentów'),
            'noResultsPhrase' => 'Kolekcja jest pusta',
        )); ?>
    </div>

</div>

<?= $this->element('Start.pageEnd'); ?>
