<?php

class DataFeedComponent extends Component
{

    public $settings = array();
    public $conditions = array();
    public $order = array();
    public $direction = 'desc';
    public $aggsPreset = false;
    private $Dataobject = false;
    private $controller = false;
    private $aggs_visuals_map = array();
    private $aggs_presets = array(
        'gminy' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'gminy.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy gmin',
                    'skin' => 'pie_chart',
                    'field' => 'gminy.typ_id',
                    'dictionary' => array(
                        '1' => 'Gmina miejska',
                        '2' => 'Gmina wiejska',
                        '3' => 'Gmina miejsko-wiejska',
                        '4' => 'Miasto stołeczne',
                    ),
                ),
            ),
        ),
        'powiaty' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'powiaty.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy powiatów',
                    'skin' => 'pie_chart',
                    'field' => 'powiaty.typ_id',
                    'dictionary' => array(
                        '1' => 'Powiat',
                        '2' => 'Miasto na prawach powiatu',
                        '3' => 'Miasto stołeczne',
                    ),
                ),
            ),
        ),
        'miejscowosci' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'miejscowosci.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'miejscowosci_typy.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy miejscowości',
                    'skin' => 'pie_chart',
                    'field' => 'miejscowosci.typ_id'
                ),
            ),
        ),
        'twitter_accounts' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'twitter_accounts.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy kont',
                    'skin' => 'pie_chart',
                    'field' => 'twitter_accounts.typ_id',
                    'dictionary' => array(
                        '1' => 'Posłowie',
                        '2' => 'Komentatorzy',
                        '3' => 'Urzędy',
                        '4' => 'Rząd',
                        '5' => 'Rzecznik prasowy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partia polityczna',
                        '9' => 'NGO',
                    ),
                ),
            ),
        ),
        'twitter' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'twitter_accounts.typ_id',
                    'exclude' => array(
                        'pattern' => '(0|)'
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy kont',
                    'skin' => 'pie_chart',
                    'field' => 'twitter_accounts.typ_id',
                    'dictionary' => array(
                        '1' => 'Posłowie',
                        '2' => 'Komentatorzy',
                        '3' => 'Urzędy',
                        '4' => 'Rząd',
                        '5' => 'Rzecznik prasowy',
                        '6' => 'Media',
                        '7' => 'Politycy',
                        '8' => 'Partia polityczna',
                        '9' => 'NGO',
                    ),
                ),
            ),
            /*
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba tweetów w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            */
        ),
        'rady_druki' => array(
            'autor_id' => array(
                'terms' => array(
                    'field' => 'rady_druki.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.rady_druki.autor_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy projektów',
                    'skin' => 'pie_chart',
                    'field' => 'rady_druki.autor_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba druków w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'sejm_interpelacje' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba interpelacji w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'krakow_posiedzenia' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba posiedzeń w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'prawo_lokalne' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba uchwał w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'krakow_komisje_posiedzenia' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba posiedzeń w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'radni_dzielnic' => array(
            'dzielnice' => array(
                'terms' => array(
                    'field' => 'radni_dzielnic.dzielnica_id',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'dzielnice.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Dzielnice',
                    'skin' => 'pie_chart',
                    'field' => 'radni_dzielnic.dzielnica_id'
                ),
            ),
        ),
        'krakow_dzielnice_uchwaly' => array(
            'dzielnice' => array(
                'terms' => array(
                    'field' => 'krakow_dzielnice_uchwaly.dzielnica_id',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'dzielnice.nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Dzielnice',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_dzielnice_uchwaly.dzielnica_id'
                ),
            ),
        ),
        'krakow_zarzadzenia' => array(
            'realizacja' => array(
                'terms' => array(
                    'field' => 'krakow_zarzadzenia.realizacja_str',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_zarzadzenia.realizacja_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Statusy',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_zarzadzenia.realizacja_str'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba zarządzeń w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            'status' => array(
                'terms' => array(
                    'field' => 'krakow_zarzadzenia.status_str',
                    'exclude' => array(
                        'pattern' => ''
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krakow_zarzadzenia.status_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Statusy',
                    'skin' => 'pie_chart',
                    'field' => 'krakow_zarzadzenia.status_str'
                ),
            ),

        ),
        'prawo' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'prawo.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.typ_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy aktów prawnych',
                    'skin' => 'pie_chart',
                    'field' => 'prawo.typ_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
            'autor_id' => array(
                'terms' => array(
                    'field' => 'prawo.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.autor_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy aktów prawnych',
                    'skin' => 'columns_horizontal',
                    'field' => 'prawo.autor_id'
                ),
            ),
        ),
        'prawo_urzedowe' => array(
            /*
            'typ_id' => array(
                'terms' => array(
                    'field' => 'prawo.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.typ_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy aktów prawnych',
                    'skin' => 'pie_chart',
                ),
            ),
            */
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba aktów prawnych w czasie',
                    'skin' => 'date_histogram',
                ),
            ),
            /*
            'autor_id' => array(
                'terms' => array(
                    'field' => 'prawo.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.autor_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy aktów prawnych',
                    'skin' => 'columns_horizontal',
                ),
            ),
            */
        ),
        'zamowienia_publiczne' => array(
            'wartosc_cena' => array(
                'sum' => array(
                    'field' => 'zamowienia_publiczne.wartosc_cena',
                ),
                'visual' => array(
                    'label' => 'Wartość zamówień',
                    'skin' => 'numeric',
                    'field' => 'zamowienia_publiczne.wartosc_cena',
                    'currency' => 'pln'
                ),
            ),
            'tryb_id' => array(
                'terms' => array(
                    'field' => 'zamowienia_publiczne.tryb_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.zamowienia_publiczne_tryby.nazwa',
                        ),
                    ),
                    'wartosc_cena' => array(
                        'sum' => array(
                            'field' => 'zamowienia_publiczne.wartosc_cena',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Tryby zamówień',
                    'skin' => 'zamowienia_publiczne/pie_chart',
                    'field' => 'zamowienia_publiczne.tryb_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba zamówień publicznych w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'krs_osoby' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'krs_osoby.plec',
                    'include' => array(
                        'pattern' => '(K|M)'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'krs_osoby.plec',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Płeć',
                    'skin' => 'pie_chart',
                    'field' => 'krs_osoby.plec',
                )
            )
        ),
        'krs_podmioty' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'krs_podmioty.forma_prawna_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.krs_podmioty.forma_prawna_str',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Formy prawne organizacji',
                    'skin' => 'pie_chart',
                    'field' => 'krs_podmioty.forma_prawna_id',
                ),
            ),
            'kapitalizacja' => array(
                'range' => array(
                    'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
                    'ranges' => array(
                        array('from' => 1, 'to' => 10000),
                        array('from' => 10000, 'to' => 100000),
                        array('from' => 100000, 'to' => 1000000),
                        array('from' => 1000000, 'to' => 10000000),
                        array('from' => 10000000),
                    ),
                ),
                'visual' => array(
                    'label' => 'Kapitalizacja spółek',
                    'skin' => 'krs/kapitalizacja',
                    'field' => 'krs_podmioty.wartosc_kapital_zakladowy',
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Nowe organizacje w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date',
                ),
            ),
            /*
            'autor_id' => array(
                'terms' => array(
                    'field' => 'prawo.autor_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.prawo.autor_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Autorzy aktów prawnych',
                    'skin' => 'columns_horizontal',
                ),
            ),
            */
        ),
        'dotacje_ue' => array(
            'date' => array(
                'date_histogram' => array(
                    'field' => 'date',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba udzielonych dotacji w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'date'
                ),
            ),
        ),
        'sejm_druki' => array(
            'typ_id' => array(
                'terms' => array(
                    'field' => 'sejm_druki.typ_id',
                    'exclude' => array(
                        'pattern' => '0'
                    ),
                ),
                'aggs' => array(
                    'label' => array(
                        'terms' => array(
                            'field' => 'data.sejm_druki.druk_typ_nazwa',
                        ),
                    ),
                ),
                'visual' => array(
                    'label' => 'Typy druków',
                    'skin' => 'pie_chart',
                    'field' => 'sejm_druki.typ_id'
                ),
            ),
            'date' => array(
                'date_histogram' => array(
                    'field' => 'sejm_druki.data',
                    'interval' => 'year',
                    'format' => 'yyyy-MM-dd',
                ),
                'visual' => array(
                    'label' => 'Liczba druków w czasie',
                    'skin' => 'date_histogram',
                    'field' => 'sejm_druki.data'
                ),
            ),
        ),
    );

    public function __construct($collection, $settings)
    {
        $this->settings = $settings;
    }

    public function beforeRender($controller)
    {

        $this->controller = $controller;

        if (
            $controller->request->is('post') &&
            ($parts = explode('/', $this->settings['feed'])) &&
            (count($parts) >= 2) &&
            ($dataset = $parts[0]) &&
            ($object_id = $parts[1])
        ) {


            $data = array(
                'dataset' => $dataset,
                'object_id' => $object_id,
            );

            if (isset($this->controller->request->query['q']) && $this->controller->request->query['q'])
                $data['q'] = $this->controller->request->query['q'];

            if (isset($this->controller->request->query['channel']) && $this->controller->request->query['channel'])
                $data['channel'] = $this->controller->request->query['channel'];

            if (isset($this->controller->request->query['conditions']) && $this->controller->request->query['conditions'])
                $data['conditions'] = $this->controller->request->query['conditions'];

            $this->controller->loadModel('Dane.Subscription');
            $this->controller->Subscription->create();

            if ($res = $this->controller->Subscription->save($data)) {

                $this->controller->Session->write('Powiadomienia.transfer_anonymous', true);
                // $this->Session->setFlash(__('Dodano subskrybcję'), null, array('class'=>'alert-success'));
                return $this->controller->redirect($res['url']);

            }

            return $this->controller->redirect($this->controller->referer());


        } else {

            $this->controller->helpers[] = 'Dane.Dataobject';

            if (is_null($this->controller->Paginator)) {
                $this->controller->Paginator = $this->controller->Components->load('Paginator');
            }

            if (isset($this->controller->request->query['q'])) {
                $this->controller->request->query['conditions']['q'] = $this->controller->request->query['q'];
            }

            if (isset($this->settings['direction']))
                $this->direction = $this->settings['direction'];

            $this->queryData = $this->controller->request->query;

            if (!property_exists($this->controller, 'Dataobject'))
                $this->controller->Dataobject = ClassRegistry::init('Dane.Dataobject');


            if ($channels = $this->controller->channels) {

                if (isset($this->controller->request->query['channel'])) {

                    for ($i = 1; $i < count($channels); $i++)
                        if (
                            isset($channels[$i]['DatasetChannel']['channel']) &&
                            ($this->controller->request->query['channel'] == $channels[$i]['DatasetChannel']['channel'])
                        ) {

                            // PREPARE AGGS DATA

                            if (
                                $channels[$i]['DatasetChannel']['subject_dataset'] &&
                                array_key_exists($channels[$i]['DatasetChannel']['subject_dataset'], $this->aggs_presets)
                            )
                                $this->settings['aggs'] = $this->aggs_presets[$channels[$i]['DatasetChannel']['subject_dataset']];


                            if (isset($this->settings['aggs'])) {
                                foreach ($this->settings['aggs'] as $key => $value) {
                                    foreach ($value as $keyM => $valueM) {
                                        if ($keyM === 'visual') {
                                            $this->aggs_visuals_map[$key] = $valueM;
                                            unset($this->settings['aggs'][$key][$keyM]);
                                        }
                                    }
                                }
                            }


                            $this->aggsPreset = $channels[$i]['DatasetChannel']['subject_dataset'];
                            $channels[$i]['active'] = true;

                        }

                } else $channels[0]['active'] = true;

            }

            $this->controller->Paginator->settings = $this->getSettings();
            $this->controller->Paginator->settings['order'] = 'date ' . $this->direction;


            // debug( $this->controller->channels );
            // debug($this->controller->Paginator->settings); die();
            // debug( $this->aggsPreset );

            $hits = $this->controller->Paginator->paginate('Dataobject');

            $aggs = $this->controller->Dataobject->getAggs();

            $channels_data = array();
            if (
            isset($aggs['_channels']['feed_data']['feed']['channel']['buckets'])
            )
                foreach ($aggs['_channels']['feed_data']['feed']['channel']['buckets'] as $d)
                    $channels_data[$d['key']] = $d['doc_count'];

            $channels = array();

            if (!empty($this->controller->channels)) {
                foreach ($this->controller->channels as $ch) {

                    if (
                        array_key_exists($ch['DatasetChannel']['channel'], $channels_data) &&
                        ($doc_count = $channels_data[$ch['DatasetChannel']['channel']])
                    ) {

                        if (
                            isset($this->controller->request->query['channel']) &&
                            ($this->controller->request->query['channel'] == $ch['DatasetChannel']['channel'])
                        )
                            $ch['active'] = true;

                        $channels[] = array_merge($ch, array(
                            'doc_count' => $doc_count,
                        ));

                    }

                }
            }

            $dataFeed = array(
                'hits' => $hits,
                'took' => $controller->Dataobject->getPerformance(),
                'preset' => $this->settings['preset'],
                'side' => isset($this->settings['side']) ? $this->settings['side'] : $this->controller->request->params['controller'],
                'searchTitle' => isset($this->settings['searchTitle']) ? strip_tags($this->settings['searchTitle']) : false,
                'timeline' => isset($this->settings['timeline']) ? (boolean)$this->settings['timeline'] : false,
                'api_call' => $this->controller->Dataobject->getDataSource()->public_api_call,
                'subscribeAction' => '',
                'aggs' => $controller->Dataobject->getAggs(),
                'aggs_visuals_map' => $this->prepareRequests($this->aggs_visuals_map, $controller),
                'mode' => isset($this->settings['mode']) ? $this->settings['mode'] : 'full',
            );
                        
            $this->controller->set('dataFeed', $dataFeed);
            $this->controller->feed = $dataFeed;

            if (!empty($channels)) {
                $channels = array_merge(array(array(
                    'DatasetChannel' => array(
                        'icon' => 'all',
                        'title' => 'Wszystkie dane',
                    ),
                )), $channels);

                if (
                    !isset($this->controller->request->query['channel']) ||
                    !$this->controller->request->query['channel']
                )
                    $channels[0]['active'] = true;

            }

            $this->controller->set('object_channels', $channels);

            if (isset($this->settings['object_subscriptions']))
                $this->controller->set('object_subscriptions', $this->settings['object_subscriptions']);

            if (
                isset($this->controller->request->params['ext']) &&
                ($this->controller->request->params['ext'] == 'html')
            ) {
                $this->controller->view = 'Dane.Dataobjects/feed-html';
                $this->controller->layout = false;
            } else {

                if (!isset($this->settings['mode']) || ($this->settings['mode'] != 'min'))
                    $this->controller->view = 'Dane.Dataobjects/feed';

            }

        }

    }

    private function getSettings()
    {

        $conditions = $this->getSettingsForField('conditions');

        $output = array(
            'paramType' => 'querystring',
            'conditions' => $conditions,
            'feed' => $this->settings['feed'],
            'aggs' => $this->getSettingsForField('aggs'),
        );

        if (isset($this->settings['channel']))
            $output['channel'] = $this->settings['channel'];

        if (isset($this->settings['context']))
            $output['context'] = $this->settings['context'];

        if (isset($conditions['q']))
            $output['highlight'] = true;

        if (isset($this->controller->request->query['channel']))
            $output['channel'] = $this->controller->request->query['channel'];

        if (
            $this->controller->loadChannels &&
            ($parts = explode('/', $this->settings['feed'])) &&
            (count($parts) >= 2) &&
            (list($dataset, $object_id) = $parts)
        ) {

            $output['aggs']['_channels'] = true;

        }

        return $output;

    }

    private function getSettingsForField($field)
    {

        $params = isset($this->queryData[$field]) ? $this->queryData[$field] : array();

        if (isset($this->settings[$field])) {
            if (is_array($this->settings[$field]))
                $params = array_merge($params, $this->settings[$field]);
            else
                $params = $this->settings[$field];
        }

        return $params;

    }

    private function prepareRequests($maps, $controller)
    {
        $query = $controller->request->query;

        foreach ($maps as $i => $map) {
            // Anulowanie np. wybranego typu
            $cancelQuery = $query;
            if (isset($cancelQuery['conditions'][$map['field']]))
                unset($cancelQuery['conditions'][$map['field']]);
            if (isset($cancelQuery['page']))
                unset($cancelQuery['page']);
            if (isset($cancelQuery['conditions']['q']))
                unset($cancelQuery['conditions']['q']);
            $maps[$i]['cancelRequest'] = $controller->here . '?' . http_build_query($cancelQuery);

            // Wybieranie np. danego typu
            // Nie znamy jeszcze id dlatego na końcu zostawiamy `=` np.
            // http://.../?..&conditions[type.id]=
            $chooseQuery = $query;
            if (isset($cancelQuery['page']))
                unset($cancelQuery['page']);
            $maps[$i]['chooseRequest'] =
                $controller->here . '?' . http_build_query($cancelQuery) .
                '&conditions[' . $map['field'] . ']=';
        }

        return $maps;
    }

}
