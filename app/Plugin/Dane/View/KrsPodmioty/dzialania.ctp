<?
echo $this->Element('dataobject/pageBegin');
/*
?>
<div class="overflow-auto margin-top-20">
	<h1 class="pull-left">Działania</h1>
	<div class="pull-right">
		<a href="<?= $object->getUrl() ?>/dodaj_dzialanie">
		    <div class="btn btn-primary btn-icon auto-width">
		        <i class="icon glyphicon glyphicon-plus"></i>
		        Dodaj nowe działanie
		    </div>
		</a>
	</div>
</div>
<? */
echo $this->Element('Dane.DataBrowser/browser', array(
	'paginatorPhrases' => array('działanie', 'działania', 'działań'),
));

echo $this->Element('dataobject/pageEnd');