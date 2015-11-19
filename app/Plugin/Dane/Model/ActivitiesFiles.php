<?php

class ActivitiesFiles extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function getByActivity($activity_id) {
        $res = $this->getDataSource()->request('activities/activities/getFiles/' . $activity_id, array(
            'method' => 'GET'
        ));

        return $res;
    }

    public function getFile($activity_id, $file_id) {
        $res = $this->getDataSource()->request('activities/activities/getFile/' . $activity_id . '/' . $file_id, array(
            'method' => 'GET'
        ));

        return $res;
    }

}