<?php

namespace MP\Lib;

class Krakow_wpf_programy extends DataObject
{

    public function getLabel() {
        return 'Program';
    }

    public function getUrl() {
        return '/dane/gminy/903,krakow/wpf/' . $this->getId() . ',' . $this->getSlug();
    }


    public function getShortTitle() {
        return $this->getData('nazwa');
    }

    public function getMetaDescriptionParts($preset = false)
    {	
	    	    
        $output = array();
        
        $i = (int) $this->getData('ilosc');
        if($i > 1)
            $output[] = $i . ' przedsięwzięcia';
		
		if( $this->getData('laczne_naklady_fin') )
			$output[] = 'Wartość inwstycji: ' . number_format_h($this->getData('laczne_naklady_fin')) . ' zł';
				
        return $output;

    }

}