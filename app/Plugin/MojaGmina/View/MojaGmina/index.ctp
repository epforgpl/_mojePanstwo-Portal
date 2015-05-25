<?php
$this->Combinator->add_libs('css', $this->Less->css('moja_gmina', array('plugin' => 'MojaGmina')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/src/scriptaculous', array('block' => 'scriptBlock'));

echo $this->Html->script('/MojaGmina/js/moja_gmina', array('block' => 'scriptBlock'));
?>

<div id="mojaGmina">
    <div class="container">
        <div class="locationBrowser dataContent content col-xs-12">
            <div class="mapsContent col-md-12 col-lg-10 col-lg-offset-1">
                <div id="PLBrowser"></div>
            </div>
        </div>
    </div>
</div>