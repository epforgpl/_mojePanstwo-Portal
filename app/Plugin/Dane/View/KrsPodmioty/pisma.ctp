<?

echo $this->Element('dataobject/pageBegin');
$params = array(
	'paginatorPhrases' => array('pismo','pisma','pism'),
);
?>
<div class="overflow-auto margin-top-20">
	<h1 class="pull-left">Pisma</h1>
</div>
<?
echo $this->Element('Dane.DataBrowser/browser', $params);

echo $this->Element('dataobject/pageEnd');
