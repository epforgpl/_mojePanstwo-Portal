<?php

class TwitterAccountSuggestion extends AppModel {

    public $useDbConfig = 'mpAPI';

    public function suggestNewAccount($data)
    {
        return $this->getDataSource()->request('media/twitter/suggestNewAccount.json', array(
            'data' => $data,
            'method' => 'POST',
        ));

    }

}
