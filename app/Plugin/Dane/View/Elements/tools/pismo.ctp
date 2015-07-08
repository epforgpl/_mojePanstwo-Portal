<?
$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
$this->Combinator->add_libs('js', 'Pisma.pisma-button');
?>

<div class="banner pismo block">
    <?php echo $this->Html->image('Dane.banners/pisma.svg', array('width' => '92', 'alt' => 'Stwórz pismo do organizacji', 'class' => 'pull-right')); ?>
    <p><?= isset($label) ? $label : '<strong>Wyślij pismo</strong> do tej organizacji'; ?></p>
    <a href="/pisma/nowe" class="btn btn-sm btn-primary pisma-list-button" data-adresatid="<?= $object->getDataset(); ?>:<?= $object->getId(); ?>">Napisz
        pismo</a>
</div>