<?php

App::uses('AppController', 'Controller');

/**
 * @property Dataobject Dataobject
 */
class WidgetsAppController extends AppController {

    public $uses = array('Dane.Dataobject');
    public $layout = 'Widgets.widget';

}
