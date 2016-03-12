<?
	
	$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
	//$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
	//$this->Combinator->add_libs('js', '../plugins/highstock/locals');
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	
?>

<div class="row margin-top-20">
	<div class="col-md-9 margin-top-3">
		
		<div class="appBanner margin-top--35 margin-bottom-50">
			<form method="get" action="">
		        <div class="appSearch form-group">
					<div class="input-group">
						<input name="q" class="form-control" placeholder="Szukaj w ogłoszeniach..." type="text">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary input-md">
		                        <span class="glyphicon glyphicon-search"></span>
		                    </button>
						</span>
					</div>
		        </div>
			</form>
		</div>
				
		<? if( $dzialy = @$dataBrowser['aggs']['dzialy']['buckets'] ) foreach( $dzialy as $dzial ) { ?>
		<div class="block clobk-simple">
			<header><?= $dzial['nazwa']['buckets'][0]['key'] ?></header>
			
			<? if( $pozycje = $dzial['top']['hits']['hits'] ) {?>
			<section class="content">
			
                <div class="agg agg-Dataobjects">
                    <ul class="dataobjects" style="margin: 0 20px;">
                        <? foreach ($pozycje as $p) { ?>
                            <li class="margin-top-15">
                                <?
                                echo $this->Dataobject->render($p, 'default');
                                ?>
                            </li>
                        <? } ?>
                    </ul>
                    <div class="buttons text-center margin-top-10">
                        <a href="/prawo/aktualnosci" class="btn btn-primary btn-xs">Więcej aktualności &raquo;</a>
                    </div>
                </div>

            </section>
			<? } ?>
			
		</div>
		<? } ?>
		
	</div>
</div>