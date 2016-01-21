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
?>

<div class="dataBrowser margin-top--5">
    <div class="row">
        <div class="dataBrowserContent">
            <div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
				<div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

                    <? if (isset($_submenu) && isset($_submenu['items'])) {

                    if (!isset($_submenu['base']))
                        $_submenu['base'] = $posiedzenie->getUrl();

                    echo $this->Element('Dane.DataBrowser/browser-menu', array(
                        'menu' => $_submenu,
                    ));

                } ?>

                </div>
            </div>
            <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">

                <div class="dataWrap">

                    <h1 class="smaller">Stenogram posiedzenia</h1>

                    <div class="margin-top-20">
		                <?= $this->Document->place($posiedzenie->getData('krakow_posiedzenia.stenogram_dokument_id'), array('toolbar' => false)); ?>
	            	</div>

	            </div>

            </div>
        </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
