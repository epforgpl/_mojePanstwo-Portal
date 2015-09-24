<?

$this->Combinator->add_libs('css', $this->Less->css('collections-form', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.collections-form');

echo $this->element('Start.pageBegin'); ?>

<form class="collectionsForm" action="<?= $item->getUrl(); ?>/edytuj" method="post">

    <header>
        <h1>Edytuj Kolekcje</h1>
    </header>

    <div class="form-group margin-top-10">
        <label for="collectionName">Tytuł:</label>
        <input maxlength="195" type="text" class="form-control" id="collectionName" value="<?= $item->getData('nazwa') ?>" name="name"/>
    </div>

    <div class="form-group overflow-hidden">
        <button class="btn auto-width btn-primary btn-icon pull-right" type="submit">
            <i class="icon glyphicon glyphicon-ok"></i>
            Zapisz
        </button>
    </div>

</form>

<?= $this->element('Start.pageEnd'); ?>
