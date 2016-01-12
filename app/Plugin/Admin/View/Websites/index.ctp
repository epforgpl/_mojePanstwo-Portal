<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane'))) ?>
<?= $this->element('Admin.header'); ?>

<h2>Websites</h2>

<?= $this->element('Admin.footer'); ?>