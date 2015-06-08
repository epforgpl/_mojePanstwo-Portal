<div class="attachment col-md-4">

    <a href="<?= $object->getUrl() ?>">
        <object data="/img/error/brak.gif" type="image/png">
            <img src="<?= $object->getThumbnailUrl('1') ?>" alt="<?= strip_tags($object->getTitle()) ?>"/>
        </object>
    </a>

    <a class="smaller"
       href="/dane/twitter_accounts/<?= $object->getData('twitter_accounts.id') ?>"><?= $object->getData('twitter_accounts.name'); ?></a>

</div>
<div class="content col-md-8">
    <p class="header">
        <?= $object->getFullLabel(); ?>
    </p>

    <div class="line quote">
        <blockquote class="_">
            <?php echo $item['data']['html'] ?>
        </blockquote>
    </div>

</div>