<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-finanse', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

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
?>
    <div class="dataBrowser" style="margin-top: -5px;">
        <div class="row">
            <div class="dataBrowserContent">
                <div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
                    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

                        <? if (isset($_submenu) && isset($_submenu['items'])) {

                            if (!isset($_submenu['base']))
                                $_submenu['base'] = $object->getUrl();

                            echo $this->Element('Dane.DataBrowser/browser-menu', array(
                                'menu' => $_submenu,
                            ));

                        } ?>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">

                    <div class="margin-top-20 text-center">
                        <h1>Wieloletni Plan Finansowy dla Krakowa</h1>
                    </div>

                    <div id="wpf-sections" data-json='<?= json_encode($wpfData); ?>'></div>

                </div>
            </div>
        </div>
    </div>

<? echo $this->Element('dataobject/pageEnd');

