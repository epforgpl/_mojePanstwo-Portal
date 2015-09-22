<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-okregi', array('plugin' => 'Dane')));

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-okregi');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)); ?>

    <h1 class="subheader">Rada Miasta Kraków</h1>

    <div class="dataBrowser">
        <div class="row">
            <div class="dataBrowserContent">
                <div class="col-md-3 col-xs-12 dataAggsContainer">

                    <? if (isset($_submenu) && isset($_submenu['items'])) {

                        if (!isset($_submenu['base']))
                            $_submenu['base'] = $object->getUrl();

                        echo $this->Element('Dane.DataBrowser/browser-menu', array(
                            'menu' => $_submenu,
                        ));

                    } ?>

                </div>
                <div class="col-xs-12 col-md-9">

                    <? if (isset($okregi)) { ?>

                        <div id="kto_tu_rzadzi" class="object"></div>
                        <div data-name="okregi" data-content='<?= json_encode($okregi) ?>'></div>

                    <? } ?>

                </div>
            </div>
        </div>
    </div>


<?= $this->Element('dataobject/pageEnd');
