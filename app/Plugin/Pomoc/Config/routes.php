<?php

Router::connect('/pomoc', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'index'));
Router::connect('/pomoc/zglos_blad', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'blad'));
Router::connect('/pomoc/instrukcje', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'instrukcje'));
Router::connect('/pomoc/filmy', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'filmy'));
Router::connect('/pomoc/dane_osobowe', array('plugin' => 'Pomoc', 'controller' => 'Pomoc', 'action' => 'dane_osobowe'));
