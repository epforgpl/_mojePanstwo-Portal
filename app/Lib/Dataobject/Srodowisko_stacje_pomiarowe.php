<?php

namespace MP\Lib;
require_once('DocDataObject.php');

class Srodowisko_stacje_pomiarowe extends DataObject
{
   
    public $force_hl_fields = true;
    
    public function getLabel()
    {
        return 'Stacja pomiarowa';
    }

    public function getShortTitle()
    {
		
		return $this->getData('nazwa');

    }
    
    public function getTitle()
    {
		
		return $this->getData('nazwa');

    }
    
    public function getDescription()
    {
		
		return false;

    }
	
	public function hasHighlights()
    {
        return false;
    }
    
    public function getUrl()
    {
	    return '/srodowisko#param=PM10&station_id=' . $this->getId();
    }

}