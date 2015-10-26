<?php

class KeysController extends PaszportAppController
{
    public $uses = array('Paszport.User', 'Paszport.Key');
    public $components = array( //        'Paszport.PassportApi'
    );

    public function index()
    {

        $this->data = $this->PassportApi->find('keys', array('conditions' => array('Key.user_id' => $this->Auth->user('id'))), 'all');
        $this->data = $this->data['key'];
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_API_KEYS', true));
    }

    public function add()
    {
        $this->set('title_for_layout', __d('paszport', 'LC_PASZPORT_ADD_KEY', true));
        if ($this->request->isPost()) {
            $to_save = $this->data;
            $to_save['Key']['user_id'] = $this->Auth->user('id');
            $to_save['Key']['key'] = md5(mktime() . $this->Auth->user('id'));

            if ($this->PassportApi->add('keys', $to_save)) {
                $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_KEY_ADDED'), 'alert', array('class' => 'alert-success'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function delete($id = null)
    {
        if (is_null($id)) {
            $this->redirect(array('action' => 'index'));
        }
        $this->PassportApi->delete('keys', $id);
        $this->Session->setFlash(__d('paszport', 'LC_PASZPORT_KEY_DELETED'), 'alert');
        $this->redirect(array('action' => 'index'));
    }
}
