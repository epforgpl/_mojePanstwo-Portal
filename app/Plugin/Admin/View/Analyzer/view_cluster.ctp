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
<div class="container">
    <?
foreach ($data as $key => $val) {
    if (!isset($temp[$key])) {
        if ($key !== '') {
            echo "<div class='row'><div class='col-sm-12'><hr></div><div class='col-sm-6'><div id='".$key."_la'></div></div>";
            echo "<div class='col-sm-6'><div id='{$key}_fs'></div></div></div>";
        }
    }
    $temp[$key] = $key;
}
?>
</div>
