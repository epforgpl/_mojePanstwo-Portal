<?

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('mapa', array('plugin' => 'Mapa')));

$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Mapa.mapa');

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));
?>
<div class="objectsPage">
    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
        <div class="searcher-app">
            <div class="container">
                <?= $this->element('Dane.DataBrowser/browser-searcher', array(
                    'dataBrowser' => array(
                        'searchTag' => array(
                            'href' => '/mapa',
                            'label' => 'Mapa',
                        ),
                    ),
                )); ?>
            </div>
        </div>

        <? if (@isset($app_menu)) { ?>
            <div class="apps-menu">
                <div class="container">
                    <ul>
                        <? foreach ($app_menu[0] as $a) { ?>
                            <li>
                                <a<? if (isset($a['active']) && $a['active']) { ?> class="active"<? } ?>
                                    href="<?= $a['href'] ?>"><?= $a['title'] ?></a>
                            </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        <? } ?>

        <div class="container">
            <div class="row dataBrowserContent">
                <div id="mapa"></div>
                <div id="localizeMe" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-screenshot"></span>
                </div>
            </div>
        </div>
    </div>
</div>
