<?php

class Krakow extends AppModel
{
    public $useDbConfig = 'mpAPI';

    public function okregi() {
        return $this->getDataSource()->request('krakow/okregi/get');
    }

    public function okreg($id) {
        return $this->getDataSource()->request('krakow/okregi/get/' . $id);
    }

}