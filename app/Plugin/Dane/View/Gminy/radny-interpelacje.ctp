<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow', 'procent_glosow_w_okregu'),
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

echo $this->Element('Dane.DataBrowser/browser', array(
	'menu' => $_submenu,
	'class' => 'margin-top-5',
));
?>

	</div>
</div>


<?
echo $this->Element('dataobject/pageEnd');
