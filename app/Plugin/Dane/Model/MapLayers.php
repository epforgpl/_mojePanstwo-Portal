<?php

/**
 * Created by PhpStorm.
 * User: tomaszdrazewski
 * Date: 16/09/15
 * Time: 15:50
 */
class MapLayers extends AppModel
{

    public $useDbConfig = 'mpAPI';

    public function get_layer($type)
    {
        $data = $this->getDataSource()->request('mapa_krakow/layers/',
            array(
                'method' => 'GET',
                'data' => array(
                    'type' => $type
                )
            ));
        return $data;
    }
}
