<?

echo $this->Dataobject->highlights($hlFields, $hlFieldsPush, $defaults);

if ($object->getData('funkcja_id') == '1')
    echo '<p><span class="label label-danger"">Przewodniczący</span></p>';
elseif ($object->getData('funkcja_id') == '2')
    echo '<p><span class="label label-warning"">Wiceprzewodniczący</span></p>';