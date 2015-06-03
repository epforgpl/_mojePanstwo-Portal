<?php

App::uses('ApplicationsController', 'Controller');

class SejmometrController extends ApplicationsController
{

    public $settings = array(
        'id' => 'sejmometr',
    );

    public function getMenu()
    {
        $menu = array(
            'items' => array(
                array(
                    'label' => 'Posłowie',
                ),
                array(
                    'id' => 'sejm_posiedzenia',
                    'label' => 'Posiedzenia',
                ),
                array(
                    'id' => '#',
                    'label' => 'Więcej',
                    'dropdown' => array(
                        'items' => array(
                            array(
                                'id' => 'sejm_debaty',
                                'label' => 'Debaty',
                            ),
                            array(
                                'id' => 'sejm_dezyderaty',
                                'label' => 'Dezyderaty komisji',
                            ),
                            array(
                                'id' => 'sejm_druki',
                                'label' => 'Druki',
                            ),
                            array(
                                'id' => 'sejm_glosowania',
                                'label' => 'Głosowania',
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
                                'id' => 'sejm_komunikaty',
                                'label' => 'Komunikaty Kancelarii Sejmu',
                            ),
                            array(
                                'id' => 'sejm_posiedzenia_punkty',
                                'label' => 'Punkty porządku dziennego',
                            ),
                            array(
                                'id' => 'sejm_wystapienia',
                                'label' => 'Wystąpienia posłów',
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
                                'id' => 'poslowie_oswiadczenia_majatkowe',
                                'label' => 'Oświadczenia majątkowe',
                            ),
                            array(
                                'id' => 'poslowie_rejestr_korzysci',
                                'label' => 'Rejestr korzyści',
                            ),
                            array(
                                'id' => 'poslowie_wspolpracownicy',
                                'label' => 'Współpracownicy',
                            )
                        )
                    )
                ),
            ),
            'base' => 'sejmometr'
        );

        return $menu;
    }

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/sejmometr/img/social/sejmometr.jpg');
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

        $this->menu_selected = 'poslowie';
        $this->loadDatasetBrowser('poslowie');

    }

    private function klub_img_src($klub_id)
    {
        // TODO use MP\Dane\Sejm_kluby::getThumbnailSrc
        return "http://resources.sejmometr.pl/s_kluby/" . $klub_id . "_a_t.png";
    }
}