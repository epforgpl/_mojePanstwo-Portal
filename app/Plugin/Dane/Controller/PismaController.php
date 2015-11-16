<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PismaController extends DataobjectsController
{

    public function view() {
        $this->_prepareView();
        $this->loadModel('Start.LetterResponse');
        if($this->object->getData('object_id') > 0) {
            $this->redirect(
                '/dane/' .
                $this->object->getData('page_dataset') .
                '/' .
                $this->object->getData('page_object_id') .
                '/pisma/' .
                $this->object->getId()
            );
        }

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