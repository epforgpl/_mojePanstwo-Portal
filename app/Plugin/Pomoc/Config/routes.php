<?php

Router::connect('/pomoc', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'index'));
Router::connect('/pomoc/*', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'index'));
