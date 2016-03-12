<?
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-widgets-graph', array('plugin' => 'Widgets')));

if (isset($odpis) && $odpis) {
    $this->Html->meta(array(
        'http-equiv' => "refresh",
        'content' => "0;URL='$odpis'"
    ), null, array('inline' => false));
}

echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('css', $this->Less->css('view-krsosoby', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
$this->Combinator->add_libs('js', 'graph-krs');
?>
    <div class="powiazania">
        <div id="connectionGraph" data-id="<?php echo $object->getId() ?>" data-url="krs_osoby">
            <div class="spinner grey">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="detailInfoWrapper"></div>
    </div>
<?

