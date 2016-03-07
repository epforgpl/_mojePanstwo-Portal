<?php
$this->Combinator->add_libs('css', $this->Less->css('view', array('plugin' => 'Srodowisko')));
$this->Combinator->add_libs('js', 'Srodowisko.view.js');
?>

<div class="col-xs-12">

    <div class="appBanner">

        <h1 class="appTitle">Środowisko naturalne</h1>
        <p class="appSubtitle">Informacje o jakości powietrza w Polsce</p>

		<form action="/srodowisko" method="get">
	        <div class="appSearch form-group">
	            <div class="input-group">
	                <input class="form-control" placeholder="Szukaj stacji pomiarowych..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
	            </div>
	        </div>
		</form>
    </div>

    <script type="text/javascript">
	    var stations = <?= json_encode(array_column(array_column(array_column($dataBrowser['aggs']['stacje']['top']['hits']['hits'], '_source'), 'data'), 'srodowisko_stacje_pomiarowe')) ?>;
    </script>

</div>
