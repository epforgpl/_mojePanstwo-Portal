<?php

/**
 * Created by PhpStorm.
 * User: tomekdrazewski
 * Date: 25/05/15
 * Time: 12:04
 */
class Analyzer extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function grabData($id)
    {

        $res = $this->getDataSource()->request('/admin/analyzers/id:' . $id, array(
            'method' => 'GET',
        ));

        $code = (int)$this->getDataSource()->Http->response->code;
        if ($code >= 400) {

            throw new NotFoundException();

        } else {
            return $res;
        }
    }
}