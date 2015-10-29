<?

$this->Combinator->add_libs('js', 'Start.collections-view.js');
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

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
                
            </ul>
        </div>
    </header>
</form>

<div class="alert alert-info">Dane dotyczące dostępu do informacji publicznej. Interpleacje, ustawy i inne.</div>

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
