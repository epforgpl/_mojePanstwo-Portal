<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-dzielnice', array('plugin' => 'Dane')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.exp', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-dzielnice');

echo $this->Element('dataobject/pageBegin'); ?>

    <div class="holder">
        <ul class="dzielniceList">
            <? foreach ($object->getLayer('dzielnice') as $d) {
                echo '<li><a href="/dane/gminy/903,krakow/dzielnice/' . $d['id'] . '" title="' . $d["nazwa"] . '" data-dzielnica="' . $d["id"] . '" onclick="return false;">' . $d["numer"] . ' - ' . $d["nazwa"] . '</a></li>';
            } ?>
        </ul>
    </div>
    <div id="dzielnice_map"></div>

<?= $this->Element('dataobject/pageEnd');
