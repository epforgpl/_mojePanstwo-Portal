<?php
/**
 * Created by PhpStorm.
 * User: tomaszdrazewski
 * Date: 08/09/15
 * Time: 13:17
 */

class PKB extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function getPKB()
    {
        $data = $this->getDataSource()->request('finanse/getpkb');
        return $data;
    }
}
