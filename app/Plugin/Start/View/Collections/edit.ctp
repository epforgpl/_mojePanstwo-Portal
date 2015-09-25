<?
	
$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('collections-form', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.collections-form');

echo $this->element('Start.pageBegin'); ?>

<header class="collection-header">
    <div class="overflow-auto">
        
        <div class="content pull-left">       
	        <a href="/moje-kolekcje/<?= $item->getData('id') ?>">                 												
	            <i class="object-icon icon-datasets-kolekcje"></i>						
	            <div class="object-icon-side">
	                <h1><?= $item->getData('nazwa') ?></h1>            
	            </div>
	        </a>
        </div>
    </div>
</header>

<form class="collectionsForm margin-top-30" action="<?= $item->getUrl(); ?>/edytuj" method="post">

    <div class="form-group margin-top-10">
        <label for="collectionName">Tytuł:</label>
        <input maxlength="195" type="text" class="form-control" id="collectionName" value="<?= $item->getData('nazwa') ?>" name="name"/>
    </div>

    <div class="form-group overflow-hidden margin-top-30 text-center">
        <button class="btn auto-width btn-primary btn-icon" type="submit">
            <i class="icon glyphicon glyphicon-ok"></i>
            Zapisz
        </button>
    </div>

</form>

<?= $this->element('Start.pageEnd'); ?>
