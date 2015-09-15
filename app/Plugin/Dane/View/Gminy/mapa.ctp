<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-mapa', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'latlon-geohash');
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-mapa');

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=pl-PL', array('block' => 'scriptBlock'));
?>
<?= $this->Element('dataobject/pageBegin'); ?>

<div id="map"></div>


<?= $this->Element('dataobject/pageEnd'); ?>


