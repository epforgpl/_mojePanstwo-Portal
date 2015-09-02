<?
$this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Finanse.budzety');
?>
    <div class="col-xs-12 col-md-2 dataAggsContainer">
        <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
    </div>

    <div id="bdl_div" class="col-xs-12 col-md-10">
        <div class="chart"
             data-json='<?php echo json_encode($dataBrowser['aggs']['budzety']['top']['hits']['hits']); ?>'>
        </div>
    </div>
<? // debug($dataBrowser['aggs']['budzety']['top']['hits']['hits']); ?>
