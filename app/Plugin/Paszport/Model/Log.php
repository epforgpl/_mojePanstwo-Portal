<?php

class Log extends PaszportAppModel
{
    public $belongsTo = array('Paszport.User');

    public function afterFind($results, $primary = true)
    {
        parent::afterFind($results, $primary);
        if ($primary) {
            if (isset($results[$this->alias])) { # single result
                $results[$this->alias] = $this->logsJsonToString($results);
            } else {
                foreach ($results as $key => $result) {
                    if (isset($result[$this->alias])) {
                        $results[$key][$this->alias] = $this->logsJsonToString($result);
                    }
                }
            }
        }

        return $results;
    }

    /**
     * @param $results single entity of Log
     *
     * @return string
     */
    protected function logsJsonToString($results)
    {
        if (!isset($results[$this->alias])) {
            $results;
        }
        $tmp = json_decode($results[$this->alias]['msg'], true);
        if (is_array($tmp) && count($tmp) > 1) {
            $tmp['label'] = __($tmp['label'], true);
            $tmp = implode('; ', $tmp);
            $results[$this->alias]['msg'] = $tmp;
        }

        return $results[$this->alias];

    }
}