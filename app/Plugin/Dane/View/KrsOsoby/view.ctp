<?
echo $this->Element('dataobject/pageBegin');

echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('css', $this->Less->css('view-krsosoby', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krsosoby');
$this->Combinator->add_libs('js', 'graph-krs');
?>

    <div class="col-xs-12 col-md-9 objectMain krsOsoby">
        <div class="object">
            <div class="block-group col-xs-12 col-xs-12">
                <? if ($organizacje = $object->getLayer('organizacje')) {
    echo $this->Element('Dane.objects/krs_osoby/organizacje', array(
        'organizacje' => $organizacje,
    ));
} ?>
            </div>
        </div>
    </div>



</div></div>

    <div class="powiazania block block-simple col-md-12 margin-bottom-30">
        <section id="connectionGraph" data-id="<?php echo $object->getId() ?>" data-url="krs_osoby">
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </section>
        <div class="detailInfoWrapper"></div>
    </div>

<div><div>

<?= $this->Element('dataobject/pageEnd'); ?>
