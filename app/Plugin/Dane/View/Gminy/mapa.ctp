<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-mapa', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'latlon-geohash');
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-mapa');

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=pl-PL', array('block' => 'scriptBlock'));
?>
<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="mapholder">
        <div class="menuholder">
            <div id="map_menu" class="ui-widget-content">
                <div class="menu_srolling">
                <h4>Etykiety:</h4>
                <ul class="list-unstyled">
                    <li><label>
                            <input class="google_layers_switch" type="checkbox" id="administrative_locality">
                            Dzielnice
                        </label></li>
                    <li><label>
                            <input class="google_layers_switch" type="checkbox" id="administrative_neighborhood">
                            Części dzielnic
                        </label>
                    </li>

                    <li><label>
                            <input class="" type="checkbox" id="road">
                            Drogi
                        </label>
                        <ul class="">
                            <li><label>
                                    <input class="google_layers_switch typy_drog" type="checkbox" id="road_arterial">
                                    Ulice główne
                                </label></li>
                            <li><label>
                                    <input class="google_layers_switch typy_drog" type="checkbox" id="road_highway">
                                    Drogi szybkiego ruchu
                                </label></li>
                            <li><label>
                                    <input class="google_layers_switch typy_drog" type="checkbox" id="road_highway_controlled_access">
                                    Autostrady
                                </label></li>
                            <li><label>
                                    <input class="google_layers_switch typy_drog" type="checkbox" id="road_local">
                                    Ulice lokalne
                                </label></li>
                            <li><label>
                                    <input class="google_layers_switch typy_drog" type="checkbox" id="place_i_wezly">
                                    Place i węzły drogowe
                                </label>
                            </li>

                        </ul>
                    </li>
                    <li><label>
                            <input class="google_layers_switch" type="checkbox" id="water">
                            Rzeki i zbiorniki wodne
                        </label></li>
                            <li><label>
                                    <input class="google_layers_switch" type="checkbox" id="transit_station">
                                    Dworce
                                </label></li>
                            <ul>
                            <li><label>
                                    <input class="google_layers_switch stacje" type="checkbox" id="transit_station_bus">
                                    Autobusowe
                                </label></li>
                            <li><label>
                                    <input class="google_layers_switch stacje" type="checkbox" id="transit_station_rail">
                                    Kolejowe
                                </label></li>
                            <li><label>
                                    <input class="google_layers_switch stacje" type="checkbox" id="transit_station_airport">
                                    Lotnicze
                                </label>
                            </li>
                            </ul>
                    </ul>
                <h4>Obszary:</h4>
                <ul class="list-unstyled">
                    <li><label>
                            <input type="checkbox" class="dzielnice" id="dzielnice_all" value="dzielnice">
                            Dzielnice
                        </label>
                        <ul>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="stare_miasto" value="I" data-layer="dzielnice">
                                    I - Stare Miasto
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="grzegorzki" value="II" data-layer="dzielnice">
                                    II - Grzegórzki
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="pradnik_czerwony" value="III" data-layer="dzielnice">
                                    III - Prądnik Czerwony
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="pradnik_bialy" value="IV" data-layer="dzielnice">
                                    IV - Prądnik Biały
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="krowodrza" value="V" data-layer="dzielnice">
                                    V - Krowodrza
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="bronowice" value="VI" data-layer="dzielnice">
                                    VI - Bronowice
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="zwierzyniec" value="VII" data-layer="dzielnice">
                                    VII -  Zwierzyniec
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="debniki" value="VIII" data-layer="dzielnice">
                                    VIII - Dębniki
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="lagiewniki" value="IX" data-layer="dzielnice">
                                    IX - Łagiewniki-Borek Fałęcki
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="swoszowice" value="X" data-layer="dzielnice">
                                    X - Swoszowice
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="podgorze_duchackie" value="XI" data-layer="dzielnice">
                                    XI - Podgórze Duchackie
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="biezanow" value="XII" data-layer="dzielnice">
                                    XII - Bieżanów-Prokocim
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="podgorze" value="XII" data-layer="dzielnice">
                                    XIII - Podgórze
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="czyzyny" value="XIV" data-layer="dzielnice">
                                    XIV - Czyżyny
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="mistrzejowice" value="XIV" data-layer="dzielnice">
                                    XV - Mistrzejowice
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="bienczyce" value="XVI" data-layer="dzielnice">
                                    XVI - Bieńczyce
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="wzgorza_krzeslawickie" value="XVII" data-layer="dzielnice">
                                    XVII - Wzgórza Krzesławickie
                                </label></li>
                            <li><label>
                                    <input class="dzielnice dzielnica layer" type="checkbox" id="nowa_huta" value="XVIII" data-layer="dzielnice">
                                    XVIII - Nowa Huta
                                </label></li>
                        </ul>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="map"></div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>
