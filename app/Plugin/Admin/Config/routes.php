<?php

Router::connect('/admin/kultura/pliki/:id', array(
    'plugin' => 'Admin',
    'controller' => 'Kultura',
    'action' => 'plik'
));


