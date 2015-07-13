<?php $this->Combinator->add_libs('css', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&subset=latin,latin-ext') ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('style', array('plugin' => 'Paszport'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('front', array('plugin' => 'Paszport'))) ?>

<?php $this->Combinator->add_libs('js', 'Paszport.jqBootstrapValidation'); ?>
<?php $this->Combinator->add_libs('js', 'Paszport.main'); ?>
<?php $this->Combinator->add_libs('js', 'Paszport.front'); ?>