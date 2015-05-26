<?php
$this->Combinator->add_libs('css', $this->Less->css('moja_gmina', array('plugin' => 'MojaGmina')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/src/scriptaculous', array('block' => 'scriptBlock'));

echo $this->Html->script('MojaGmina.moja_gmina', array('block' => 'scriptBlock'));
?>


<div class="col-xs-12 col-md-8">
    <div class="block col-xs-12">
        <header>Znajdź swoją gminę</header>
        <section id="mojaGmina">
            <div class="locationBrowser dataContent">
                <div class="mapsContent">
                    <div id="PLBrowser"></div>
                </div>
            </div>
        </section>
    </div>
</div>