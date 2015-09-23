<?php
Router::connect('/prawo', array('plugin' => 'prawo', 'controller' => 'prawo', 'action' => 'view'));
Router::connect('/prawo/:action', array('plugin' => 'prawo', 'controller' => 'prawo'));
