<?

foreach (array('kto_tu_rzadzi') as $base) {

    Router::connect('/' . $base, array('plugin' => 'KtoTuRzadzi', 'controller' => 'KtoTuRzadzi', 'action' => 'view'));
    Router::connect('/' . $base . '/urzednicy', array('plugin' => 'KtoTuRzadzi', 'controller' => 'KtoTuRzadzi', 'action' => 'urzednicy',));
    Router::connect('/' . $base . '/:id', array('plugin' => 'KtoTuRzadzi', 'controller' => 'KtoTuRzadzi', 'action' => 'action',));

}