<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="row margin-top-20">
	<div class="col-md-9 margin-top-3">
		
		<div class="appBanner margin-top--35 margin-bottom-50">
			<form method="get" action="">
		        <div class="appSearch form-group">
					<div class="input-group">
						<input name="q" class="form-control" placeholder="Szukaj..." type="text">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary input-md">
		                        <span class="glyphicon glyphicon-search"></span>
		                    </button>
						</span>
					</div>
		        </div>
			</form>
		</div>
		
		<?= $this->element('Dane.DataBrowser/browser-content-filters', array(
	        // 'paging' => $params,
	        // 'paginatorPhrases' => isset($paginatorPhrases) ? $paginatorPhrases : false,
	        // 'nopaging' => isset($nopaging) ? (boolean) $nopaging : false,
	        'searcher' => true,
	        'class' => 'margin-top-0',
	    )) ?>
		
	    <? /* if (isset($_submenu) && !empty($_submenu)) { ?>
	        <div class="menuTabsCont col-xs-8">
	            <?
	            if (!isset($_submenu['base']))
	                $_submenu['base'] = $object->getUrl();
	            echo $this->Element('Dane.dataobject/menuTabs', array(
	                'menu' => $_submenu,
	            ));
	            ?>
	        </div>
	    <? } */ ?>
	    <? if ($object->getId() == 903) { ?>
			
	        <div class="block block-simple block-size-sm col-xs-12 margin-top--10">
	            <header>Najnowsze projekty legislacyjne pod obrady rady</header>
	
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <? if ($dataBrowser['aggs']['rada_projekty']['top']['hits']['hits']) { ?>
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['rada_projekty']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'default');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                            <div class="buttons">
	                                <a href="<?= $object->getUrl() ?>/druki" class="btn btn-default btn-xs">Zobacz więcej</a>
	                            </div>
	                        <? } ?>
	
	                    </div>
	                </div>
	            </section>
	        </div>
	
	        <div class="block  block-simple block-size-sm col-xs-12">
	            <header>Najnowsze uchwały Rady</header>
	
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <? if ($dataBrowser['aggs']['krakow_rada_uchwaly']['top']['hits']['hits']) { ?>
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['krakow_rada_uchwaly']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'default');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                            <div class="buttons">
			                        <a href="<?= $object->getUrl() ?>/rada_uchwaly" class="btn btn-default btn-xs">Zobacz
			                            więcej</a>
			                    </div>
	                        <? } ?>
	
	                    </div>
	                </div>
	            </section>
	        </div>
	
	        <div class="block  block-simple block-size-sm col-xs-12">
	            <header>Najnowsze interpelacje radnych</header>
	
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <? if ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits']) { ?>
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['interpelacje']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'default');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                            <div class="buttons text-center">
			                        <a href="<?= $object->getUrl() ?>/interpelacje" class="btn btn-default btn-xs">Zobacz
			                            więcej</a>
			                    </div>
	                        <? } ?>
	
	                    </div>
	                </div>
	            </section>
	        </div>
	
	
	    <? } else { ?>
	
			<? if (@$dataBrowser['aggs']['prawo']['top']['hits']['hits']) { ?>
	        <div class="block  block-simple  block-size-sm col-xs-12">
	            <header>Najnowsze prawo lokalne</header>
	
	            <section class="aggs-init">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['prawo']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'default');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                            <div class="buttons btn-sm text-center">
			                        <a href="<?= $object->getUrl() ?>/prawo" class="btn btn-default btn-xs">Zobacz więcej</a>
			                    </div>
	
	                    </div>
	                </div>
	            </section>
	        </div>
		    <? } ?>
	
	    <? } ?>
	
	    <? if( @$dataBrowser['aggs']['dzialania']['top']['hits']['hits'] ) {?>
	        <div class="block block-simple col-xs-12 dzialania">
	            <header>Działania</header>
	            <section class="content">
	                <? foreach ($dataBrowser['aggs']['dzialania']['top']['hits']['hits'] as $dzialanie) { ?>
	                    <div class="col-sm-6">
	                        <h4>
	                            <a href="/dane/gminy/<?= $object->getId(); ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>">
	                                <?= $this->Text->truncate($dzialanie['fields']['source'][0]['data']['dzialania.tytul'], 100); ?>
	                            </a>
	                        </h4>
	
	                        <? if ($dzialanie['fields']['source'][0]['data']['dzialania.photo'] == '1') { ?>
	                            <div class="photo">
	                                <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>"><img
	                                        alt="<?= $dzialanie['fields']['source'][0]['data']['dzialania.tytul']; ?>"
	                                        src="http://sds.tiktalik.com/portal/2/pages/dzialania/<?= $dzialanie['fields']['id'][0]; ?>.jpg"/></a>
	                            </div>
	                        <? } ?>
	
	                        <div class="desc">
	                            <?= $this->Text->truncate($dzialanie['fields']['source'][0]['data']['dzialania.podsumowanie'], 200) ?>
	                        </div>
	                    </div>
	                <? } ?>
	            </section>
	        </div>
	    <? } ?>
	
	    <? if (@$dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets']) { ?>
	        <div class="block  block-simple block-size-sm col-xs-12">
	            <header>Rozstrzygnięcia zamówień publicznych:</header>
	            <section>
	                <?= $this->element('Dane.zamowienia_publiczne', array(
	                    'histogram' => $dataBrowser['aggs']['zamowienia_publiczne_dokumenty']['dni']['buckets'],
	                    'request' => array(
	                        'gmina_id' => $object->getId(),
	                    ),
	                    'more' => $object->getUrl() . '/zamowienia',
	                    'aggs' => array(
	                        'stats' => array(),
	                        'dokumenty' => array(),
	                    ),
	                )); ?>
	            </section>
	        </div>
	    <? } ?>
	
	    <? $udzialy = $object->getLayer('udzialy');
	    if(is_array($udzialy) && count($udzialy) > 0) { ?>
	        <div class="block  block-simple  col-xs-12">
	            <header>Udziały miasta w spółkach</header>
	            <section class="aggs-init margin-sides-20 margin-top-10">
	                <? foreach($udzialy as $udzial) { ?>
	                    <div class="row">
	                        <div class="col-xs-6">
	                            <a href="/dane/krs_podmioty/<?= $udzial['pozycja_id'] ?>,<?= $udzial['slug'] ?>" title="<?= $udzial['nazwa'] ?>">
	                                <?= $udzial['nazwa'] ?>
	                            </a>
	                        </div>
	                        <div class="col-xs-6">
	                            <p class="normalizeText text-muted">
	                                <?= $udzial['udzialy_str'] ?>
	                            </p>
	                        </div>
	                    </div>
	                <? } ?>
	            </section>
	        </div>
	    <? } ?>
			
	    <div class="block block-simple col-xs-12">
	        <header>Typy zarejestrowanych organizacji<? if ($object->getId() == 903) { ?> w Krakowie<? } ?></header>
	
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-PieChart" data-chart-options="<?= htmlentities(json_encode($options)) ?>"
	                     data-choose-request="<?= $object->getUrl() ?>/organizacje?conditions[krs_podmioty.forma_prawna_id]="
	                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['typ_id'])) ?>">
	                    <div class="chart">
	                    </div>
	                </div>
	            </div>
	        </section>
	    </div>
	
	    <div class="block block-simple col-xs-12">
	        <header>Kapitalizacja spółek handlowych</header>
	
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-ColumnsVertical"
	                     data-choose-request="<?= $object->getUrl() ?>/organizacje?conditions[krs_podmioty.wartosc_kapital_zakladowy]="
	                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['kapitalizacja'])) ?>">
	                    <div class="chart"></div>
	                </div>
	            </div>
	        </section>
	    </div>
	
	    <div class="block block-simple col-xs-12">
	        <header>Rejestracje nowych organizacji w czasie</header>
	
	        <section class="aggs-init">
	            <div class="dataAggs">
	                <div class="agg agg-DateHistogram"
	                     data-chart="<?= htmlentities(json_encode($dataBrowser['aggs']['krs_podmioty']['date'])) ?>">
	
	                    <div class="chart"></div>
	                </div>
	            </div>
	        </section>
	    </div>
	
	</div>
	<div class="col-md-3 sidebar">
	
	<?
	    $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
	    $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
	    $this->Combinator->add_libs('js', 'Pisma.pisma-button');
	    
	    echo $this->element('tools/pismo', array(
		    'label' => '<strong>Wyślij pismo</strong> do urzędu tej gminy',
		    'class' => 'margin-top-0',
	    ));
	
	if( $object->getId()!=903 ) {
		    $page = $object->getLayer('page');
		    if (!$page['moderated'])
		        echo $this->element('tools/admin', array(
			        'label' => '<strong>Zarządzaj profilem</strong> tej gminy',
		        ));
	    }
	    ?>
	
	
	    <? if ($object->getId() == 903) { ?>
	
	        <div class="block block-simple nobg col-md-12 border-bottom">
	
	            <header>Najnowsze posiedzenie Rady Miasta</header>
	
	            <section class="aggs-init nopadding">
	
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <? if ($dataBrowser['aggs']['rada_posiedzenia']['top']['hits']['hits']) { ?>
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['rada_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'krakow_posiedzenia');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                        <? } ?>
	
	                    </div>
	                </div>
	            </section>
	            
	        </div>
	        <div class="block block-simple nobg col-md-12 border-bottom">
	
	            <header>Najnowsze nagrania posiedzeń komisji</header>
	
	            <section class="aggs-init nopadding">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <? if ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits']) { ?>
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['rada_komisje_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'krakow_rada_posiedzenia');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                        <? } ?>
	
	                    </div>
	                </div>
	            </section>
	            
	        </div>
	        <div class="block block-simple nobg col-md-12">
	
	            <header>Najnowsze nagrania posiedzeń rad dzielnic</header>
	
	            <section class="aggs-init nopadding">
	                <div class="dataAggs">
	                    <div class="agg agg-Dataobjects">
	                        <? if ($dataBrowser['aggs']['dzielnice_posiedzenia']['top']['hits']['hits']) { ?>
	                            <ul class="dataobjects margin-sides-10">
	                                <? foreach ($dataBrowser['aggs']['dzielnice_posiedzenia']['top']['hits']['hits'] as $doc) { ?>
	                                    <li>
	                                        <?
	                                        echo $this->Dataobject->render($doc, 'dzielnice_posiedzenia');
	                                        ?>
	                                    </li>
	                                <? } ?>
	                            </ul>
	                        <? } ?>
	
	                    </div>
	                </div>
	            </section>
	            
	        </div>
	
	    <? } ?>
	
	</div>
</div>
