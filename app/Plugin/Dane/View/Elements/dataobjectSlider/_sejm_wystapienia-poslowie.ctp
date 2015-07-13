<div class="content row">

    <p class="header">
        <?= $this->Czas->dataSlownie($object->getDate()); ?>
    </p>

    <div class="line quote">
        <blockquote class="_">
            <a href="/dane/sejm_wystapienia/<?= $object->getId() ?>"><?php echo $item['data']['skrot'] ?></a>
        </blockquote>
    </div>

</div>