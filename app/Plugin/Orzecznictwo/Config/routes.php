<?php
Router::connect('/orzecznictwo', array('plugin' => 'orzecznictwo', 'controller' => 'orzecznictwo', 'action' => 'view'));
Router::connect('/orzecznictwo/:id', array('plugin' => 'orzecznictwo', 'controller' => 'orzecznictwo', 'action' => 'action',));
