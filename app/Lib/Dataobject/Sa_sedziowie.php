<?php
/**
 * Created by PhpStorm.
 * User: adamciezkowski
 * Date: 03/12/13
 * Time: 14:22
 */

namespace MP\Lib;


class Sa_sedziowie extends DataObject
{
	
	protected $tiny_label = 'Sędzia';
	
    public function getLabel()
    {
        return '<strong>Sędzia</strong> sądu administracyjnego';
    }

    public function getTitle()
    {
        return $this->getShortTitle();
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