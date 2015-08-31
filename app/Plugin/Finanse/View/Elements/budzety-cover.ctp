<?
$this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Finanse.budzety');
?>

<div class="col-xs-12 col-md-2 dataAggsContainer">

    <ul class="dataAggs">
        <li class="agg">
            <div class="agg agg-List agg-Datasets">
                <ul class="nav nav-pills nav-stacked">
	                <li>
	                	<a href="/finanse">Start</a>
	                </li>
	                <li>
	                	<a href="/finanse/centralne">Finanse centralne</a>
	                </li>
	                <li>
	                	<a href="/finanse/gminy">Finanse gmin</a>
	                </li>
	                <li class="active">
	                	<a href="/finanse/budzety">Ustawy budżetowe</a>
	                </li>
                </ul>
		    </div>
        </li>
    </ul>

</div>

<div id="bdl_div" class="col-xs-12 col-md-10">
    <div class="chart"
         data-json='<?php echo json_encode($dataBrowser['aggs']['budzety']['top']['hits']['hits']); ?>'></div>
</div>
