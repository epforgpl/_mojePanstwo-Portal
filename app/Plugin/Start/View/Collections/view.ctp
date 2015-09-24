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
        <button class="btn btn-default deleteBtn hide" type="submit">
            <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
            Usuń zaznaczone dokumenty
        </button>
        <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
            Edytuj
        </button>
        <button class="btn btn-default" type="submit">
            <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
            Usuń
        </button>
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
