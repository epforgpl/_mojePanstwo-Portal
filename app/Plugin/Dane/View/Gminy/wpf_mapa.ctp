<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-wpf_mapa', array('plugin' => 'Dane')));
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

$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf_mapa');

$wpfData = $object->getLayer('wpf_mapa');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>
</div>
</div>

<div id="wpfMapa" data-pk="<?= $domainMode == 'PK' ?>" data-json='<?= json_encode($object->getLayer('wpf_mapa')) ?>'></div>

<div>
<div>
<? echo $this->Element('dataobject/pageEnd');

