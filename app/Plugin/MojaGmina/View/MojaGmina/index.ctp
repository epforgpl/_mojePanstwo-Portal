<?php
$this->Combinator->add_libs('css', $this->Less->css('moja_gmina', array('plugin' => 'MojaGmina')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/src/scriptaculous', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('js', 'MojaGmina.moja_gmina.js');
?>
<div id="mojaGmina" class="fullPageHeight">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-10 col-lg-offset-1">
                <h1><?php echo __d('moja_gmina', "LC_MOJA_GMINA_HEADLINE") ?></h1>
            </div>
        </div>

        <div class="locationBrowser dataContent content col-xs-12">
            <div class="mapsContent col-md-12 col-lg-10 col-lg-offset-1">
                <div id="PLBrowser"></div>
            </div>
        </div>
    </div>
</div>