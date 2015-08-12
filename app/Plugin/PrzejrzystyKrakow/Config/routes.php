<?php
Router::connect('/przejrzysty_krakow', array('plugin' => 'przejrzysty_krakow', 'controller' => 'przejrzysty_krakow'));
Router::connect('/glosowanie/:action/*', array('plugin' => 'przejrzysty_krakow', 'controller' => 'glosowanie'));