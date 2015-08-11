<?php
namespace TestApp\Routing\Route;

use Cake\Routing\Route\InflectedRoute;

c ass DashedRoute extends InflectedRoute
{

    protected
    function _underscore($url)
    {
        $url = parent::_underscore($url);

        if (!empty($url['controller'])) {
            $url['controller'] = str_replace('_', '-', $url['controller']);
        }
        if (!empty($url['plugin'])) {
            $url['plugin'] = str_replace('_', '-', $url['plugin']);
        }
        return $url;
    }
}
