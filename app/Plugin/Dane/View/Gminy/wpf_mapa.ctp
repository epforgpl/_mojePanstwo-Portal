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
echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=places&language=' . $lang . '&key=AIzaSyCIb1zfiLb3_Q_hW8UP118RCz-Ghdp4mZw', array('block' => 'scriptBlock'));

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
<div class="legends container hide">
    <ul class="nopadding col-xs-12 col-sm-6 col-sm-offset-3">
        <li>1 - Finansowanie UE, EFTA, inne środki zagraniczne <span>Wydatki na programy, projekty lub zadania związane z programami realizowanymi z udziałem środków,
o których mowa w art. 5 ust. 1 pkt. 2 i 3 z dnia 27 sierpnia 2009 r. o finansach publicznych (Dz. U Nr 157, poz. 1240, z późn. zm.)</span></li>
        <li>2 - Partnerstwo publiczno-prywatne <span>Wydatki na programy, projekty lub zadania związane z umowami partnerstwa publiczno-prywatnego</span></li>
        <li>3 - Wydatki na programy, projekty lub zadania pozostałe <span>Wydatki na programy, projekty lub zadania pozostałe (inne niż wymienione w pkt. 1.1 i 1.2)</span></li>
    </ul>
</div>
<? echo $this->Element('dataobject/pageEnd');

