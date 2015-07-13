<div class="content col-md-12">
    <p class="header">
        <?= $object->getFullLabel(); ?>
    </p>

    <div class="line quote">
        <blockquote class="_">
            <?php echo $object->getData('html') ?>
        </blockquote>
    </div>

</div>