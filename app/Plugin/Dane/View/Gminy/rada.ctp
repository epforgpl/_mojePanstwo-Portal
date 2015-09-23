<?php
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy');
?>

<?php if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

    switch (Configure::read('Config.language')) {
        case 'pol':
            $lang = "pl-PL";
            break;
        case 'eng':
            $lang = "en-EN";
            break;
    };
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?language=' . $lang, array('block' => 'scriptBlock'));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
}

echo $this->Element('dataobject/pageBegin');
?>
    <div class="suggesterBlock searchForm col-md-12 nopadding">
        <? if (!isset($title) && isset($DataBrowserTitle)) {
            $title = $DataBrowserTitle;
        }
        if (isset($title)) {
            echo '<h2>' . $title . '</h2>';
        }
        ?>
    </div>

    <h1 class="subheader">Rada Miasta Kraków</h1>
<?
if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();

echo $this->Element('Dane.DataBrowser/browser', array(
    'menu' => $_submenu,
));
echo $this->Element('dataobject/pageEnd');
