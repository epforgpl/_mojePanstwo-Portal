<?php

Router::connect('/powiadomienia', array(
    'plugin' => 'powiadomienia',
    'controller' => 'powiadomienia',
    'action' => 'index'
));