<?php foreach ($objects as $object) {
    echo $this->Dataobject->render($object, 'default', array(
        'forceLabel' => true,
        'alertsButtons' => true,
        'alertsStatus' => !(isset($this->request->query['mode']) && ($this->request->query['mode'] == '2')),
    ));
} ?>