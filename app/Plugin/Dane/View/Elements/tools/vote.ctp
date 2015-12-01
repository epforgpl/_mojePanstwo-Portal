<div class="banner pismo block<? if( isset($class) ) echo " " . $class; ?>">
    <?php echo $this->Html->image('Dane.banners/vote.svg', array('width' => '82', 'alt' => 'Głosuj', 'class' => 'pull-right')); ?>
    <p><strong>Poczuj się jak radny</strong> i głosuj na uchwały</p>
    <a href="<?= $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj' : '/glosuj'; ?>" class="btn btn-sm btn-primary">Głosuj</a>
</div>