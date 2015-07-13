<?php

class PanstwoInternetAppController extends AppController
{

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->API = $this->API->PanstwoInternet();
    }

}