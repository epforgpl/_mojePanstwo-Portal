<?php
Router::connect('/prawo', array('plugin' => 'prawo', 'controller' => 'prawo', 'action' => 'view'));
Router::connect('/prawo/:id', array('plugin' => 'prawo', 'controller' => 'prawo', 'action' => 'action',));
