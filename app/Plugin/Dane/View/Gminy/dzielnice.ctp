<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-dzielnice', array('plugin' => 'Dane')));

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&key=' . GOOGLE_MAPS_KEY . '&language=' . $lang, array('block' => 'scriptBlock'));

$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-dzielnice');

echo $this->Element('dataobject/pageBegin'); ?>

    <div class="holder">
        <ul class="dzielniceList">
            <? foreach ($object->getLayer('dzielnice') as $d) {
                echo '<li><a href="/dane/gminy/903,krakow/dzielnice/' . $d['id'] . '" title="' . $d["nazwa"] . '" data-dzielnica="' . $d["numer"] . '">' . $d["numer"] . ' - ' . $d["nazwa"] . '</a></li>';
            } ?>
        </ul>
    </div>
    <div id="dzielnice_map"></div>

<?= $this->Element('dataobject/pageEnd');
