<?php


class Group extends PaszportAppModel
{
    public $hasMany = array('Paszport.User');

    public function afterFind($results, $primary = true)
    {
        parent::afterFind($results, $primary);
        if (isset($results[$this->alias])) { # single result
            $results[$this->alias]['label'] = __($results[$this->alias]['label'], true);
        } else { # multi
            foreach ($results as $key => $result) {
                $results[$key][$this->alias]['label'] = __($result[$this->alias]['label'], true);
            }
        }

        return $results;
    }
}