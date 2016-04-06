<?php
Router::connect('/zbiorki_publiczne/formularz', array('plugin' => 'zbiorki_publiczne', 'controller' => 'zbiorki_publiczne', 'action' => 'formularz'));
Router::connect('/zbiorki_publiczne/:action', array('plugin' => 'zbiorki_publiczne', 'controller' => 'zbiorki_publiczne'));
Router::connect('/zbiorki_publiczne/*', array('plugin' => 'zbiorki_publiczne', 'controller' => 'zbiorki_publiczne'));
