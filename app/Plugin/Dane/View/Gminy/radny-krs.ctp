<?
echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-dyzury', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-gminy-dyzury');
$this->Combinator->add_libs('js', 'graph-krs');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow', 'procent_glosow_w_okregu'),
        'bigTitle' => true,
    )
));
?>

<div class="dataBrowser margin-top--5">
    <div class="row">
        <div class="dataBrowserContent">
            <div class="col-xs-12 col-sm-4 col-md-1-5 dataAggsContainer">
                <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
                    <? if (isset($_submenu) && isset($_submenu['items'])) {
                        if (!isset($_submenu['base']))
                            $_submenu['base'] = $radny->getUrl();
                        echo $this->Element('Dane.DataBrowser/browser-menu', array(
                            'menu' => $_submenu,
                        ));
                    } ?>
                </div>
                </div>
            <div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">
                <div class="dataWrap">
                    <? if (isset($osoba) && $osoba) { ?>
                        <h1 class="smaller">Powiązania radnego w <a
                                href="/krs">Krajowym Rejestrze Sądowym</a>
                        </h1>

                        <? if (isset($osoba) && $osoba) { ?>
                            <div class="margin-top-20">
                                <?= $this->Element('Dane.objects/krs_osoby/organizacje', array(
                                    'organizacje' => $osoba->getLayer('organizacje'),
                                )); ?>
                            </div>
                        <? } ?>

                        <div class="powiazania block block-simple">
                            <header>
                                <div class="sm">Powiązania</div>
                            </header>
                            <section id="connectionGraph" class="loading col-xs-12 nopadding"
                                     data-id="<?php echo $osoba->getId() ?>" data-url="krs_osoby"></section>
                            <div class="detailInfoWrapper"></div>
                        </div>
                    <? } ?>
                </div>
                </div>
            </div>
        </div>
    </div>

<? echo $this->Element('dataobject/pageEnd'); ?>
