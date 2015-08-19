<?php

App::uses('ApplicationsController', 'Controller');

class SejmometrController extends ApplicationsController
{

    public $settings = array(
        'id' => 'sejmometr',
        'title' => 'Sejmometr',
    );

	/*
	public function beforeFilter() {

		return $this->redirect('/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej');

	}
	*/

    public function getMenu()
    {
        $menu = array(
            'items' => array(
                array(
	                'id' => '',
                    'label' => 'Posłowie',
                    'href' => ''
                ),
                array(
                    'id' => 'posiedzenia',
                    'label' => 'Posiedzenia',
                    'href' => 'posiedzenia'
                ),
                array(
                    'id' => '#',
                    'label' => 'Więcej',
                    'dropdown' => array(
                        'items' => array(
                            array(
                                'id' => 'poslowie',
                                'label' => 'Posłowie',
                            ),
                            array(
                                'id' => 'posiedzenia',
                                'label' => 'Posiedzenia Sejmu',
                            ),
                            array(
                                'id' => 'sejm_wystapienia',
                                'label' => 'Wystąpienia',
                            ),
                            array(
                                'id' => 'sejm_glosowania',
                                'label' => 'Głosowania',
                            ),
                            array(
                                'id' => 'sejm_druki',
                                'label' => 'Druki sejmowe',
                            ),
                            array(
                                'id' => 'sejm_interpelacje',
                                'label' => 'Interpelacje',
                            ),
                            array(
                                'id' => 'sejm_kluby',
                                'label' => 'Kluby',
                            ),
                            array(
                                'id' => 'sejm_komisje',
                                'label' => 'Komisje',
                            ),
                            array(
                                'id' => 'sejm_dezyderaty',
                                'label' => 'Dezyderaty komisji',
                            ),
                            array(
                                'id' => 'sejm_komisje_opinie',
                                'label' => 'Opinie komisji sejmowych',
                            ),
                            array(
                                'id' => 'sejm_komisje_uchwaly',
                                'label' => 'Uchwały komisji',
                            ),
                            array(
                                'id' => 'sejm_komunikaty',
                                'label' => 'Komunikaty Kancelarii Sejmu',
                            ),
                            array(
                                'id' => 'poslowie_oswiadczenia_majatkowe',
                                'label' => 'Oświadczenia majątkowe posłów',
                            ),
                            array(
                                'id' => 'poslowie_rejestr_korzysci',
                                'label' => 'Rejestr korzyści posłów',
                            ),
                            array(
                                'id' => 'poslowie_wspolpracownicy',
                                'label' => 'Współpracownicy posłów',
                            )
                        )
                    )
                ),
            ),
            'base' => '/sejmometr'
        );

        return $menu;
    }

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/sejmometr/img/social/sejmometr.jpg');
    }

    public function okregi()
    {
        $this->set('okregi', $this->Sejmometr->okregi());
    }

    public function szukaj()
    {

        $this->API = $this->API->Dane();
        $this->dataBrowser = $this->Components->load('Dane.DataobjectsBrowser', array(
            'source' => 'app:3',
            'title' => 'Szukaj w pracach Sejmu',
            'noResultsTitle' => 'Brak wyników',
        ));

    }

    public function autorzy_projektow()
    {

        $this->API = $this->API->Sejmometr();
        $data = $this->API->autorzy_projektow();

        $this->set('data', $data);
        $this->set('_serialize', 'data');

    }

    public function zawody_poslow()
    {
        $zawody = array_fill(0, 20, array(
            'name' => 'Prawnicy',
            'percent' => 10,
            'number' => 1,
        ));

        $total = 0;
        foreach ($zawody as $z) {
            $total += $z['number'];
        }

        $chart_max_percent = 3;
        $chart_max_items = 18;
        $ppl_in_graph = 0;
        $zawody_chart = array();
        for ($i = 0; $i < $chart_max_items; $i++) {
            if ($zawody[$i]['percent'] < $chart_max_percent) {
                break;
            }

            array_push($zawody_chart, $zawody[$i]);
            $ppl_in_graph += $z['number'];
        }
        array_push($zawody_chart, array(
            'name' => 'Inne',
            'percent' => ($total - $ppl_in_graph) * 1000 / $total * 0.1,
            'number' => $total - $ppl_in_graph
        ));

        $this->set(compact('zawody_chart', 'zawody'));
    }

    public function info()
    {
        $this->set(compact('info'));
    }

    public function view()
    {

        $datasets = $this->getDatasets('sejmometr');

        $options = array(
            'searchTitle' => 'Szukaj w pracach Sejmu...',
            'autocompletion' => array(
                'dataset' => 'poslowie',
            ),
            'conditions' => array(
                'dataset' => array_keys($datasets)
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => $datasets,
                    ),
                ),
            ),
            'apps' => true,
        );

        $this->Components->load('Dane.DataBrowser', $options);
        $this->render('Dane.Elements/DataBrowser/browser-from-app');

    }

    private function klub_img_src($klub_id)
    {
        // TODO use MP\Dane\Sejm_kluby::getThumbnailSrc
        return "http://resources.sejmometr.pl/s_kluby/" . $klub_id . "_a_t.png";
    }
}
