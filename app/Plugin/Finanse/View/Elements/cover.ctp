<? $this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse'))); ?>

<div class="col-xs-12 col-md-2 dataAggsContainer">
    <? /* echo $this->Element('Dane.DataBrowser/aggs', array(
        	'data' => $dataBrowser,
    )); */ ?>
    
    <ul class="dataAggs" style="opacity: 1;">
        <li class="agg">
            <div class="agg agg-List agg-Datasets">
	            <ul class="nav nav-pills nav-stacked">           	            	
	                <li class="active">
	                	<a href="/finanse">Start</a>
	                </li>
	                <li>
	                	<a href="/finanse/centralne">Finanse centralne</a>
	                </li>
	                <li>
	                	<a href="/finanse/gminy">Finanse gmin</a>
	                </li>
	                <li>
	                	<a href="/finanse/budzety">Ustawy budżetowe</a>
	                </li>
                </ul>
		    </div>
        </li>
    </ul>
    
</div>

<div id="bdl_div" class="col-xs-12 col-md-10">

	<div class="dataWrap">


	</div>

</div>