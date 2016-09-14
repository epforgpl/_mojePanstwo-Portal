<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-finanse', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-wpf', array('plugin' => 'Dane')));


switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=places&language=' . $lang, array('block' => 'scriptBlock'));

$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf_finanse');
$this->Combinator->add_libs('js', 'Dane.filters');

$wpfData = $object->getLayer('wpf');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();
?>
<div class="row">
	<div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
                'pills' => isset($pills) ? $pills : null
            ));
            
	        echo $this->Element('Dane.krakow/wpf/mapy');

        ?>
		</div>
	</div>
	<div class="col-md-10 nocontainer">

		<div class="margin-top-20 text-center">
            <h1>Wieloletni Plan Finansowy dla Krakowa</h1>
        </div>

        <div id="wpf-sections" data-json='<?= json_encode($wpfData); ?>'></div>

	</div>
</div>

<? echo $this->Element('dataobject/pageEnd');

