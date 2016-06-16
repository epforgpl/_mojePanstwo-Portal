<?php
Router::connect('/prawo', array('plugin' => 'prawo', 'controller' => 'prawo', 'action' => 'view'));
Router::connect('/prawo/:id', array('plugin' => 'prawo', 'controller' => 'prawo', 'action' => 'action',), array('id' => 'dziennik_ustaw|monitor_polski|tematy|lokalne|urzedowe'));
Router::connect('/prawo/:action', array('plugin' => 'prawo', 'controller' => 'prawo'));
