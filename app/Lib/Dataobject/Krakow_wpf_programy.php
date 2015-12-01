<?php

namespace MP\Lib;

class Krakow_wpf_programy extends DataObject
{

    public function getLabel() {
        return 'Program';
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

        return $output;

    }

}