<div class="banner pismo block">
    <?php echo $this->Html->image('Dane.banners/pisma.svg', array('width' => '92', 'alt' => 'Stwórz pismo do organizacji', 'class' => 'pull-right')); ?>
    <p><strong>Wyślij pismo</strong> do tej organizacji</p>
    <a href="/pisma/nowe" class="btn btn-sm btn-primary pisma-list-button" data-adresatid="<?= $object->getId(); ?>">Napisz
        pismo</a>
</div>