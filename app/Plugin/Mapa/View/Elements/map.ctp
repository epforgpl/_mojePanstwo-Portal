<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
//$this->Combinator->add_libs('css', $this->Less->css('warstwy', array('plugin' => 'Mapa')));
$this->Combinator->add_libs('css', $this->Less->css('mapa', array('plugin' => 'Mapa')));

echo $this->Html->css($this->Less->css('app'));

$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'latlon-geohash');
// $this->Combinator->add_libs('js', 'Mapa.warstwy');
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
echo $this->element('headers/main');
?>

<div class="app-sidebar">
    <div class="app-logo">
        <? if (!empty($_app)) { ?>
            <a href="/<?= $_app['id'] ?>" target="_self">
                <img class="icon"
                     src="<?= $_app['href'] ?>/icon/icon_<?= $_app['id'] ?>.svg">
                <p><?= $_app['name'] ?></p>
            </a>
        <? } ?>
        <? if (!empty($app_chapters['items'])) { ?>
            <div class="_mobile btn btn-link btn-sm"></div>
        <? } ?>
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <div class="app-sidebar-scroll">
        <ul class="app-list">
            <?
            if (@$app_chapters['items']) {

                foreach ($app_chapters['items'] as $a) {
                    if ($a['id'] !== ('adm') && $a['id'] !== ('wojewodztwa') && $a['id'] !== ('powiaty') && $a['id'] !== ('gminy')) {
                        ?>
                        <li<? if ($layers == $a['id']) {
                            echo ' class="active"';
                        } ?>>
                            <? if (isset($a['href'])) {
                                echo '<a href="' . $a['href'] . '" data-href="' . $a['href'] . '" target="_self">';
                            } else {
                                echo '<div class="blank">';
                            }
                            ?>
                            <span class="icon <?= $a['icon'] ?>"></span>
                            <strong><?= $a['label'] ?></strong>
                            <? if (isset($a['href'])) {
                                echo '</a>';
                            } else {
                                echo '</div>';
                            } ?>
                        </li>
                        <?
                    }
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="app-content-wrap">
    <div class="objectsPage">
        <div class="dataBrowser margin-top-0<? if (isset($class)) echo " " . $class; ?>">
            <div class="container">

                <div class="appBanner">
                    <div class="appSearch form-group">
                        <div class="input-group">
                            <input class="form-control" placeholder="Szukaj miejsc, kodów pocztowych, instytucji..."
                                   type="text">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary input-md">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
							</span>
                        </div>
                    </div>
                </div>

                <div id="mapBrowser"
                     class="row dataBrowserContent"
                     <? if ($layers) { ?>data-layers="<?= $layers ?>" <? } ?>
                     <? if (@$mapParams['viewport']) { ?>data-viewport="<?= htmlspecialchars(json_encode($mapParams['viewport'])) ?>"<? } ?>
                     <? if (@$mapParams['data']) { ?>data-typ_id="<?= $mapParams['data']['miejsca.typ_id'] ?>"<? } ?>

                     <? if (@$mapParams['data']) { ?>data-object_id="<?= $mapParams['data']['miejsca.object_id'] ?>"<? } ?>

                     <? if (@$mapParams['data']) { ?>data-data="<?= htmlspecialchars(json_encode($mapParams['data'])) ?>"<? } ?>>

                    <div class="map<? if (!isset($mapParams) && !isset($dataBrowser)) {
                        echo ' nodetails';
                    } ?>"></div>

                    <? /*
                <div class="explore hide<? if (!isset($mapParams) && !isset($dataBrowser)) {
                    echo ' nodetails';
                } ?>">
                    <ul>
                        <li data-layer="komisje_wyborcze" class="open">Wybory parlamentarne 2015</li>
                    </ul>
                    <?
                    $counters = array(
                        'sejm' => count(@$mapParams['elections']['sejm']),
                        'senat' => count(@$mapParams['elections']['senat']),
                        'obwody' => count(@$mapParams['elections']['obwody']),
                    );

                    if ($counters['sejm'] || $counters['senat'] || $counters['obwody']) {
                        $ils = array();
                        $array_column_sejm = array_column($mapParams['elections']['sejm'], 'key');
                        $array_column_senat = array_column($mapParams['elections']['senat'], 'key');

                        $array_column_sejm = (count($array_column_sejm) == 1) ? $array_column_sejm[0] : '0';
                        $array_column_senat = (count($array_column_senat) == 1) ? $array_column_senat[0] : '0';

                        if (isset($mapParams['elections']['obwody']))
                            $ils = array_column($mapParams['elections']['obwody'], 'key');
                        ?>
                        <div class="explorerContent komisje_wyborcze_content wyboryDetail<? if (isset($widget)) {
                            echo ' widget';
                        } ?>"
                             data-obwody="<?= @implode(',', $ils) ?>"
                             data-sejm="<?= $array_column_sejm ?>"
                             data-senat="<?= $array_column_senat ?>"
                             data-miejsce="<?= $mapParams['data']['miejsca']['id'] ?>"
                             data-redirect="<?= (isset($_GET["redirect"])) ? true : false; ?>">
                            <section class="dcontent">
	                            <div class="row">
                                <div class="wyboryCheckbox col-xs-5">
                                    <span class="label">Pokazuj lokalizacje obwodowych komisji wyborczych</span>
                                    <input type="checkbox" name="wyboryShow" checked/>
                                </div>
                                <? if ($counters['sejm'] || $counters['senat'] || $counters['obwody']) { ?>
                                    <ul class="wybory meta col-xs-7 row">
                                        <? if ($counters['sejm'] > 0) { ?>
                                            <li class="sejm col-xs-6">
                                                <div class="pull-right">
                                                    <label>Okręg do Sejmu:</label>
                                                    <?
                                                    if (gettype($mapParams['elections']['sejm']) == "string") { ?>
                                                        <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $mapParams['elections']['sejm'] ?>"
                                                           target="_blank"><?= $mapParams['elections']['sejm'] ?></a>
                                                    <? } else {
                                                        foreach ($mapParams['elections']['sejm'] as $obwod_sejm) { ?>
                                                            <? if ($obwod_sejm !== $mapParams['elections']['sejm'][0]) echo '<span class="pull-left">, </span>' ?>
                                                            <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $obwod_sejm['key'] ?>"
                                                               target="_blank"><?= $obwod_sejm['key'] ?></a>
                                                        <? }
                                                    } ?>
                                                </div>
                                            </li>
                                        <? }
                                        if ($counters['senat'] > 0) { ?>
                                            <li class="senat col-xs-6">
                                                <label>Okręg do Senatu:</label>
                                                <?
                                                if (gettype($mapParams['elections']['senat']) == "string") { ?>
                                                    <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/sejm/<?= $mapParams['elections']['senat'] ?>"
                                                       target="_blank"><?= $mapParams['elections']['senat'] ?></a>
                                                <? } else {
                                                    foreach ($mapParams['elections']['senat'] as $obwod_senat) { ?>
                                                        <? if ($obwod_senat !== $mapParams['elections']['senat'][0]) echo '<span class="pull-left">, </span>' ?>
                                                        <a href="http://mamprawowiedziec.pl/strona/parl2015-kandydaci/senat/<?= $obwod_senat['key'] ?>"
                                                           target="_blank"><?= $obwod_senat['key'] ?></a>
                                                    <? }
                                                } ?>
                                            </li>
                                        <? }
                                        if ($counters['obwody'] === 1) { ?>
                                            <li class="obwod">
                                                <button
                                                    data-target="<?= $mapParams['elections']['obwody'][0]['key'] ?>"
                                                    disabled="disabled"
                                                    class="btn-obwod btn btn-warning btn-sm margin-top-10">
                                                    Pokaż lokal wyborczy
                                                </button>
                                            </li>
                                        <? } ?>
                                    </ul>
                                <? } ?>
	                            </div>
                            </section>
                        </div>
                        <?
                    } else {
                        ?>
                        <div class="explorerContent komisje_wyborcze_content wyboryDetail<? if (isset($widget)) {
                            echo ' widget';
                        } ?>">
                            <section class="dcontent">
                                <div class="row">
                                <div class="wyboryCheckbox col-xs-5">
                                    <span class="label">Pokazuj lokalizacje obwodowych komisji wyborczych</span>
                                    <input type="checkbox" name="wyboryShow" checked/>
                                </div>
                                </div>
                            </section>
                        </div>
                    <? } ?>
                </div>
                */ ?>
                </div>
            </div>
        </div>
    </div>
</div>
