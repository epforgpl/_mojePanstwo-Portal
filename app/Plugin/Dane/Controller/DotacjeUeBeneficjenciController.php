<?php

App::uses('DataobjectsController', 'Dane.Controller');

class DotacjeUeBeneficjenciController extends DataobjectsController
{

    public function view()
    {

        $id = $this->API->KRS()->getOrganizationIdBy(array(
            'dotacje_ue_beneficjent_id' => $this->request->params['id']
        ));

        if ($id)
            $this->redirect('/dane/krs_podmioty/' . $id);
        else
            $this->redirect($this->referer());

    }
}