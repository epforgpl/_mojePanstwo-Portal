<?
$number_format = array(
    'places' => 0,
    'before' => '',
    'escape' => false,
    'decimals' => '.',
    'thousands' => ' '
);

?>

<p class="line signature text-muted">
    <?= $object->getData('description'); ?>
</p>

<? echo $this->Dataobject->highlights($hlFields, $hlFieldsPush); ?>
