<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo __d('paszport', 'LC_PASZPORT_PROJECT_NAME') . ' - ' . __d('paszport', $title_for_layout); ?>
    </title>
    <?php $this->Combinator->add_libs('css', 'bootstrap.min'); ?>
    <?php $this->Combinator->add_libs('css', 'bootstrap-responsive.min'); ?>
    <?php $this->Combinator->add_libs('js', 'jquery'); ?>
    <?php $this->Combinator->add_libs('js', 'bootstrap.min'); ?>
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
</head>
<body>
<?php echo $this->Session->flash('flash', array('element' => 'alert')); ?>
<?php echo $this->Session->flash('auth', array('element' => 'alert')); ?>

<div class="container">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Session->flash('auth', array(
        'element' => 'alert',
        'params' => array('plugin' => 'BoostCake')
    ));
    ?>
    <?php echo $this->fetch('content'); ?>
</div>

</body>
</html>
