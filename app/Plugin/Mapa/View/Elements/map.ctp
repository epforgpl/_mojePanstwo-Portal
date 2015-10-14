<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('mapa', array('plugin' => 'Mapa')));

$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'Mapa.mapa');

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));
?>
<div class="objectsPage">
    <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
        <? if (!isset($widget)) { ?>
            <div class="searcher-app">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <?
                            $_params = array(
                                'dataBrowser' => array(
                                    'autocompletion' => array(
                                        'dataset' => 'miejsca',
                                    ),
                                    'searchTitle' => 'Szukaj adresu, miejscowości lub kodu pocztowego...',
                                    'searchAction' => '/mapa',
                                    'searchTag' => array(
                                        'href' => '/mapa',
                                        'label' => 'Mapa',
                                    )
                                ),
                            );
                            echo $this->element('Dane.DataBrowser/browser-searcher', $_params);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <? if (isset($app_menu)) { ?>
                <div class="apps-menu">
                    <div class="container">
                        <ul>
                            <? foreach ($app_menu[0] as $a) { ?>
                                <li>
                                    <a<? if (isset($a['active']) && $a['active']) { ?> class="active"<? } ?>
                                        href="<?= $a['href'] ?>"><?= $a['title'] ?></a>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            <? }
        } ?>

        <div class="container">
            <div id="mapBrowser"
                 class="row dataBrowserContent"
                 <? if (@$mapParams['viewport']) { ?>data-viewport="<?= htmlspecialchars(json_encode($mapParams['viewport'])) ?>"<? } ?>
                 <? if (@$mapParams['data']) { ?>data-typ_id="<?= $mapParams['data']['miejsca.typ_id'] ?>"<? } ?>
                 <? if (@$mapParams['data']) { ?>data-object_id="<?= $mapParams['data']['miejsca.object_id'] ?>"<? } ?>>

                <div class="map<? if (!isset($mapParams)) { ?> nodetails<? } ?>"></div>

                    <? if (isset($mapParams)) { ?>
                        <div class="details" itemscope itemtype="http://schema.org/Place">
                            <div class="title">
	                            <? if( ($mapParams['data']['typ_id']=='4') && isset($mapParams['data']['miejsca.miejscowosc_typ']) ) {?>
		                            <p class="_label"><?= $mapParams['data']['miejsca.miejscowosc_typ'] ?></p>
	                            <? } elseif( ($mapParams['data']['typ_id']=='3') && isset($mapParams['data']['miejsca.gmina_typ_id']) ) {?>
		                            <p class="_label">
		                            <?
			                            if( $mapParams['data']['miejsca.gmina_typ_id']=='1' )
			                            	echo "Gmina miejska";
			                            elseif( $mapParams['data']['miejsca.gmina_typ_id']=='2' )
			                            	echo "Gmina wiejska";
			                            elseif( $mapParams['data']['miejsca.gmina_typ_id']=='3' )
			                            	echo "Gmina miejsko-wiejska";
			                            elseif( $mapParams['data']['miejsca.gmina_typ_id']=='4' )
			                            	echo "Miasto stołeczne";
		                            ?>
		                            </p>
	                            <? } elseif( ($mapParams['data']['typ_id']=='5') ) {?>
		                            <p class="_label"><?= $mapParams['data']['miejsca.ulica_cecha'] ?></p>
	                            <? } ?>
                                <h1><?= $mapParams['title'] ?></h1>
                                <?
                                $typ_id = (int)$mapParams['data']['typ_id'];
                                if ($typ_id > 1) { ?>
                                    <ul class="meta">
                                        <? if ($typ_id > 4) { ?>
                                            <li>
                                                <label>Miejscowość:</label>
                                                <a href="/mapa/miejsce/<?= $mapParams['data']['miejsca.miejscowosc_miejsce_id'] ?>"><?= ($mapParams['data']['miejscowosc']) ?></a>
                                            </li>
                                        <? } ?>

                                    <? if ($typ_id > 3) { ?>
                                        <li>
                                            <label>Gmina:</label>
                                            <a href="/mapa/miejsce/<?= $mapParams['data']['miejsca.gmina_miejsce_id'] ?>"><?= ($mapParams['data']['gmina']) ?></a>
                                        </li>
                                    <? } ?>

                                    <? if ($typ_id > 2) { ?>
                                        <li>
                                            <label>Powiat:</label>
                                            <a href="/mapa/miejsce/<?= $mapParams['data']['miejsca.powiat_miejsce_id'] ?>"><?= ($mapParams['data']['powiat']) ?></a>
                                        </li>
                                    <? } ?>

                                    <? if ($typ_id > 1) { ?>
                                        <li>
                                            <label>Województwo:</label>
                                            <a href="/mapa/miejsce/<?= $mapParams['data']['miejsca.wojewodztwo_miejsce_id'] ?>"><?= strtolower($mapParams['data']['wojewodztwo']) ?></a>
                                        </li>
                                    <? } ?>

                                    <? if (count($mapParams['codes']) === 1) { ?>
                                        <li>
                                            <label>Kod pocztowy:</label>
                                            <a href="/mapa/<?= $mapParams['codes'][0]['key'] ?>"><?= $mapParams['codes'][0]['key'] ?></a>
                                        </li>
                                    <? } ?>
                                </ul>
                            <? } ?>
                        </div>

                        <ul class="main">
                            <? if (@$mapParams['data'] && $mapParams['data']['miejsca.typ_id'] >= 2) { ?>
                                <li class="accord <? if (!isset($widget)) { ?>closed <? } ?>wyboryDetail">
                                    <header><h2>Wybory parlamentarne 2015</h2></header>
                                    <section class="dcontent">
                                        <ul class="wybory">
                                            <li>
                                                <h3>Na kogo głosować?</h3>
                                            </li>
                                            <li>
                                                <button class="btn btn-primary btn-xs">Pokaż kandydatów do
                                                    Sejmu &raquo;</button>
                                            </li>
                                            <li>
                                                <button class="btn btn-primary btn-xs">Pokaż kandydatów do
                                                    Senatu &raquo;</button>
                                            </li>
                                        </ul>
                                        <ul class="komisja">
                                            <li>
                                                <h3>Gdzie głosować?</h3>
                                            </li>
                                            <li class="komisja-adres">Ministerstwo Rolnictwa i Rozwoju Wsi, ul.Wspólna
                                                30, Śródmieście 00-519 Warszawa
                                            </li>
                                        </ul>
                                    </section>
                                </li>
                            <? } ?>
                            <? if (@$mapParams['children']['powiaty']) { ?>
                                <li class="accord">
                                    <header>
                                        <h2>Powiaty:</h2>
                                    </header>
                                    <section class="dcontent">
                                        <div class="input-group">
                                            <input type="text" placeholder="Szukaj..."
                                                   class="form-control hasclear input-md"/>

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary input-md">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <ul class="scrollZone">
                                            <? foreach ($mapParams['children']['powiaty'] as $item) { ?>
                                                <li>
                                                    <a href="/mapa/miejsce/<?= $item['miejsca.id'] ?>"><?= $item['miejsca.powiat'] ?></a>
                                                </li>
                                            <? } ?>
                                        </ul>
                                    </section>
                                </li>
                            <? } ?>
                            <? if (@$mapParams['children']['gminy']) { ?>
                                <li class="accord">
                                    <header>
                                        <h2>Gminy:</h2>
                                    </header>
                                    <section class="dcontent">
                                        <div class="input-group">
                                            <input type="text" placeholder="Szukaj..."
                                                   class="form-control hasclear input-md"/>

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary input-md">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <ul class="scrollZone">
                                            <? foreach ($mapParams['children']['gminy'] as $item) { ?>
                                                <li>
                                                    <a href="/mapa/miejsce/<?= $item['miejsca.id'] ?>"><?= $item['miejsca.gmina'] ?></a>
                                                </li>
                                            <? } ?>
                                        </ul>
                                    </section>
                                </li>
                            <? } ?>
                            <? if (@$mapParams['children']['miejscowosci']) { ?>
                                <li class="accord">
                                    <header>
                                        <h2>Miejscowości:</h2>
                                    </header>
                                    <section class="dcontent">
                                        <div class="input-group">
                                            <input type="text" placeholder="Szukaj..."
                                                   class="form-control hasclear input-md"/>

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary input-md">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <ul class="scrollZone">
                                            <? foreach ($mapParams['children']['miejscowosci'] as $item) { ?>
                                                <li>
                                                    <a href="/mapa/miejsce/<?= $item['miejsca.id'] ?>"><?= $item['miejsca.miejscowosc'] ?></a>
                                                </li>
                                            <? } ?>
                                        </ul>
                                    </section>
                                </li>
                            <? } ?>
                            <? if (@$mapParams['children']['ulice']) { ?>
                                <li class="accord">
                                    <header>
                                        <h2>Ulice:</h2>
                                    </header>
                                    <section class="dcontent">
                                        <div class="input-group">
                                            <input type="text" placeholder="Szukaj..."
                                                   class="form-control hasclear input-sm"/>

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary input-sm">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <ul class="scrollZone">
                                            <? foreach ($mapParams['children']['ulice'] as $item) { ?>
                                                <li>
                                                    <a href="/mapa/miejsce/<?= $item['miejsca.id'] ?>"><?= $item['miejsca.ulica'] ?></a>
                                                </li>
                                            <? } ?>
                                        </ul>
                                    </section>
                                </li>
                            <? } ?>
                            <? if (@$mapParams['points']) { ?>
                                <li class="accord">
                                    <header>
                                        <h2>Numery:</h2>
                                    </header>
                                    <section class="dcontent">
                                        <div class="input-group">
                                            <input type="text" placeholder="Szukaj..."
                                                   class="form-control hasclear input-sm"/>

                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary input-sm">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <ul class="scrollZone _points">
                                            <? foreach ($mapParams['points'] as $item) { ?>
                                                <li name="<?= $item['numer'] ?>" itemprop="geo" itemscope
                                                    itemtype="http://schema.org/GeoCoordinates">
                                                    <a href='#<?= urlencode($item['numer']) ?>'><?= $item['numer'] ?></a>
                                                    <meta itemprop="latitude"
                                                          content="<?= $item['lat'] ?>"/>
                                                    <meta itemprop="longitude"
                                                          content="<?= $item['lon'] ?>"/>
                                                </li>
                                            <? } ?>
                                        </ul>
                                    </section>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
</div>
