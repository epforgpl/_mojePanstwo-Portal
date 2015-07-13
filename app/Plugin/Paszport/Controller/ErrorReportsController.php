<?php

class ErrorReportsController extends PaszportAppController
{
    public function beforeFilter()
    {
        $this->Auth->allow('index');
        parent::beforeFilter();


    }

    public function index()
    {
        if ($this->request->isPost()) {
            $to_save = $this->data;
            $to_save['ErrorReport']['user_id'] = $this->Auth->user('id');
            $to_save['ErrorReport']['user_agent'] = env('HTTP_USER_AGENT');
            $this->ErrorReport->Behaviors->load('Upload.Upload', array(
                'screenshot' => array(
                    'path' => '{ROOT}webroot{DS}uploads{DS}{model}{DS}{field}{DS}',
                    'mimetypes' => array(
                        'image/jpg',
                        'image/jpeg',
                        'image/gif',
                        'image/png'
                    )
                )
            ));
            $this->ErrorReport->save($to_save);
            $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_ERROR_REPORT_SENT', true), 'alert', array('class' => 'alert-success'));
        }
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_ERROR_REPORTS', true));
    }
}