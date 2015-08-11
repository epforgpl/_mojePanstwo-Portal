<?php

namespace TestApp\Error;

use Cake\Controller\Controller;
use Cake\Error\ExceptionRenderer;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;
use TestApp\Controller\TestAppsErrorController;

us  Cake\Core\Configure;

class TestAppsExceptionRenderer extends ExceptionRenderer
{

    /**
     * {@inheritDoc}
     */
    protected function _getController()
    {
        if (!$request = Router::getRequest(true)) {
            $request = new Request();
        }
        $response = new Response();
        try {
            $controller = new TestAppsErrorController($request, $response);
            $controller->layout = 'banana';
        } catch (\Exception $e) {
            $controller = new Controller($request, $response);
            $controller->viewPath = 'Error';
        }
        return $controller;
    }
}
