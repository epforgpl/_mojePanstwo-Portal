<?php

class DataobjectsSliderHelper extends AppHelper
{
    public function __construct(View $view, $settings = array())
    {
        $this->view = $view;
        parent::__construct($view, $settings);
    }

    public function render($objects = array(), $options = array())
    {

        return $this->view->element('dataobjectsSliderTemplate', array(
            'objects' => $objects,
            'options' => $options,
        ), array('plugin' => 'Dane'));

    }

}
