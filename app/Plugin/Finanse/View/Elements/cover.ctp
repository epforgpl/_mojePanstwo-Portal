<?
$this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/themes/dark-unica');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Finanse.budzety');
// $this->Combinator->add_libs('js', 'Finanse.budzety-tiles');
?>
<div class="col-xs-12">
    <div class="appBanner">
        <h1 class="appTitle">Finanse publiczne</h1>

        <p class="appSubtitle">Poznaj stan finansów publicznych Polski.</p>
    </div>
</div>
</div>
</div>
<div class="col-xs-12 finanseBlock">

    <div class="chart"
         data-json='<?php echo json_encode($dataBrowser['aggs']['budzety']['top']['hits']['hits']); ?>'></div>

    <div class="mid-chart"></div>
    <div class="chart2"></div>

</div>

<div class="container">
<div class="row dataBrowserContent">

	<div class="appBanner">
        <h2 class="appTitle">Rok 2015</h2>

    </div>
</div>
