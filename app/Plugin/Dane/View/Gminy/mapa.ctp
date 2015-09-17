<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-mapa', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'latlon-geohash');
$this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-mapa');

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=pl-PL', array('block' => 'scriptBlock'));
?>
    <div class="container">
        <div class="row">
            <form>
                <label>
                    <input type="checkbox" id="administrative_locality">
                    Dzielnice
                </label>
                <br>
                <label>
                    <input type="checkbox" id="administrative_neighborhood">
                    Części dzielnic
                </label>
                <br>
                <label>
                    <input type="checkbox" id="road_arterial">
                    Ulice główne
                </label>
                <br>
                <label>
                    <input type="checkbox" id="road_highway">
                    Drogi szybkiego ruchu
                </label>
                <br>
                <label>
                    <input type="checkbox" id="road_highway_controlled_access">
                    Autostrady
                </label>
                <br>
                <label>
                    <input type="checkbox" id="road_local">
                    Ulice lokalne
                </label>
            </form>
        </div>
    </div>
<?= $this->Element('dataobject/pageBegin'); ?>

    <div id="map"></div>



<?= $this->Element('dataobject/pageEnd'); ?>

<? /*
 administrative	Apply the rule to administrative areas.
administrative.country	Apply the rule to countries.
administrative.land_parcel	Apply the rule to land parcels.
administrative.locality	Apply the rule to localities.
administrative.neighborhood	Apply the rule to neighborhoods.
administrative.province	Apply the rule to provinces.
all	Apply the rule to all selector types.
landscape	Apply the rule to landscapes.
landscape.man_made	Apply the rule to man made structures.
landscape.natural	Apply the rule to natural features.
landscape.natural.landcover	Apply the rule to landcover.
landscape.natural.terrain	Apply the rule to terrain.
poi	Apply the rule to points of interest.
poi.attraction	Apply the rule to attractions for tourists.
poi.business	Apply the rule to businesses.
poi.government	Apply the rule to government buildings.
poi.medical	Apply the rule to emergency services (hospitals, pharmacies, police, doctors, etc).
poi.park	Apply the rule to parks.
poi.place_of_worship	Apply the rule to places of worship, such as churches, temples, or mosques.
poi.school	Apply the rule to schools.
poi.sports_complex	Apply the rule to sports complexes.
road	Apply the rule to all roads.
road.arterial	Apply the rule to arterial roads.
road.highway	Apply the rule to highways.
road.highway.controlled_access	Apply the rule to controlled-access highways.
road.local	Apply the rule to local roads.
transit	Apply the rule to all transit stations and lines.
transit.line	Apply the rule to transit lines.
transit.station	Apply the rule to all transit stations.
transit.station.airport	Apply the rule to airports.
transit.station.bus	Apply the rule to bus stops.
transit.station.rail	Apply the rule to rail stations.
water */
