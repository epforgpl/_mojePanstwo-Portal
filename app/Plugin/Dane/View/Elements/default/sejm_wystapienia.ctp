<blockquote class="_">
    <a href="/dane/sejm_wystapienia/<?= $object->getId() ?>"><?= $object->hl ? $object->hl : $object->getData('skrot') ?></a>
</blockquote>

<?= $this->Dataobject->highlights($hlFields, $hlFieldsPush) ?>