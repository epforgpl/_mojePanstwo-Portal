<?php

class DataobjectsController extends PowiadomieniaAppController
{
    public $components = array(
        'Session',
        'RequestHandler',
        'Paginator'
    );

    public function index()
    {
        $queryData = array_merge($this->data, array(
            'paramType' => 'querystring',
        ));
        $this->paginate = $queryData;
        $this->set(array(
            'objects' => $this->Paginator->paginate(),
        ));
        if ($this->request->isAjax()) {
            $this->layout = 'ajax';
            echo $this->_getViewObject()->render('Dataobjects/ajax/index');
            $this->autoRender = false;
        }

    }

    public function flagObject($object_id)
    {
        //@TODO : @danielmacyszyn - nie wiem w koncu czy mozemy oznaczyc jeden element jako przeczytany, ostatnio mowiles, ze nie, ale w docu jest na to metoda
        $this->API->Powiadomienia()->read($object_id);
        $this->Session->setFlash(__('LC_POWIADOMIENIA_OZNACZONO_JAK_PRZECZYTANE', true));
        $this->redirect(array('controller' => 'powiadomienia', 'action' => 'index'));
    }

    public function flagObjects()
    {
        if ($this->data) {
            $data = $this->data;
            if (!isset($this->data['ids'])) {
                $data['ids'] = array();
            }
            $this->API->Powiadomienia()->readAll($data['max_position'], $data['ids']);
            $this->Session->setFlash(__('LC_POWIADOMIENIA_OZNACZONO_JAK_PRZECZYTANE', true));
            $this->redirect(array('controller' => 'powiadomienia', 'action' => 'index'));
        } else {
            $this->redirect(array('controller' => 'powiadomienia', 'action' => 'index'));
        }

    }
}