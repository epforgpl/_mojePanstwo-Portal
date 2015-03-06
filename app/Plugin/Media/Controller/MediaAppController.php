<?php

class MediaAppController extends AppController
{

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->API = $this->API->Media();

        $appMenu = array(
            array('id' => '', 'label' => 'Start'),
            array('id' => 'twitter', 'label' => 'Konta Twitter'),
            array('id' => 'tweety', 'label' => 'Tweety'),
            array('id' => 'hashtagi', 'label' => 'Hashtagi')
        );

        $this->set('appMenu', $appMenu);
    }

}