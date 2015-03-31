<?php
$theme = 'feed/' . $preset . '/' . $object->getDataset();

echo $this->Dataobject->render($object, 'feed', array(
    'forceLabel' => false,
    'file' => 'feed/' . $preset . '/' . $object->getDataset(),
));