<?
$this->Combinator->add_libs('css', $this->Less->css('bdl', array('plugin' => 'Statystyka')));

$this->Combinator->add_libs('js', 'Statystyka.jstree.min');
$this->Combinator->add_libs('js', 'Statystyka.bdl');
?>

<?= $this->Element('appheader'); ?>

<div class="container">
    <div id="tree" data-structure='<?= json_encode($tree) ?>'></div>
</div>