<?php

class LetterResponse extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function save($letter_id, $data) {
        $res = $this->getDataSource()->request('pisma/' . $letter_id . '/responses', array(
            'method' => 'POST',
            'data' => $data,
        ));

        return $res;
    }

    public function getByLetter($letter_id) {
        $res = $this->getDataSource()->request('pisma/' . $letter_id . '/responses', array(
            'method' => 'GET'
        ));

        return $res;
    }

    public function get($letter_id, $response_id) {
        $res = $this->getDataSource()->request('pisma/' . $letter_id . '/responses/' . $response_id, array(
            'method' => 'GET'
        ));

        return $res;
    }

}
