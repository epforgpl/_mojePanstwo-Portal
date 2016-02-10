<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));


echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow'),
        'bigTitle' => true,
    )
));


if (!isset($_submenu['base']))
    $_submenu['base'] = $radny->getUrl();

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

		<?
		if ($subsubid && $oswiadczenie && $oswiadczenie->getData('dokument_id')) {
		?>
		
		
            <h1 class="smaller">Oświadczenie majątkowe radnego za rok <?= $oswiadczenie->getData('rok') ?></h1>

            <div class="margin-top-15">
		    <?= $this->Document->place($oswiadczenie->getData('dokument_id'), array(
		    	'toolbar' => false,
		    )); ?>
			</div>

		
		
		<?
		} else {
		
		    if (!isset($_submenu['base']))
			    $_submenu['base'] = $radny->getUrl();
		
		    echo $this->Element('Dane.DataBrowser/browser', array(
			    'menu' => $_submenu,
				'class' => 'margin-top--5',
		    ));
		
		}
		?>

	</div>
</div>






<?
echo $this->Element('dataobject/pageEnd');
