<div class="posiedzenie objectRender <?php echo $object->getDataset() ?>" oid="<?php echo $item['data']['id'] ?>">

    <a title="<?= strip_tags($object->getTitle()) ?>" href="/dane/rady_posiedzenia/<?= $object->getId() ?>"><img
            alt="<?= strip_tags($object->getTitle()) ?>" src="<?= $object->getThumbnailUrl() ?>"/></a>

    <p class="title">
        <a href="<?= $object->getUrl() ?>"
           title="<?= strip_tags($object->getTitle()) ?>"><?= $object->getShortTitle() ?>
            <small>#<?= $object->getData('numer') ?></small>
        </a>
    </p>

</div>