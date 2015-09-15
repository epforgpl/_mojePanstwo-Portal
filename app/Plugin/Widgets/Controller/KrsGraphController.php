<?php

App::uses('WidgetsAppController', 'Widgets.Controller');

class KrsGraphController extends WidgetsAppController {

    public function view($id = 0)
    {
        if(!$id)
            throw new NotFoundException;

        $object = $this->Dataobject->find('first', array(
            'conditions' => array(
                'dataset' => 'krs_osoby',
                'id' => $id
            ),
            'layers' => array(
                'powiazania'
            )
        ));

        if(!$object)
            throw new NotFoundException;

        $this->set('object', $object);
    }

}
