<?php $this->Combinator->add_libs('css', '//fonts.googleapis.com/css?family=Istok+Web:400,700&subset=latin,latin-ext') ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('enhanced', array('plugin' => 'Paszport'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('style', array('plugin' => 'Paszport'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('user-center', array('plugin' => 'Paszport'))); ?>


<?php $this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock')); ?>
<?php $this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('js', 'Paszport.enhance.min'); ?>
<?php $this->Combinator->add_libs('js', 'Paszport.jqBootstrapValidation'); ?>
<?php $this->Combinator->add_libs('js', 'Paszport.fileinput.jquery'); ?>
<?php $this->Combinator->add_libs('js', 'Paszport.main'); ?>
<?php $this->Combinator->add_libs('js', 'Paszport.user-center'); ?>