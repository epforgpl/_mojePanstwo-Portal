<?

$this->Combinator->add_libs('js', 'Start.collections-view.js');
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

echo $this->element('Start.pageBegin'); ?>

<header>
    <h1><?= $item->getData('nazwa') ?></h1>
    <?= dataSlownie($item->getData('czas_utworzenia')) ?>
</header>

<div class="margin-top-10">
    <div class="mp-sticky collectionToolbar">
        <form action="" method="post">
            <button class="btn btn-default deleteBtn hide" type="submit">
                <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                Usuń zaznaczone dokumenty
            </button>
            <a href="<?= $item->getUrl() ?>/edytuj" class="btn btn-default">
                <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                Edytuj
            </a>
            <input type="hidden" name="action" value="delete"/>
            <button class="btn btn-default btnRemove" type="submit">
                <i class="glyphicon glyphicon-remove" aria-hidden="true"></i>
                Usuń
            </button>
        </form>
    </div>
</div>

<div class="block block-simple col-sm-12 margin-top-20 collectionObjects" data-collection-id="<?= $item->getId() ?>">

	<header class="nopadding">Dokumenty w tej kolekcji:</header>

    <div class="row">
        <?= $this->element('Dane.DataBrowser/browser-content', array(
            'displayAggs' => false,
            'app_chapters' => false,
            'forceHideAggs' => true,
            'beforeItemElement' => 'Dane.DataBrowser/checkbox',
        )); ?>
    </div>

</div>

<?= $this->element('Start.pageEnd'); ?>
