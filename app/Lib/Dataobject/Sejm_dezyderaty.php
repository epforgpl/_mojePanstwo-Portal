<?php
/**
 * Created by PhpStorm.
 * User: adamciezkowski
 * Date: 03/12/13
 * Time: 11:55
 */

namespace MP\Lib;
require_once('DocDataObject.php');

class Sejm_dezyderaty extends DocDataObject
{
	
	protected $tiny_label = 'Sejm';
	
    public function getTitle()
    {
        return $this->getData('tytul');
    }

    public function getShortTitle()
    {
        return $this->getData('tytul');
    }

    public function getLabel()
    {
        return '<strong>Dezyderat</strong> ' . $this->getData('sejm_komisje.dopelniacz');
    }

    public function getUrl() {

        return '/dane/instytucje/3214/dezyderaty/' . $this->getId() . ',' . $this->getSlug();

    }

    public function getBreadcrumbs()
    {

        return array(
            array(
                'id' => '/dane/instytucje/3214,sejm-rzeczypospolitej-polskiej/dezyderaty',
                'label' => 'Dezyderaty',
            ),
        );

    }
    
    public function getMetaDescriptionParts($preset = false)
	{
		
		$output = array();
		
		if( $this->getDate() )
			$output[] = dataSlownie($this->getDate());
		
		if( $this->getData('sejm_komisje.nazwa') )
			$output[] = $this->getData('sejm_komisje.nazwa');
			
		if( $this->getData('adresat') )
			$output[] = 'Adresat: ' . $this->getData('adresat');
				
		return $output;
		
	}
}
