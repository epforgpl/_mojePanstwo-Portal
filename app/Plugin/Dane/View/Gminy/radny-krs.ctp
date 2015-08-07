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
    'menu' => isset($_submenu) ? $_submenu : false,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow', 'procent_glosow_w_okregu'),
        'bigTitle' => true,
    )
));

?>


    <div class="col-md-10 col-md-offset-1">
        <div id="komisje" class="object">


            <? if (isset($osoba) && $osoba) { ?>

                <h1 class="light"><a href="<?= $radny->getUrl() ?>"
                                     class="btn-back glyphicon glyphicon-circle-arrow-left"></a> Powiązania radnego w <a
                        href="/krs">Krajowym Rejestrze Sądowym</a></h1>

                <? if (isset($osoba) && $osoba) {
                    echo $this->Element('Dane.objects/krs_osoby/organizacje', array(
                        'organizacje' => $osoba->getLayer('organizacje'),
                    ));
                } ?>

                <div class="powiazania block">
                    <div class="block-header"><h2 class="label">Powiązania</h2></div>
                    <div id="connectionGraph" class="loading" data-id="<?php echo $osoba->getId() ?>"
                         data-url="krs_osoby"></div>
                </div>

            <? } ?>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
?>