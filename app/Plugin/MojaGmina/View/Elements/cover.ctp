<?php
$this->Combinator->add_libs('css', $this->Less->css('moja_gmina', array('plugin' => 'MojaGmina')));

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/src/scriptaculous', array('block' => 'scriptBlock'));

echo $this->Html->script('MojaGmina.moja_gmina', array('block' => 'scriptBlock'));
?>

<div class="col-xs-12 col-md-9">
    <div class="block col-xs-12">
        <header>Znajdź swoją gminę na mapie:
            <button class="btn btn-warning pull-right btn-icon" id="localizeMe"><span class="icon"
                                                                                      data-icon-applications="&#xe609;"></span>Zlokalizuj
                mnie
            </button>
        </header>
        <section id="mojaGmina">
            <div class="locationBrowser dataContent">
                <div class="mapsContent">
                    <div id="PLBrowser"></div>
                </div>
            </div>
        </section>
    </div>
</div>
