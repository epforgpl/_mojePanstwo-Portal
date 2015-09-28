<?php

App::uses('ApplicationsController', 'Controller');

class NgoController extends ApplicationsController
{

    public $settings = array(
        'id' => 'ngo',
        'title' => 'NGO',
        'subtitle' => 'Organizacje pozarządowe w Polsce',
        'headerImg' => 'ngo',
    );

    public $components = array('RequestHandler');

    public $submenus = array(
        'ngo' => array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Start',
                ),
                array(
                    'id' => 'dzialania',
                    'label' => 'Działania',
                ),
                array(
                    'id' => 'fundacje',
                    'label' => 'Fundacje',
                ),
                array(
                    'id' => 'stowarzyszenia',
                    'label' => 'Stowarzyszenia',
                ),
            )
        )
    );

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/prawo/img/social/prawo.jpg');
    }

    public function addDeclaration()
    {

        $status = $this->Ngo->addDeclaration($this->request->data);
        if ($status) {
            $this->Session->setFlash('Twoje zgłoszenie zostało zapisane. Skontaktujemy się z Tobą w najbliższym czasie.');
        } else {
            $this->Session->setFlash('Wystąpił problem z wysyłaniem zgłoszenia');
        }

        return $this->redirect('/ngo');

    }

    public function map()
    {

        if (
        isset($this->request->query['area'])
        ) {

            list($tl, $br) = explode(',', $this->request->query['area']);
            $precision = strlen($tl) + 1;

            $options = array(
                'cover' => array(
                    'force' => true,
                    'aggs' => array(
                        'map' => array(
                            'scope' => 'global',
                            'filter' => array(
                                'bool' => array(
                                    'must' => array(
                                        array(
                                            'term' => array(
                                                'dataset' => 'krs_podmioty',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krs_podmioty.forma_prawna_typ_id' => '2',
                                            ),
                                        ),
                                        array(
                                            'term' => array(
                                                'data.krs_podmioty.wykreslony' => '0',
                                            ),
                                        ),
                                        array(
                                            'geo_bounding_box' => array(
                                                'position' => array(
                                                    'top_left' => $tl,
                                                    'bottom_right' => $br,
                                                ),
                                            ),
                                        ),
                                    ),
                                    '_cache' => true,
                                ),
                            ),
                            'aggs' => array(
                                'grid' => array(
                                    'geohash_grid' => array(
                                        'field' => 'position',
                                        'precision' => $precision,
                                    ),
                                    'aggs' => array(
                                        'inner_grid' => array(
                                            'geohash_grid' => array(
                                                'field' => 'position',
                                                'precision' => $precision + 1,
                                                'size' => 1,
                                            ),
                                        ),
                                        'top' => array(
	                                        'top_hits' => array(
		                                        'size' => 1,
		                                        'fielddata_fields' => array('position.lat', 'position.lon'),
		                                        '_source' => false,
		                                        'fields' => array(),
	                                        ),
                                        ),
                                        /*
                                        'lat' => array(
                                            'terms' => array(
                                                'field' => 'position.lat',
                                                'size' => 1,
                                            ),
                                        ),
                                        'lng' => array(
                                            'terms' => array(
                                                'field' => 'position.lon',
                                                'size' => 1,
                                            ),
                                        ),
                                        'id' => array(
                                            'terms' => array(
                                                'field' => '_id',
                                                'size' => 1,
                                            ),
                                        ),
                                        */
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            );

            $this->Components->load('Dane.DataBrowser', $options);
            $this->set('_serialize', 'dataBrowser');


        } else {

            throw new BadRequestException('Required parameters missing');

        }

    }

    public function beforeRender()
    {

        parent::beforeRender();

        if ($this->request->params['action'] == 'map') {

            $data = $this->viewVars['dataBrowser']['aggs']['map'];
            foreach ($data['grid']['buckets'] as &$b) {
								
                if ($b['doc_count'] === 1) {
										
					$b['data'] = $b['top']['hits']['hits'][0]['fields']['source'][0]['data'];
					$b['location'] = array(
						'lat' => $b['top']['hits']['hits'][0]['fields']['position.lat'][0],
						'lon' => $b['top']['hits']['hits'][0]['fields']['position.lon'][0],
					);
					
                    unset($b['top']);

                } else {

                    unset($b['top']);

                }

                $b['inner_key'] = $b['inner_grid']['buckets'][0]['key'];
                unset($b['inner_grid']);

            }

            $this->viewVars['dataBrowser'] = $data;

        }

    }

    public function view()
    {

        $options = array(
            'searchTag' => array(
	            'href' => '/ngo',
	            'label' => 'NGO',
            ),
            'autocompletion' => array(
                'dataset' => 'ngo',
            ),
            'conditions' => array(
                'dataset' => 'krs_podmioty',
                'krs_podmioty.forma_prawna_typ_id' => array('2'),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Ngo',
                    'element' => 'cover',
                ),
                'aggs' => array(
                    'dzialania' => array(
                        'scope' => 'global',
                        'filter' => array(
                            'term' => array(
                                'dataset' => 'dzialania',
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 3,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'fundacje' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'data.krs_podmioty.forma_prawna_id' => '1',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 5,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'stowarzyszenia' => array(
                        'filter' => array(
                            'bool' => array(
                                'must' => array(
                                    array(
                                        'term' => array(
                                            'data.krs_podmioty.forma_prawna_id' => '15',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                        'aggs' => array(
                            'top' => array(
                                'top_hits' => array(
                                    'size' => 5,
                                    'fielddata_fields' => array('dataset', 'id'),
                                    'sort' => array(
                                        'date' => array(
                                            'order' => 'desc',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => array(
                            'krs_podmioty' => 'Organizacje',
                        ),
                    ),
                ),
            ),
        );

        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => '',
        )));

        $this->title = 'Organizacje pozarządowe i akcje społeczne';

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');
    }

    public function dzialania()
    {
        $this->loadDatasetBrowser('dzialania', array(
            'conditions' => array(
                'dataset' => 'dzialania',
                'dzialania.status' => '1',
            ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'dzialania',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Działania organizacji społecznych');

    }

    public function fundacje()
    {
        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => '1',
            ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'fundacje',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Fundacje | NGO');

    }

    public function stowarzyszenia()
    {
        $this->set('_submenu', array_merge($this->submenus['ngo'], array(
            'selected' => 'stowarzyszenia',
        )));

        $this->loadDatasetBrowser('krs_podmioty', array(
            'conditions' => array(
                'krs_podmioty.forma_prawna_id' => '15',
            ),
            'menu' => array_merge($this->submenus['ngo'], array(
                'selected' => 'stowarzyszenia',
                'base' => '/ngo'
            ))
        ));
        $this->set('title_for_layout', 'Stowarzyszenia | NGO');

    }

    public function getChapters()
    {

        $mode = false;

        $items = array(
            array(
                'label' => 'Start',
                'href' => '/' . $this->settings['id'],
            ),
        );

        $items[] = array(
            'id' => 'dzialania',
            'label' => 'Działania społeczne',
            'href' => '/ngo/dzialania',
        );

        $items[] = array(
            'id' => 'fundacje',
            'label' => 'Fundacje',
            'href' => '/ngo/fundacje',
        );

        $items[] = array(
            'id' => 'stowarzyszenia',
            'label' => 'Stowarzyszenia',
            'href' => '/ngo/stowarzyszenia',
        );

        $output = array(
            'items' => $items,
            'selected' => ($this->chapter_selected == 'view') ? false : $this->chapter_selected,
        );

        return $output;

    }

}
