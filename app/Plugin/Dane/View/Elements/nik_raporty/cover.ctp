<?
	$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
	$this->Combinator->add_libs('css', $this->Less->css('nik_raporty_dokumenty', array('plugin' => 'Dane')));

	$options = array(
	    'mode' => 'init',
	);
	
?>
<div class="row margin-top-15">
	<? if( @$dataBrowser['aggs']['dokumenty']['top']['hits']['hits'] || @$dataBrowser['aggs']['jednostki']['top']['hits']['hits'] ) {?>
        <div class="col-md-6 nik_raporty_dokumenty-div">

            <? if( @$dataBrowser['aggs']['dokumenty']['top']['hits']['hits'] ) {?>
	        <div class="block block-simple block-size-sm col-xs-12">
	            <header>Wyniki kontroli:</header>
	
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	
	                        <ul class="dataobjects">
	                            <? foreach ($dataBrowser['aggs']['dokumenty']['top']['hits']['hits'] as $doc) { ?>
	                                <li>
	                                    <?
	                                    echo $this->Dataobject->render($doc, 'default', array(
		                                    'routes' => array(
			                                    'titleAddon' => false,
		                                    ),
		                                    'mode' => 'raport',
	                                    ));
	                                    ?>
	                                </li>
	                            <? } ?>
	                        </ul>
	
	                    </div>
	                </div>
	            </section>
	        </div>
	        <? } ?>
	
	        <? if( @$dataBrowser['aggs']['jednostki']['top']['hits']['hits'] ) {?>
	        <div class="block block-simple block-size-sm col-xs-12">
	            <header>Wystąpienia jednostek NIK:</header>
	
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	
	                        <ul class="dataobjects">
	                            <? foreach ($dataBrowser['aggs']['jednostki']['top']['hits']['hits'] as $doc) { ?>
	                                <li>
	                                    <?
	                                    echo $this->Dataobject->render($doc, 'default', array(
		                                    'routes' => array(
			                                    'titleAddon' => false,
		                                    ),
		                                    'mode' => 'raport',
	                                    ));
	                                    ?>
	                                </li>
	                            <? } ?>
	                        </ul>
	
	                    </div>
	                </div>
	            </section>
	        </div>
	        <? } ?>
	        
	        <p class="text-center"><a target="_blank" href="https://www.nik.gov.pl/kontrole/wyniki-kontroli-nik/kontrole,<?= $raport->getData('nik_id') ?>.html">Źródło</a></p>

        </div>
	<? } ?>


<? if( @$dataBrowser['aggs']['podmioty']['podmioty']['buckets'] ) { ?>
    <div class="col-md-6 nik_raporty_dokumenty-div_podmioty">
        <div class="block block-simple block-size-sm col-xs-12">
            <header>Podmioty kontrolowane:</header>

            <section class="aggs-init">
                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">

                        <ul class="dataobjects">
                            <?
                            foreach ($dataBrowser['aggs']['podmioty']['podmioty']['buckets'] as $bucket) {
		                            $podmiot = array(
			                            'id' => $bucket['key'],
			                            'nazwa' => $bucket['nazwa']['buckets'][0]['key'],
			                            'dokumenty' => $bucket['top']['hits']['hits'],
		                            );
                            ?>
                                <li>
                                    <div class="objectRender objclass instytucje">
									    <div class="row">
                                            <div class="data col-xs-12">
                                                <div>
									                <div class="content">
                                                        <span class="object-icon icon-datasets-instytucje"></span>
									                    <div class="object-icon-side">
										                    <p class="title">
										                        <?= $podmiot['nazwa'] ?>
										                    </p>
										                    <ul>
                                                                <?
											                foreach( $podmiot['dokumenty'] as $doc ) {
												                $data = $doc['_source']['data'];
											                ?>
											                	<li><a href="/dane/instytucje/3217,najwyzsza-izba-kontroli/raporty/1305/dokumenty/<?= $data['nik_raporty_dokumenty']['id'] ?>"><?= $data['nik_raporty_dokumenty']['nazwa'] ?></a></li>
											                <? } ?>
                                                            </ul>
                                                        </div>
									                </div>
									            </div>
									        </div>
									    </div>
									</div>
                                </li>
                            <? } ?>
                        </ul>

                    </div>
                </div>
            </section>
        </div>
	</div>
    <? } ?>
</div>

