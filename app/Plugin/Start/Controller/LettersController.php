<?php

App::uses('StartAppController', 'Start.Controller');

class LettersController extends StartAppController
{

    public $chapter_selected = 'letters';
	
    public $settings = array(
        'id' => '',
        'title' => 'Pisma',
        'subtitle' => 'Wysyłaj pisma urzędowe do instytucje publicznych',
    );
    public $helpers = array('Form');
    public $uses = array(
        'Pisma.Pismo',
        'Sejmometr.Sejmometr',
        'Start.LetterResponse',
        'Start.Letter',
        'Dane.ObjectUsersManagement');
    public $components = array('RequestHandler', 'S3', 'Start.LettersResponseFile');
    public $appSelected = 'pisma';
    private $aggs_dict = array(
        'access' => array(
            'private' => 'Prywatne',
            'public' => 'Publiczne',
        ),
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function prepareMetaTags()
    {
        parent::prepareMetaTags();
        $this->setMeta('og:image', FULL_BASE_URL . '/moje-pisma/img/social/letters.jpg');
    }

    public function view($id, $slug = '')
    {
        $pismo = $this->load($id);
        $this->set('responses', $this->LetterResponse->getByLetter($id));
    }
    
    public function anonymize($id, $slug = '')
    {
        $pismo = $this->load($id);
    }

    private function load($id, $params = array())
    {

        try {

            $pismo = $this->Pismo->documents_read($id, $params);
            
            $is_owner = false;

            if (
                (
                    ($this->Auth->user()) &&
                    ($pismo['from_user_type'] == 'account') &&
                    ($this->Auth->user('id') == $pismo['from_user_id'])
                ) || (
                    (!$this->Auth->user()) &&
                    ($pismo['from_user_type'] == 'anonymous') &&
                    (session_id() == $pismo['from_user_id'])
                )
            )
                $is_owner = true;

            $pismo['is_owner'] = $is_owner;

            $this->title = $pismo['name'];
            $this->set('pismo', $pismo);

            return $pismo;

        } catch (Exception $e) {

            $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
            $this->render('not_found');
            return false;
        }
    }

    public function edit($id, $slug = '')
    {
        if ($pismo = $this->load($id, array(
	        'inputs' => true,
	        'template' => true,
        ))) {
			
			// debug($pismo);
				
            if (!$pismo['is_owner'])
                return $this->redirect($this->referer());
                
        } else {

            $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
            $this->render('not_found');
        }
    }

    public function response($letter_id, $slug, $response_id) {
        if($pismo = $this->load($letter_id)) {
            if($response = $this->LetterResponse->get($letter_id, $response_id)) {
                $this->set('response', $response);
                $this->title = 'Odpowiedź ' . $response['Response']['title'];
            } else {
                throw new NotFoundException;
            }

        } else {
            $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
            $this->render('not_found');
        }
    }

    public function responses($id, $slug = '')
    {
        if($pismo = $this->load($id))
        {
            if(!$pismo['is_owner']) {
                $this->redirect($this->referer());
                return;
            }

            /* delete unsaved files from s3 */
            if(!isset($this->request->params['form']['file']) && !isset($this->request->data['name'])) {
                $this->LettersResponseFile->delete();
            }

            /* single file upload to s3, push file name to session */
            if(isset($this->request->params['form']['file'])) {
                // upload file to already existing response
                if(isset($this->request->params['response_id'])) {
                    $response_id = (int) $this->request->params['response_id'];
                    $this->LettersResponseFile->setName('letters_response_files_' . $response_id);
                    $response = $this->LettersResponseFile->save(
                        $this->request->params['form']['file']
                    );
                // upload file to new response
                } else {
                    $response = $this->LettersResponseFile->save(
                        $this->request->params['form']['file']
                    );
                }

                $this->set('response', $response);
                $this->set('_serialize', 'response');
            }

            /* response form post save */
            if(isset($this->request->data['name'])) {
                // update already existing response
                if(isset($this->request->params['response_id'])) {
                    $data = $this->request->data;
                    $response_id = (int) $this->request->params['response_id'];

                    $this->LettersResponseFile->setName('letters_response_files_' . $response_id);
                    $data['session_files'] = $this->LettersResponseFile->getFiles();

                    $response = $this->LetterResponse->update($id, $response_id, $data);
                    if($response) {
                        $this->LettersResponseFile->clear();
                        $this->Session->setFlash('Odpowiedź została poprawnie zaktualizwana');
                    } else {
                        $this->Session->setFlash('Wystąpił błąd podczas aktualizacji odpowiedzi');
                    }

                    $this->set('response', $response);
                    $this->set('_serialize', 'response');
                // create new response
                } else {
                    $res = $this->LetterResponse->save(
                        $id,
                        array_merge($this->request->data, array(
                            'files' => $this->LettersResponseFile->getFiles()
                        ))
                    );

                    if ($res) {
                        $this->LettersResponseFile->clear();
                        $this->Session->setFlash('Odpowiedź została poprawnie dodana');
                    } else {
                        $this->Session->setFlash('Wystąpił błąd podczas dodawania odpowiedzi');
                    }

                    $this->redirect($this->referer());
                }
            }

            $this->title = $this->title . ' - Odpowiedzi';

        } else {
            $this->set('title_for_layout', 'Pismo nie istnieje lub nie masz do niego dostępu');
            $this->render('not_found');
        }
    }

    public function share($id, $slug = '')
    {
        $this->load($id);
    }

    public function html($id, $slug = '')
    {

        $pismo = $this->load($id);

        $view = new View($this, false);
        $html = $view->element('html', array(
            'pismo' => $pismo,
        ));
        echo $html;
        die();
    }

    public function put($id, $slug = false)
    {

        $params = array();
        if (!$this->Auth->user())
            $params['anonymous_user_id'] = session_id();

        $status = false;

        if (isset($this->request->data['name'])) {

            $params['name'] = $this->request->data['name'];
            $status = $this->Pismo->documents_partial_update($id, $params);

        }

        $this->set('status', $status);
        $this->set('_serialize', 'status');

    }

    public function setDocumentName($id) {
        $this->set(
            'status',
            $this->Pismo->setDocumentName($id, $this->request->data['nazwa'])
        );
        $this->set('_serialize', 'status');
    }

    public function post($id = false, $slug = false)
    {

        if ($id) {

            $redirect = 'object';
			
            if (isset($this->request->data['edit_from_inputs'])) {

                $this->Pismo->documents_update($id, $this->request->data);
            
            } elseif (isset($this->request->data['delete'])) {

                $this->Pismo->documents_delete($id);
                $redirect = 'my';

            } elseif (isset($this->request->data['save'])) {

                $doc = $this->request->data;
                unset($doc['save']);

                $this->Pismo->documents_update($id, $doc);

            } elseif (isset($this->request->data['send'])) {

                if ($this->Pismo->documents_send($id, $this->request->data)) {
                    $this->Session->setFlash('Twoje pismo zostało wysłane!', null, array('class' => 'alert-success'));
                }

            } elseif (isset($this->request->data['access'])) {

                $this->Pismo->documents_change_access($id, $this->request->data['access']);

            }

            if ($redirect == 'object') {

                $url = '/moje-pisma/' . $id;
                if ($slug)
                    $url .= ',' . $slug;

                return $this->redirect($url);

            } elseif ($redirect == 'my') {

                return $this->redirect('/moje-pisma');

            }

        } elseif (
            isset($this->request->data['delete']) 
        ) {

            $this->Pismo->documents_delete($this->request->data['id']);
            return $this->redirect('/moje-pisma');

        }

    }

    public function create()
    {
        $map = array('adresat_id', 'szablon_id', 'object_id');
        $pismo = array();
        foreach($map as $field)
            if(isset($this->request->data[$field]))
                $pismo[$field] = $this->request->data[$field];

        if (!$this->Auth->user())
            $this->Session->write('Pisma.transfer_anonymous', true);

        $status = $this->Pismo->documents_create($pismo);

        if (isset($status['error']) && $status['error']) {

        } else {
            $this->redirect($status['url'] . '/edit');
        }

    }

    public function home()
    {
        $query = array_merge($this->request->query, $this->request->params);

        $pismo = array(
            'szablon_id' => isset($query['szablon_id']) ? $query['szablon_id'] : false,
            'adresat_id' => isset($query['adresat_id']) ? $query['adresat_id'] : false,
        );

        if($this->Auth->user())
            $this->set('objects', $this->ObjectUsersManagement->getUserObjects());
		
		$szablony = $this->Pismo->templates_grouped();
		
        $this->set('pismo_init', $pismo);
        $this->set('szablony', $szablony);
        $this->title = 'Nowe pismo';
    }
	
	/*
    public function my()
    {
        $q = false;

        $params = array(
            'page' => (
                isset($this->request->query['page']) &&
                is_numeric($this->request->query['page'])
            ) ? $this->request->query['page'] : 1,
        );

        if (
            isset($this->request->query['q']) &&
            $this->request->query['q']
        )
            $q = $params['q'] = $this->request->query['q'];

        if ($user = $this->Auth->user()) {

        } else {

            $params['anonymous_user_id'] = session_id();

        }

        $filters_selected = array();
        $allowed_vars = array('template', 'to', 'sent', 'access');

        foreach ($allowed_vars as $var) {
            if (isset($this->request->query[$var])) {
                $filters_selected[$var] = true;
                $params['conditions'][$var] = $this->request->query[$var];
            }
        }

        $search = $this->Pismo->documents_search($params);
        $performance = $search['performance'];
        $pagination = $search['pagination'];
        $items = $search['items'];
        $_aggs = $search['aggs']['all'];

        $aggs = array();

        foreach ($_aggs['access']['filtered']['buckets'] as $bucket) {
            $aggs['access']['buckets'][] = array(
                'key' => $bucket['key'],
                'label' => $this->aggs_dict['access'][$bucket['key']],
                'count' => $bucket['doc_count'],
            );
        }

        foreach ($_aggs['to_dataset']['filtered']['buckets'] as $dataset_bucket) {
            foreach ($dataset_bucket['to_id']['buckets'] as $id_bucket) {
                $aggs['to']['buckets'][] = array(
                    'key' => $dataset_bucket['key'] . ':' . $id_bucket['key'],
                    'label' => $id_bucket['to_name']['buckets'][0]['key'],
                    'count' => $id_bucket['doc_count'],
                );
            }
        }

        foreach ($_aggs['template_id']['filtered']['buckets'] as $bucket) {
            $aggs['template']['buckets'][] = array(
                'key' => $bucket['key'],
                'label' => $bucket['template_label']['buckets'][0]['key'],
                'count' => $bucket['doc_count'],
            );
        }

        foreach ($_aggs['sent']['filtered']['buckets'] as $bucket) {

            if ($bucket['key'] == 'F') {
                $aggs['sent']['buckets'][] = array(
                    'key' => '0',
                    'label' => 'Niewysłane',
                    'count' => $bucket['doc_count'],
                );
            } elseif ($bucket['key'] == 'T') {
                $aggs['sent']['buckets'][] = array(
                    'key' => '1',
                    'label' => 'Wysłane',
                    'count' => $bucket['doc_count'],
                );
            }


        }

        $this->set('query', $this->request->query);
        $this->set('performance', $performance);
        $this->set('pagination', $pagination);
        $this->set('items', $items);
        $this->set('aggs', $aggs);
        $this->set('q', $q);
        $this->set('title_for_layout', 'Pisma');
        $this->set('filters_selected', $filters_selected);

        $this->title = 'Moje Pisma';
    }
    */
    
    public function my()
    {

        $this->title = 'Moje Pisma';
				
        $this->Components->load('Dane.DataBrowser', array(
            '_type' => 'letters',
            'noResultsElement' => 'Start.brakPism',
        ));

    }

    public function templates()
    {
        $this->set('output', $this->Pismo->templates_index($this->request->query));
        $this->set('_serialize', 'output');
    }

    public function attachment($letter_id, $slug = '', $attachment_id) {
        $url = $this->LetterResponse->getAttachmentURL(
            $attachment_id
        );

        if(!$url)
            throw new NotFoundException;

        $this->redirect($url);
        return 0;
    }

}
