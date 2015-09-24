<?

$this->Combinator->add_libs('js', 'Start.collections-view.js');
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

echo $this->element('Start.pageBegin'); ?>

<form action="" method="post">
    <header class="collection-header">
        <div class="overflow-auto">
            <h1 class="pull-left"><?= $item->getData('nazwa') ?></h1>
            <ul class="buttons pull-right">
                <li>
                    <input type="hidden" name="delete"/>
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-trash" title="Usuń kolekcję" aria-hidden="true"></i>
                    </button>
                </li>
                <li>
                    <a class="btn btn-default" href="<?= $item->getUrl(); ?>/edytuj">
                        <i class="glyphicon glyphicon-edit" title="Edytuj kolekcję" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>
        </div>
    </header>
</form>

<div class="block block-simple col-sm-12 margin-top-0 collectionObjects" data-collection-id="<?= $item->getId() ?>">

	<? /*
	<header class="nopadding sticky overflow-auto collectionToolbar">
		<p class="pull-left">Dokumenty w tej kolekcji:</p>
		<p class="pull-right">
			<button class="btn btn-default deleteBtn hide" type="submit">
				<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
	            Usuń zaznaczone z kolekcji
			</button>
	    </p>
	</header>
	*/ ?>

    <div class="row collections-browser">
        <?= $this->element('Dane.DataBrowser/browser-content', array(
            'displayAggs' => false,
            'app_chapters' => false,
            'forceHideAggs' => true,
            'beforeItemElement' => 'Dane.DataBrowser/checkbox',
        )); ?>
    </div>

</div>

<?= $this->element('Start.pageEnd'); ?>
