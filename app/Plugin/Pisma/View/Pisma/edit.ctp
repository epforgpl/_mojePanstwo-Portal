<?php echo $this->Html->script('../plugins/tinymce/tinymce.min', array('block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<? echo $this->Element('Pisma.editor', array('title' => isset($pismo['tytul']) ? $pismo['tytul'] : '')); ?>