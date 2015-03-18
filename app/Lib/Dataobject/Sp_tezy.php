<?php

namespace MP\Lib;
require_once('DocDataObject.php');

class Sp_tezy extends DocDataObject
{
	
	protected $tiny_label = 'Teza sądu';
	
    public function getLabel()
    {
        return '<strong>Teza</strong> ' . $this->getData('sady_sp.dopelniacz');
    }

    public function getShortTitle()
    {

        return $this->getData('teza');

    }


}