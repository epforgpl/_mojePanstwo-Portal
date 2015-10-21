<?

$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-dzielnica', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="col-sm-2 col-xs-12 dataAggsContainer">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $dzielnica->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu
        ));

    } ?>

</div>
<div class="col-sm-10">
	<div class="row">
	    <div class="col-sm-9">
	        <div class="databrowser-panels">

	            <? if ($object->getId() == 903) { ?>

					<div class="databrowser-panel margin-top-10">
						<? if(!empty($cadences)) { ?>
							<form action="" method="get">
								<select
									class="form-control"
									name="<?= $cadences['param'] ?>"
									onchange="this.form.submit()">
									<? foreach($cadences['items'] as $key => $item) { ?>
										<? $active = $cadences['selected'] == $key; ?>
										<option value="<?= $key ?>"<?= $active ? "selected" : '' ?>>
											<?= $item['label'] ?>
										</option>
									<? } ?>
								</select>
							</form>
						<? } ?>
					</div>

	                <div class="databrowser-panel margin-top-10">
	                    <h2>Najnowsze posiedzenia rady dzielnicy:</h2>

	                    <div class="aggs-init">

	                        <div class="dataAggs">
	                            <div class="agg agg-Dataobjects">
	                                <? if ($dataBrowser['aggs']['posiedzenia']['top']['hits']['hits']) { ?>
	                                    <ul class="dataobjects">
	                                        <? foreach ($dataBrowser['aggs']['posiedzenia']['top']['hits']['hits'] as $doc) { ?>
	                                            <li>
	                                                <?
	                                                echo $this->Dataobject->render($doc, 'default');
	                                                ?>
	                                            </li>
	                                        <? } ?>
	                                    </ul>
	                                    <div class="buttons">
	                                        <a href="<?= $dzielnica->getUrl() ?>/rada_posiedzenia" class="btn btn-primary btn-xs">Zobacz
	                                            więcej</a>
	                                    </div>
	                                <? } ?>

	                            </div>
	                        </div>


	                    </div>
	                </div>

	                <div class="databrowser-panel">
	                    <h2>Radni dzielnicy:</h2>

	                    <div class="aggs-init">

	                        <div class="dataAggs">
	                            <div class="agg agg-Dataobjects">
	                                <? if ($dataBrowser['aggs']['radni']['top']['hits']['hits']) { ?>
	                                    <ul class="dataobjects row radni_dzielnic">
	                                        <? foreach ($dataBrowser['aggs']['radni']['top']['hits']['hits'] as $doc) { ?>
	                                            <li class="col-md-6<? if($doc['fields']['source'][0]['data']['radni_dzielnic.avatar']) {?> avatar<?}?>">
	                                                <?
	                                                echo $this->Dataobject->render($doc, 'default');
	                                                ?>
	                                            </li>
	                                        <? } ?>
	                                    </ul>
	                                <? } ?>

	                            </div>
	                        </div>


	                    </div>
	                </div>



	            <? } ?>

	        </div>

	    </div><div class="col-sm-3 nopadding">

			<? if( $info = $dzielnica->getLayer('info') ) { ?>
			<ul class="dataHighlights show overflow-auto">
                <li class="dataHighlight col-xs-12">
		            <p class="_label">Liczba mieszkańców:</p>
		            <p class="_value"><?= $info['liczba_mieszkancow'] ?></p>
		        </li>
		        <li class="dataHighlight col-xs-12">
		            <p class="_label">Powierzchnia:</p>
		            <p class="_value"><?= $info['liczba_powierzchnia'] ?> km<sup>2</sup></p>
		        </li>
		        <li class="dataHighlight col-xs-12">
		            <p class="_label">Gęstość zaludnienia:</p>
		            <p class="_value"><?= $info['liczba_gestosc_zaludnienia'] ?> os./km<sup>2</sup></p>
		        </li>
		        <li class="dataHighlight col-xs-12">
		            <p class="_label">Frekwencja w wyborach samorządowych:
		            <p class="_value"><?= $info['liczba_frekwencja'] ?>%</p>
		        </li>
		        <li class="dataHighlight col-xs-12">
		            <p class="_label">Wikipedia:
		            <p class="_value"><a target="_blank" href="<?= $info['url_wiki'] ?>">Link</a></p>
		        </li>
			</ul>
			<? } ?>

	        <?
	        $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
	        $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
	        $this->Combinator->add_libs('js', 'Pisma.pisma-button');
	        echo $this->element('tools/pismo', array(
	            'label' => '<strong>Wyślij pismo</strong> do Rady Dzielnicy',
	            'adresat' => 'dzielnice:' . $dzielnica->getId(),
	        ));
	        ?>

	    </div>
	</div>
</div>
