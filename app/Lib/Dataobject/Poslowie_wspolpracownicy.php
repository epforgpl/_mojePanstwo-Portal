<?php

namespace MP\Lib;
require_once('DocDataObject.php');

class Poslowie_wspolpracownicy extends DocDataObject
{

    protected $tiny_label = 'Osoba';

    protected $schema = array(
        array('poslowie.nazwa', 'Zatrudniający', 'string', array(
            'link' => array(
                'dataset' => 'poslowie',
                'object_id' => '$poslowie.id',
            ),
        )),
    );

    protected $hl_fields = array('poslowie.nazwa');

    public function getLabel()
    {
        return 'Współpracownik posła';
    }

    public function getTitle()
    {
        return $this->getShortTitle();
    }

    public function getShortTitle()
    {
        return $this->getData('nazwa');
    }

    public function getUrl() {

        return '/dane/instytucje/3214/poslowie_wspolpracownicy/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/poslowie_wspolpracownicy',
                'label' => 'Współpracownicy posłów',
            ),
        );

    }
} 