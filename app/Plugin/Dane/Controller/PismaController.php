<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PismaController extends DataobjectsController
{

    public function view() {
        $this->_prepareView();
        $this->loadModel('Start.LetterResponse');
        $this->set('responses', $this->LetterResponse->getByLetter(
            $this->object->getData('alphaid')
        ));
    }

    public function attachment() {
        $attachment_id = (int) $this->request->params['subid'];
        $this->loadModel('Start.LetterResponse');
        $url = $this->LetterResponse->getAttachmentURL(
            $attachment_id
        );

        if(!$url)
            throw new NotFoundException;

        $this->redirect($url);
    }

}