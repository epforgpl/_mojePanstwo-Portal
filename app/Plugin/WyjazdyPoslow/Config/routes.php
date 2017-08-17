<?php
Router::connect('/wyjazdy_poslow/*', array('plugin' => 'wyjazdy_poslow', 'controller' => 'wyjazdy_poslow'));
Router::redirect(
    '/wyjazdy_posloww/*',
    array('plugin' => 'wyjazdy_poslow', 'controller' => 'wyjazdy_poslow'),
    array('persist' => true)
);