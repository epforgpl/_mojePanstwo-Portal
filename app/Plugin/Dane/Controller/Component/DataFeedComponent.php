<?php

class DataFeedComponent extends Component
{

    public $settings = array();
    public $conditions = array();
    public $order = array();
    private $Dataobject = false;
    private $controller = false;

    public function __construct($collection, $settings)
    {
        $this->settings = $settings;
    }

    public function beforeRender($controller)
    {

        $this->controller = $controller;
        $this->controller->helpers[] = 'Dane.Dataobject';

        if (is_null($this->controller->Paginator)) {
            $this->controller->Paginator = $this->controller->Components->load('Paginator');
        }

        if (isset($this->controller->request->query['q'])) {
            $this->controller->request->query['conditions']['q'] = $this->controller->request->query['q'];
        }

        $this->queryData = $this->controller->request->query;

        if (!property_exists($this->controller, 'Dataobject'))
            $this->controller->Dataobject = ClassRegistry::init('Dane.Dataobject');

        $this->controller->Paginator->settings = $this->getSettings();
        //$this->controller->Paginator->settings['order'] = 'score desc';
        // debug($this->controller->Paginator->settings); die();


        $hits = $this->controller->Paginator->paginate('Dataobject');

        $aggs = $this->controller->Dataobject->getAggs();

        $channels_data = array();
        if (
        isset($aggs['all_data']['feed_data']['feed']['channel']['buckets'])
        )
            foreach ($aggs['all_data']['feed_data']['feed']['channel']['buckets'] as $d)
                $channels_data[$d['key']] = $d['doc_count'];

        $channels = array();
        foreach ($this->controller->channels as $ch) {

            if (
                array_key_exists($ch['DatasetChannel']['channel'], $channels_data) &&
                ($doc_count = $channels_data[$ch['DatasetChannel']['channel']])
            )
                $channels[] = array_merge($ch, array(
                    'doc_count' => $doc_count,
                ));

        }

        $this->controller->channels = $channels;

        $this->controller->set('dataFeed', array(
            'hits' => $hits,
            'took' => $controller->Dataobject->getPerformance(),
            'preset' => $this->settings['preset'],
            'side' => isset($this->settings['side']) ? $this->settings['side'] : $this->controller->request->params['controller'],
            'searchTitle' => isset($this->settings['searchTitle']) ? $this->settings['searchTitle'] : false,
            'timeline' => isset($this->settings['timeline']) ? (boolean)$this->settings['timeline'] : false,
            'api_call' => $controller->Dataobject->getDataSource()->public_api_call,
            'subscribeAction' => '',
        ));

        if (
            isset($this->controller->request->params['ext']) &&
            ($this->controller->request->params['ext'] == 'html')
        ) {
            $this->controller->view = 'Dane.Dataobjects/feed-html';
            $this->controller->layout = false;
        } else {
            $this->controller->view = 'Dane.Dataobjects/feed';
        }

    }

    private function getSettings()
    {

        $conditions = $this->getSettingsForField('conditions');

        $output = array(
            'paramType' => 'querystring',
            'conditions' => $conditions,
            'feed' => $this->settings['feed']
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

            $output['aggs'] = array(
                'all_data' => array(
                    'global' => '_empty',
                    'aggs' => array(
                        'feed_data' => array(
                            'nested' => array(
                                'path' => 'feeds_channels',
                            ),
                            'aggs' => array(
                                'feed' => array(
                                    'filter' => array(
                                        'and' => array(
                                            'filters' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => $dataset,
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $object_id,
                                                    ),
                                                )
                                            ),
                                        ),
                                    ),
                                    'aggs' => array(
                                        'channel' => array(
                                            'terms' => array(
                                                'field' => 'feeds_channels.channel',
                                                'size' => 100,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            );

            // debug( $output['aggs'] ); die();

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

}