<?= $this->Element('appheader', array('title' => 'Prawo', 'subtitle' => 'Przeglądaj prawo obowiązujące w Polsce', 'appMenu' => $appMenu, 'appMenuSelected' => $appMenuSelected, 'headerUrl' => 'prawo.png')); ?>

<div class="objectsPage">
<?= $this->Element('Dane.DataBrowser/browser'); ?>
</div>