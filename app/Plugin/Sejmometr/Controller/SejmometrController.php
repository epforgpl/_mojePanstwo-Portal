<?php

App::uses('ApplicationsController', 'Controller');
class SejmometrController extends ApplicationsController
{

    public $settings = array(
		'menu' => array(
			array(
				'id' => '',
				'label' => 'Start',
			),
			array(
				'id' => 'poslowie',
				'label' => 'Posłowie',
			)
		),
		'title' => 'Sejmometr',
		'subtitle' => 'Dane o pracy Sejmu i posłów',
		'headerImg' => 'sejmometr',
	);

	
	public function poslowie()
    {
        
        $this->loadDatasetBrowser('poslowie');
                
    }
	
    public function index()
    {
        $api = $this->API->Sejmometr();
        $stats = $api->getStats();

        $display_callbacks = array(
            'liczba_wypowiedzi' => function ($object) {
                return pl_dopelniacz($object->getData('liczba_wypowiedzi'), 'wystąpienie', 'wystąpienia', 'wystąpień');
            },
            'frekwencja' => function ($object) {
                return '<strong>' . $object->getData('frekwencja') . '%</strong>';
            },
            'zbuntowanie' => function ($object) {
                return '<strong>' . $object->getData('zbuntowanie') . '%</strong>';
            },
            'liczba_interpelacji' => function ($object) {
                return pl_dopelniacz($object->getData('liczba_interpelacji'), 'interpelacja', 'interpelacje', 'interpelacji');
            },
            'uchwaly_komisji_etyki' => function ($object) {
                return pl_dopelniacz($object->getData('liczba_uchwal_komisji_etyki'), 'uchwała', 'uchwały', 'uchwał');
            },
            'przeloty' => function ($object) {
                return pl_dopelniacz($object->getData('liczba_przelotow'), 'przelot', 'przeloty', 'przelotów');
            },
            'przejazdy' => function ($object) {
                return pl_dopelniacz($object->getData('liczba_przejazdow'), 'przejazd', 'przejazdy', 'przejazdów');
            },
            'kwatery_prywatne' => function ($object) {
                return '<strong>' . $object->getData('wartosc_refundacja_kwater_pln') . '</strong>';
            },
            'uposazenia' => function ($object) {
                return '<strong>' . $object->getData('wartosc_uposazenia_pln') . '</strong>';
            },
        );

        // ranking poslow
        $dane = $this->API->Dane();
        foreach ($stats['poslowie'] as $section_name => $sekcja) {
            $data[$section_name] = array(
                'items' => array(),
                'order' => $sekcja['order']
            );

            foreach ($sekcja['dataobjects'] as $object_plain) {
                $object = $dane->interpretateObject($object_plain);

                $data[$section_name]['items'][] = array(
                    'imie' => $object->getData('imie_pierwsze'),
                    'nazwisko' => $object->getData('nazwisko'),
                    'url' => $object->getUrl(),
                    'klub_id' => $object->getData('klub_id'),
                    'klub_img_src' => $this->klub_img_src($object->getData('klub_id')),
                    'posel_img_src' => $object->getThumbnailUrl(),
                    'klub' => $object->getData('sejm_kluby.nazwa'),
                    'display' => $display_callbacks[$section_name]($object),
                );
            }
        }

        // rankingi agregowane
        $data['zawody'] = $stats['zawody'];

        $pp_totals = $stats['poslanki_poslowie']['*'];
        $data['poslanki_poslowie'] = array(
            array(
                'title' => 'Sejm RP',
                'img_src' => $this->klub_img_src('sejm'),
                'setup' => array(
                    array('Kobiety', round($pp_totals['stats']['K'] * 100 / $pp_totals['total'])),
                    array('Mężczyźni', round($pp_totals['stats']['M'] * 100 / $pp_totals['total']))
                )
            )
        );
        foreach ($stats['poslanki_poslowie']['kluby'] as $klub) {

            $k = isset($klub['stats']['K']) ? round($klub['stats']['K'] * 100 / $klub['total']) : 0;
            $m = isset($klub['stats']['M']) ? round($klub['stats']['M'] * 100 / $klub['total']) : 0;

            $data['poslanki_poslowie'][] = array(
                'title' => $klub['nazwa'],
                'img_src' => $this->klub_img_src($klub['klub_id']),
                'setup' => array(
                    array('Kobiety', $k),
                    array('Mężczyźni', $m),
                )
            );
        }

        $poslowie_url = Router::url(array('plugin' => 'dane', 'controller' => 'poslowie'));
        $this->set('poslowie_url', $poslowie_url);

        $this->set($data);
    }

    private function klub_img_src($klub_id)
    {
        // TODO use MP\Dane\Sejm_kluby::getThumbnailSrc
        return "http://resources.sejmometr.pl/s_kluby/" . $klub_id . "_a_t.png";
    }

    public function detailBlock()
    {

        $id = $this->request->query['id'];
        if (!$id) {
            return false;
        }

        $view = new View($this, false);

        $element = 'list_inner';
        if ($id == 'zawody') {
            $element = 'zawody';
        }

        $items = $this->poslowie($id);

        $html = $view->element('Sejmometr.' . $element, array(
            'items' => $items,
        ));

        $this->set('id', $id);
        $this->set('html', $html);
        $this->set('_serialize', array('html', 'id'));

    }

    public function posiedzenia_timeline()
    {

        $output = array(
            'timeline' => array(
                'headline' => 'Posiedzenia Sejmu RP',
                'type' => 'default',
                'date' => array(),
            ),
        );


        $API = $this->API->Dane();
        $API->searchDataset('sejm_posiedzenia', array(
            'order' => 'data_stop desc',
            'limit' => 100,
        ));

        foreach ($API->getObjects() as $object) {

            if ($object->getData('numer') == '0') {
                continue;
            }

            $startDate = $object->getData('data_start');
            $dateParts = explode('-', $startDate);
            $startDate = $dateParts[0] . ',' . $dateParts[1] . ',' . $dateParts[2];

            $stopDate = $object->getData('data_stop');
            $dateParts = explode('-', $stopDate);
            $stopDate = $dateParts[0] . ',' . $dateParts[1] . ',' . $dateParts[2];

            if (!$object->getData('komunikat_id')) {
                $asset = array(
                    'media' => '/Sejmometr/img/default.jpg',
                    'thumbnail' => '/Sejmometr/img/default-thumbnail.jpg',
                    'credit' => '',
                );
            } else {
                $asset = array(
                    'media' => 'http://resources.sejmometr.pl/sejm_komunikaty/img/' . $object->getData('komunikat_id') . '-0.jpg',
                    'thumbnail' => 'http://resources.sejmometr.pl/sejm_komunikaty/img/' . $object->getData('komunikat_id') . '-1.jpg',
                    'credit' => '® Kancelaria Sejmu',
                );
            }

            $output['timeline']['date'][] = array(
                'startDate' => $startDate,
                'endDate' => $stopDate,
                'headline' => '<a href="/dane/sejm_posiedzenia/' . $object->getData('id') . '">#' . $object->getData('numer') . '</a>',
                'text' => '<div class="slide_content" data-posiedzenie_id="' . $object->getId() . '">Ładowanie...</div>',
                'classname' => 'klasa',
                'asset' => $asset,
            );

        }

        $this->set('data', $output);
        $this->set('_serialize', 'data');

    }

    public function posiedzenie()
    {

        $id = (int)$this->request->params['id'];
        if (!$id) {
            return false;
        }

        $API = $this->API->Dane();
        $object = $API->getObject('sejm_posiedzenia', $id);


        $projekty = $object->loadLayer('projekty');

        $view = new View($this, false);
        $html = $view->element('Dane.sejmposiedzenie-projekty-cont', array(
            'projekty' => $projekty,
        ));


        $this->set('id', $id);
        $this->set('data', $object->getData());
        $this->set('projekty_html', $html);
        $this->set('_serialize', array('id', 'data', 'projekty_html'));

    }

    public function prace()
    {

        $q = (string)@$this->request->query['q'];

        $queryData = array(
            'includeContent' => true,
        );

        if ($q) {
            $queryData['conditions']['q'] = $q;
        }

        $API = $this->API->Sejmometr();
        $data = $API->getLatestData($queryData);

        $chapters = array(
            array(
                'id' => 'projekty_ustaw',
                'title' => 'Projekty ustaw',
            ),
            array(
                'id' => 'projekty_uchwal',
                'title' => 'Projekty uchwał',
            ),
            array(
                'id' => 'sprawozdania_kontrolne',
                'title' => 'Sprawozdania kontrolne',
            ),
            array(
                'id' => 'umowy',
                'title' => 'Umowy międzynarodowe',
            ),
            array(
                'id' => 'powolania_odwolania',
                'title' => 'Powołania i odwołania ze stanowisk',
            ),
            array(
                'id' => 'sklady_komisji',
                'title' => 'Zmiany w składach komisji sejmowych',
            ),
            array(
                'id' => 'referenda',
                'title' => 'Wnioski o referenda',
            ),
            array(
                'id' => 'inne',
                'title' => 'Inne projekty',
            ),
        );

        foreach ($chapters as &$chapter) {
            $chapter['search'] = $data[$chapter['id']];
        }


        $this->set('chapters', $chapters);


        /*
        if ($q && !empty($channels)) {
            foreach ($channels as &$ch) {

                $datachannel_count = 0;

                $facets = $ch['facets'];
                if (!empty($facets)) {

                    $facets = array_column($facets, 'params', 'field');

                    if (array_key_exists('dataset', $facets) &&
                        isset($facets['dataset']['options']) &&
                        !empty($facets['dataset']['options'])
                    ) {

                        $datasets = array_column($facets['dataset']['options'], 'count', 'id');

                        foreach ($ch['Dataset'] as &$d) {

                            if (array_key_exists($d['alias'], $datasets)) {
                                $d['count'] = $datasets[$d['alias']];
                                $datachannel_count += $d['count'];
                            } else {
                                $d['count'] = 0;
                            }

                        }

                    }
                }

                $ch['Datachannel']['score'] = 0;
                $ch['Datachannel']['count'] = $datachannel_count;


                if (!empty($ch['dataobjects']))
                    $ch['Datachannel']['score'] = $ch['dataobjects'][0]->getScore();

            }

            uasort($channels, array($this, 'channelsCompareMethod'));

        }


        $this->set('q', $q);
        $this->set('channels', $channels);
        $this->set('title_for_layout', 'Dane publiczne');
        */


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

    public function posiedzenia()
    {


    }
}