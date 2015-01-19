<?php
App::uses('CakeTime', 'Utility');

class DatasetsController extends DaneAppController
{

    public $uses = array('Dane.Dataset');

    public $components = array(
        'RequestHandler',
    );

    public function index()
    {
		
		return $this->redirect('/dane/zbiory');
        
        $datasets = $this->API->getDatasets();
        $this->set('datasets', $datasets);

        $this->set('title_for_layout', 'Zbiory danych publicznych');

    }

    public function view()
    {
				
        $alias = (string)@$this->request->params['alias'];
        $this->dataobjectsBrowserView(array(
            'source' => 'dataset:' . $alias,
            'showTitle' => true,
            'titleTag' => 'h1',
        ));

    }

    public function beforeRender()
    {

        if ($this->request->params['action'] == 'view') {

            $data = $this->dataBrowser->dataset;

            if (!$data) {
                throw new NotFoundException('Could not find that post');
            }

            $dataset = $data['Dataset'];
            $datachannel = $data['Datachannel'];

            $this->set('_APPLICATION', $data['App']);

            $this->addStatusbarCrumb(array(
                'text' => $datachannel['nazwa'],
                'href' => '/dane/kanal/' . $datachannel['slug'],
            ));


            $title_for_layout = $dataset['name'];
            $this->set('title_for_layout', $title_for_layout);

        }

    }

}