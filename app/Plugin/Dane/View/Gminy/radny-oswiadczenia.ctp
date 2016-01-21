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

if ($subsubid && $oswiadczenie && $oswiadczenie->getData('dokument_id')) {
?>

    <div class="dataBrowser margin-top--5">
    <div class="row">
        <div class="dataBrowserContent">
            <div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
				<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

                    <? if (isset($_submenu) && isset($_submenu['items'])) {

                        $_submenu['selected'] = 'oswiadczenia';
                    if (!isset($_submenu['base']))
                        $_submenu['base'] = $radny->getUrl();

                    echo $this->Element('Dane.DataBrowser/browser-menu', array(
                        'menu' => $_submenu,
                    ));

                } ?>

                </div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">

                <div class="dataWrap">

                    <h1 class="smaller">Oświadczenie majątkowe radnego za rok <?= $oswiadczenie->getData('rok') ?></h1>

                    <div class="margin-top-15">
				    <?= $this->Document->place($oswiadczenie->getData('dokument_id'), array(
				    	'toolbar' => false,
				    )); ?>
					</div>

                </div>

            </div>
        </div>
    </div>
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

echo $this->Element('dataobject/pageEnd');
