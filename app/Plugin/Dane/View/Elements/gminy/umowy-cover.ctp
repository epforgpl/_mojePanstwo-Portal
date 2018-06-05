<?
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>

<div class="row">
	<div class="col-xs-12 norightpadding">	
		<h1 class="smaller margin-top-15">Umowy zawierane przez Urząd Miasta Kraków</h1>
	    <div class="row">
	        <div class="col-sm-12">
				
				<div class="appBanner margin-top-0 margin-bottom-30">
					<div class="appSearch form-group margin-top-10">
				        <form action="" method="get">
				            <div class="input-group">
				                <input name="q" class="form-control" placeholder="Szukaj w umowach..." value="" type="text">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary input-md">
				                        <span class="glyphicon glyphicon-search"></span>
				                    </button>
								</span>
				            </div>
				        </form>
			        </div>
				</div>
				
                <? if (@$dataBrowser['aggs']['umowy']['dni']['buckets']) { ?>
                    <div class="block block-simple nobg">
                        <header>Wartość brutto podpisywanych umów:</header>
                        <section>
                            <?= $this->element('Dane.highstock_browser', array(
                                'histogram' => $dataBrowser['aggs']['umowy']['dni']['buckets'],
                                'preset' => 'krakow_umowy',
                                'options' => array(
                                    'more' => array(
                                        'url' => '/dane/gminy/903,krakow/umowy',
                                        'convert' => true,
                                    ),
                                    'aggs' => array(
                                        'umowy' => array(
                                            'size' => 5,
                                        ),
                                        'wykonawcy' => array(),
                                        'rodzaje_budzet' => array(),
                                        'rodzaje_wolumen' => array(),
                                        'jednostki' => array(),
                                        'tryby' => array(),
                                    ),
                                    'mode' => 'medium',
                                ),
                            )); ?>
                        </section>
                    </div>
                <? } ?>
	
	        </div>
	    </div>	    
	</div>
</div>