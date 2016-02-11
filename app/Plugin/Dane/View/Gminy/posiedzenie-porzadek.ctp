<?
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
        'thumbWidth' => 2,
    ),
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $posiedzenie->getUrl();
?>



<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
                'pills' => isset($pills) ? $pills : null
            ));
        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">

		<h1 class="smaller">Porządek obrad</h1>

        <div class="margin-top-20">
            <?= $this->Document->place($posiedzenie->getData('krakow_posiedzenia.porzadek_dokument_id'), array('toolbar' => false)); ?>
    	</div>

	</div>
</div>



<?= $this->Element('dataobject/pageEnd'); ?>
