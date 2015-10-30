<?

foreach (array('podatki') as $base) {
    Router::connect('/' . $base, array('plugin' => 'Podatki', 'controller' => 'Podatki', 'action' => 'view'));
}
