<?php

App::uses('Helper', 'PaginatorHelper');

class MPaginatorHelper extends PaginatorHelper {

    public function url($options = array(), $asArray = false, $model = null) {
        $params = array();

        if(isset($this->request->query['q']) && !is_null($this->request->query['q']))
            $params['q'] = $this->request->query['q'];

        if(isset($this->request->query['conditions'])) {
            $conditions = $this->request->query['conditions'];
            if(isset($conditions['q']))
                unset($conditions['q']);
            $params['conditions'] = $conditions;
        }

        if(isset($options['page']))
            $params['page'] = $options['page'];

        return '?' . http_build_query($params);
    }

} 