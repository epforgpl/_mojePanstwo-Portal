<?
foreach ($objects as $object) {

    $theme = 'feed/' . $preset . '/' . $object->getDataset();

    echo $this->Dataobject->render($object, 'feed', array(
        // 'hlFields' => $dataBrowser->hlFields,
        // 'hlFieldsPush' => $dataBrowser->hlFieldsPush,
        // 'routes' => $dataBrowser->routes,
        'forceLabel' => false,
        'file' => 'feed/' . $preset . '/' . $object->getDataset(),
        // 'defaults' => $defaults,
    ));

}