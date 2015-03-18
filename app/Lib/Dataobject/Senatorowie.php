<?php

namespace MP\Lib;
require_once('DocDataObject.php');

class Senatorowie extends DocDataObject
{	
	
	protected $tiny_label = 'Senator';
	
    public function getLabel()
    {
        return 'Senator';
    }

    public function getTitle()
    {
        return $this->getShortTitle();
    }
    
    public function getDescription()
    {
        return false;
    }

    public function getShortTitle()
    {
        return $this->getData('nazwa');
    }
    
    public function hasHighlights()
    {
        return false;
    }
} 