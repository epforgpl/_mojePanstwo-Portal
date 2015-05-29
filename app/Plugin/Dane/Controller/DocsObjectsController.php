<?php

App::uses('DataobjectsController', 'Dane.Controller');

abstract class DocsObjectsController extends DataobjectsController
{
    public $components = array(
        'RequestHandler',
    );
    public $menu = array();


    public function view($package = 1)
    {
        parent::load();

        $docs = $this->object->loadLayer('docs');
        $selected_doc_id = $this->object->getData('dokument_id');

        if (@$this->request->query['f']) {
            foreach ($docs as $category) {
                foreach ($category['files'] as $file) {
                    if ($file['files']['dokument_id'] == $this->request->query['f']) {
                        $selected_doc_id = $file['files']['dokument_id'];
                        break;
                    }
                }
            }
        }
		
		$this->set('selected_doc_id', $selected_doc_id);
        
    }

    public function beforeRender()
    {
        if (!file_exists(ROOT . DS . APP_DIR . DS . 'Plugin' . DS . $this->params->plugin . DS . 'View' . DS . $this->viewPath . DS . $this->view . '.ctp')) {
            # try to fallback on some default
            if (file_exists(ROOT . DS . APP_DIR . DS . 'Plugin' . DS . $this->params->plugin . DS . 'View' . DS . 'DocsObjects' . DS . $this->view . '.ctp')) {
                $this->view = 'DocsObjects/' . $this->view;

            }
        }
        
        parent::beforeRender();
    }

} 