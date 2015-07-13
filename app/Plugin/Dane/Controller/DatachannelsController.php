<?php

class DatachannelsController extends DaneAppController
{
    public $components = array('RequestHandler');

    public function index()
    {

        $q = (string)@$this->request->query['q'];

        $queryData = array(
            'includeContent' => true,
        );

        if ($q) {
            $queryData['conditions']['q'] = $q;
        }

        $channels = $this->API->getDatachannels($queryData);


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


                if (!empty($ch['dataobjects'])) {
                    $ch['Datachannel']['score'] = $ch['dataobjects'][0]->getScore();
                }

            }

            uasort($channels, array($this, 'channelsCompareMethod'));

        }


        $this->set('q', $q);
        $this->set('channels', $channels);
        $this->set('title_for_layout', 'Dane publiczne');

    }

    public function view($name = null)
    {

        $alias = (string)@$this->request->params['alias'];
        $this->dataobjectsBrowserView(array(
            'source' => 'datachannel:' . $alias,
            'showTitle' => true,
            'titleTag' => 'h1',
        ));

    }

    public function beforeRender()
    {

        $datasets = array();

        if ($this->dataBrowser) {

            $data = $this->dataBrowser->datachannel;
            $datachannel = $data['Datachannel'];
            $datasets = $data['Dataset'];

            $title_for_layout = $datachannel['name'];
            $this->set('title_for_layout', $title_for_layout);

        }

        if (count($datasets) === 1) {

            $dataset = $datasets[0];
            $url = '/dane/' . $dataset['base_alias'];
            if (!empty($this->request->query)) {
                $url .= '?' . http_build_query($this->request->query);
            }

            $this->redirect($url);
            exit();

        }


    }

    private function channelsCompareMethod($a, $b)
    {
        if ($a['Datachannel']['score'] == $b['Datachannel']['score']) {
            return 0;
        }

        return ($a['Datachannel']['score'] > $b['Datachannel']['score']) ? -1 : 1;
    }

}
