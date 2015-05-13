<?
$this->Combinator->add_libs('css', $this->Less->css('bdl', array('plugin' => 'Bdl')));

$this->Combinator->add_libs('js', 'Bdl.jstree.min');
$this->Combinator->add_libs('js', 'Bdl.bdl');
?>

<?= $this->Element('appheader'); ?>

<div class="container">
    <div id="tree" data-structure='<?= json_encode($tree) ?>'></div>
</div>