<?
echo $this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
    ),
    'back' => array(
        'href' => '/dane/gminy/903,krakow/posiedzenia',
        'title' => 'Wszystkie posiedzenia rady miasta',
    ),
));
?>

	<div class="row">
		<div class="col-md-9">
			<h1 class="light text-center">
				<a href="<?= $posiedzenie->getUrl() ?>" class="btn-back glyphicon glyphicon-circle-arrow-left"></a> 
				Podsumowanie obrad
			</h1>
		</div>
	</div>

<?
	
	echo $this->Element('docsBrowser/doc', array(
	    'document' => $document,
	    'documentPackage' => 1,
	));

	echo $this->Element('dataobject/pageEnd');
	