<div class="banner block">
    <?php echo $this->Html->image('Dane.banners/pisma.svg', array('width' => '92', 'alt' => 'Stwórz pismo do organizacji', 'class' => 'pull-right')); ?>
    <p>Napisz i <strong>wyślij pismo</strong> do tej organizacji</p>
    <a href="/pisma/nowe" class="btn btn-primary pisma-list-button" data-adresatid="<?= $object->getId(); ?>">Stwórz
        pismo</a>
</div>