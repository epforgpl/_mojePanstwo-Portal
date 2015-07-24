<?php
/**
 * Created by PhpStorm.
 * User: adamciezkowski
 * Date: 03/12/13
 * Time: 13:04
 */

namespace MP\Lib;


class Sejm_komisje extends DataObject
{
	
	protected $tiny_label = 'Komisja sejmowa';
	
    public function getLabel()
    {
        return 'Komisja sejmowa';
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

        return '/dane/instytucje/3214/sejm_komisje/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/sejm_komisje',
                'label' => 'Komisje sejmowe',
            ),
        );

    }
}