<?php
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock-more');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js','Admin.timeago');
$this->Combinator->add_libs('js','Admin.refresherCluster');
$this->Combinator->add_libs('css','Admin.Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);
$temp = array();
?>
<?= $this->element('Admin.header'); ?>

<h2>Cluster</h2>

    <?
foreach ($data as $key => $val) {
    if (!isset($temp[$key])) {
        if ($key !== '') { ?>

            <div class="row margin-top-10">
                <div class='col-sm-6'><div id='<?= $key ?>_la'></div></div>
                <div class='col-sm-6'><div id='<?= $key ?>_fs'></div></div>
            </div>

        <? }
    }
    $temp[$key] = $key;
}
?>
<?= $this->element('Admin.footer'); ?>
