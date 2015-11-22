<?php

class Letter extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function getTemplate($id) {
	    
        $res = $this->getDataSource()->request('pisma/templates/' . $id, array(
            'method' => 'GET',
        ));

        return $res;
    }

}
