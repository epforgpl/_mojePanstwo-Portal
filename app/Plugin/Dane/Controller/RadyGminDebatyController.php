<?php

App::uses('DataobjectsController', 'Dane.Controller');

class RadyGminDebatyController extends DataobjectsController
{
    public function view()
    {
        parent::_prepareView();

        $this->redirect('/dane/gminy/' . $this->object->getData('gminy.id') . '/debaty/' . $this->object->getId());
        die();

        $this->object->loadLayer('wystapienia');
        $wystapienia = array();
        foreach ($this->object->layers['wystapienia'] as $wystapienie) {
            $wystapienia[$wystapienie['rady_posiedzenia_wystapienia']['id']] = array(
                'mowca_str' => $wystapienie['rady_posiedzenia_wystapienia']['mowca_str'],
                'video_start' => $wystapienie['rady_posiedzenia_wystapienia']['video_start']
            );
        }
        $this->set('wystapienia', $wystapienia);

    }
} 