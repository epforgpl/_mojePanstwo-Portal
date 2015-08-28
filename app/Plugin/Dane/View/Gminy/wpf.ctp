<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-finanse', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.view-gminy-wpf');
$this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

$wpfData = $object->getLayer('wpf');

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

?>

    <div class="container">
        <div class="col-md-10 col-md-offset-1 text-center">
            <div class="row banner">
                <p>Zestawienie wydatków gminy <?= $object->data('nazwa'); ?> w I, II i III kwartale 2014 r.</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="wpf-sections" data-json='<?= json_encode($wpfData); ?>'></div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
