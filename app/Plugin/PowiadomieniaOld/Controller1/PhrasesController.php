<?php
App::uses('Sanitize', 'Utility');

class PhrasesController extends PowiadomieniaAppController
{
    public $uses = array();
    public $components = array(
        'Session',
        'RequestHandler',
    );

    public function index()
    {
        $phrases = $this->API->getPhrases();
        $this->set(compact('phrases'));
        if (isset($this->params->query['addphrase'])) {
            $this->params->query['addphrase'] = Sanitize::stripAll($this->params->query['addphrase']);
            $this->API->addPhrase(array('q' => $this->params->query['addphrase']));
            $this->Session->setFlash(sprintf(__d('powiadomienia', 'LC_POWIADOMIENIA_FRAZA_ZOSTALA_DODANA'), $this->params->query['addphrase']));
            $this->redirect(array('controller' => 'powiadomienia', 'action' => 'index'));
        }
    }

    public function add()
    {

        $status = false;

        if (isset($this->request->data['add'])) {

            $status = $this->API->addPhrase($this->request->data['add']);

        }

        $this->set('status', $status);
        $this->set('_serialize', 'status');

    }

    public function remove($id = null)
    {
        if (!is_null($id)) {
            $this->API->removePhrase($id);
            // $this->Session->setFlash(__d('powiadomienia', 'LC_POWIADOMIENIA_FRAZA_ZOSTALA_USUNIETA', true));
            $this->redirect(array('controller' => 'powiadomienia', 'action' => 'index'));
        } else {
            throw new BadRequestException(__d('powiadomienia', 'LC_POWIADOMIENIA_BRAK_ID_DO_USUNIECIA', true));
        }
    }
} 