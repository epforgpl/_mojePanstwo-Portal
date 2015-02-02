<?php

Router::connect('/finanse', array('plugin' => 'Finanse', 'controller' => 'Finanse','action' => 'dzialy'));


/*
Router::connect('/ustawy', array('plugin' => 'ustawy', 'controller' => 'ustawy','action' => 'index'));
Router::connect('/ustawy/szukaj', array('plugin' => 'ustawy', 'controller' => 'ustawy', 'action' => 'search'));
Router::connect('/ustawy/:action', array('plugin' => 'ustawy', 'controller' => 'ustawy'));
*/