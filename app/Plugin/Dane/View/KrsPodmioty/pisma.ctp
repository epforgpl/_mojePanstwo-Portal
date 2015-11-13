<?

echo $this->Element('dataobject/pageBegin');
$params = array(
	'paginatorPhrases' => array('pismo','pisma','pism'),
);
?>
<div class="overflow-auto margin-top-20">
	<h1 class="pull-left">Pisma napisane przez <?= $object->getTitle() ?></h1>
	<? /*
	<div class="pull-right">
		<a href="<?= $object->getUrl() ?>/dodaj_dzialanie">
		    <div class="btn btn-primary btn-icon auto-width">
		        <i class="icon glyphicon glyphicon-plus"></i>
		        Dodaj nowe pismo
		    </div>
		</a>
	</div>
	*/ ?>
</div>
<?
echo $this->Element('Dane.DataBrowser/browser', $params);

echo $this->Element('dataobject/pageEnd');