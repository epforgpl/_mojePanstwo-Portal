<?php

App::uses('ApplicationsController', 'Controller');

class PlacesController extends ApplicationsController
{

    public $components = array('RequestHandler');

    public $settings = array(
        'id' => 'mapa',
        'title' => 'Mapa'
    );

    private $fields = array(
        '1' => 'wojewodztwa',
        '2' => 'powiaty',
        '3' => 'gminy',
        '4' => 'miejscowosci',
        '5' => 'ulice',
    );

    public function view($id)
    {
        $this->loadModel('Dane.Dataobject');
        $place = $this->Dataobject->find('first', array(
            'conditions' => array(
                'dataset' => 'miejsca',
                'id' => $id,
            ),
            'layers' => array(
                'shapes'
            ),
            'aggs' => array(
                'numery' => array(
                    'nested' => array(
                        'path' => 'miejsca-numery',
                    ),
                    'aggs' => array(
                        'numery' => array(
                            'top_hits' => array(
                                'size' => 10000,
                                'fielddata_fields' => array('numer', 'miejsca-numery.location.lat', 'miejsca-numery.location.lon', 'parl_obwod_id', 'kod'),
                                'sort' => array(
                                    'miejsca-numery.numer_int' => array(
                                        'order' => 'asc',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'miejsca' => array(
                    'filter' => array(
                        'term' => array(
                            'dataset' => 'miejsca',
                        ),
                    ),
                    'aggs' => array(
                        'children' => array(
                            'nested' => array(
                                'path' => 'miejsca-parents',
                            ),
                            'aggs' => array(
                                '*' => array(
                                    'filter' => array(
                                        'term' => array(
                                            'miejsca-parents.id' => $id,
                                        ),
                                    ),
                                    'aggs' => array(
                                        'reverse' => array(
                                            'reverse_nested' => '_empty',
                                            'aggs' => array(
                                                'punkty' => array(
                                                    'nested' => array(
                                                        'path' => 'miejsca-numery',
                                                    ),
                                                    'aggs' => array(
                                                        'kody' => array(
                                                            'terms' => array(
                                                                'field' => 'miejsca-numery.kod',
                                                                'size' => 3,
                                                            ),
                                                        ),
                                                        'parl_obwody' => array(
                                                            'terms' => array(
                                                                'field' => 'miejsca-numery.parl_obwod_id',
                                                                'size' => 10000,
                                                            ),
                                                        ),
                                                        'viewport' => array(
                                                            'geo_bounds' => array(
                                                                'field' => 'miejsca-numery.location',
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                                'wybory_okreg_sejm_id' => array(
                                                    'terms' => array(
                                                        'field' => 'data.miejsca.wybory_okreg_sejm_id',
                                                        'size' => 3,
                                                        'exclude' => '0',
                                                    ),
                                                ),
                                                'wybory_okreg_senat_id' => array(
                                                    'terms' => array(
                                                        'field' => 'data.miejsca.wybory_okreg_senat_id',
                                                        'size' => 3,
                                                        'exclude' => '0',
                                                    ),
                                                ),
                                            ),
                                        ),
                                        'direct' => array(
                                            'filter' => array(
                                                'term' => array(
                                                    'miejsca-parents.distance' => 1,
                                                ),
                                            ),
                                            'aggs' => array(
                                                'reverse' => array(
                                                    'reverse_nested' => '_empty',
                                                    'aggs' => array(
                                                        'typy' => array(
                                                            'terms' => array(
                                                                'field' => 'data.miejsca.typ_id',
                                                                'size' => 5,
                                                            ),
                                                            'aggs' => array(
                                                                'top' => array(
                                                                    'top_hits' => array(
                                                                        'size' => 10000,
                                                                        'sort' => array(
                                                                            'title.raw' => array(
                                                                                'order' => 'asc',
                                                                            ),
                                                                        ),
                                                                    ),
                                                                ),
                                                            ),
                                                        ),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'scope' => 'global',
                ),
            ),
        ));

        // $data = $this->getPlaceData($place);
        // debug($data); die();

        $points = array();
        $viewport = array();
        $children = array();
        $codes = array();
        $elections = array();


        if ($aggs = $this->Dataobject->getAggs()) {


            // VIEWPORT

            if (@$aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds']) {

                $viewport = $aggs['miejsca']['children']['*']['reverse']['punkty']['viewport']['bounds'];

            }

            if (@$aggs['miejsca']['children']['*']['reverse']['punkty']['parl_obwody']['buckets']) {

                $elections['obwody'] = $aggs['miejsca']['children']['*']['reverse']['punkty']['parl_obwody']['buckets'];

            }


            // POSTAL CODES

            if (@$aggs['miejsca']['children']['*']['reverse']['punkty']['kody']['buckets']) {

                $codes = $aggs['miejsca']['children']['*']['reverse']['punkty']['kody']['buckets'];

            }


            if ($typy = @$aggs['miejsca']['children']['*']['direct']['reverse']['typy']['buckets']) {
                foreach ($typy as $t) {

                    $field = $this->fields[$t['key']];
                    foreach ($t['top']['hits']['hits'] as $h)
                        $children[$field][] = array_merge($h['fields']['source'][0]['data'], $h['fields']['source'][0]['static']);

                }
            }

            if (@$aggs['miejsca']['children']['*']['reverse']['wybory_okreg_senat_id']['buckets'])
                $elections['senat'] = $aggs['miejsca']['children']['*']['reverse']['wybory_okreg_senat_id']['buckets'];

            if (@$aggs['miejsca']['children']['*']['reverse']['wybory_okreg_sejm_id']['buckets'])
                $elections['sejm'] = $aggs['miejsca']['children']['*']['reverse']['wybory_okreg_sejm_id']['buckets'];

            if ($_points = @$aggs['numery']['numery']['hits']['hits']) {

                foreach ($_points as $_p) {

                    $p = array();

                    if (@$_p['fields']['miejsca-numery.location.lon'][0] && @$_p['fields']['miejsca-numery.location.lat'][0])
                        $p['lat'] = $_p['fields']['miejsca-numery.location.lat'][0];
                    $p['lon'] = $_p['fields']['miejsca-numery.location.lon'][0];

                    if (@$_p['fields']['numer'][0])
                        $p['numer'] = $_p['fields']['numer'][0];

                    if (@$_p['fields']['parl_obwod_id'][0])
                        $p['parl_obwod_id'] = $_p['fields']['parl_obwod_id'][0];

                    if (@$_p['fields']['kod'][0])
                        $p['kod'] = $_p['fields']['kod'][0];

                    if (!empty($p))
                        $points[] = $p;

                }

            }

        }


        $this->title = $place->getTitle();
        $this->set('mapParams', array(
            'mode' => 'place',
            'title' => $place->getTitle(),
            'data' => $place->getData(),
            'points' => $points,
            'viewport' => $viewport,
            'children' => $children,
            'elections' => $elections,
            'codes' => $codes,
        ));

        if (isset($this->request->query['widget'])) {
            $this->layout = 'blank';
            $this->set('widget', true);
        }
				
        $parentPlace = $place->getStatic();

        $this->set('_place', $parentPlace['polygons']);
        $this->set('_serialize', 'mapParams');
    }

    public function getPlaceData($object = false)
    {

        if (!is_object($object))
            return false;

        $options = false;

        switch ($object->getData('typ_id')) {

            case '4': {

                $options = array(
                    'aggs' => array(
                        'miejsca' => array(
                            'scope' => 'global',
                            'filter' => array(
                                'boolean' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'miejsca',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'aggs' => array(
                                'top' => array(
                                    'top_hits' => array(
                                        'size' => 1,
                                    ),
                                ),
                            ),
                        ),
                    ),
                );

                break;
            }

        }

        if (!$options)
            return false;

        $this->loadModel('Dane.Dataobject');
        $this->Dataobject->find('all', array(
            'limit' => 0,
            'aggs' => $options['aggs'],
        ));

        return $this->Dataobject->getDataSource()->Aggs;

    }

}
