<?php
App::uses('CakeTime', 'Utility');
App::uses('DataobjectsController', 'Dane.Controller');

class DatasetsController extends DataobjectsController
{

    public $uses = array('Dane.Dataobject');

    public $_layout = array(
        'header' => array(
            'element' => 'dataset',
        ),
        'body' => array(
            'theme' => 'simply'
        )
    );

    public $components = array(
        'Paginator'
    );

    public function view($slug = false)
    {

        if ($slug) {

            $layers = $this->initLayers;

            if ($this->object = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'zbiory',
                    'zbiory.slug' => $slug,
                ),
                'layers' => $layers,
            ))
            ) {

                $this->set('object', $this->object);
                $this->set('objectOptions', $this->objectOptions);
                $this->set('microdata', $this->microdata);
                $this->set('title_for_layout', $this->object->getTitle());

                // $this->addAppBreadcrumb('krs');

                if ($desc = $this->object->getDescription())
                    $this->setMetaDescription($desc);


                $this->Components->load('Dane.DataBrowser', array(
                    'conditions' => array(
                        'dataset' => $this->object->getData('slug'),
                    ),
                    'aggsPreset' => $this->object->getData('slug'),
                ));

            }

        } else {
            throw new BadRequestException();
        }

    }

}