<?php $this->Combinator->add_libs('css', $this->Less->css('prawo', array('plugin' => 'Prawo'))) ?>
<?php $this->Combinator->add_libs('js', 'Prawo.prawo.js') ?>

<?= $this->Element('appheader', array('title' => 'Prawo', 'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce', 'appMenu' => $appMenu, 'appMenuSelected' => $appMenuSelected, 'headerUrl' => 'prawo.png')); ?>

<div class="container">

</div>