<?
$this->Combinator->add_libs('css', $this->Less->css('mapa', array('plugin' => 'Mapa')));
$this->Combinator->add_libs('js', 'Mapa.mapa');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
?>

<div id="mapa"></div>
