<?php

Router::connect('/kultura/indeksy/:id', array(
    'plugin' => 'Kultura',
    'controller' => 'Indeksy',
    'action' => 'view',
), array(
    'id' => '[0-9]+',
));
