<?
$this->Combinator->add_libs('css', '//cdnjs.cloudflare.com/ajax/libs/jstree/3.0.9/themes/default/style.min.css');
$this->Combinator->add_libs('js', '//cdnjs.cloudflare.com/ajax/libs/jstree/3.0.9/jstree.min.js');

$this->Combinator->add_libs('css', $this->Less->css('bdl-tree', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.bdl-tree');
?>

<?= $this->Element('appheader'); ?>

<div class="container">
    <div id="tree" data-structure='<?= json_encode($tree) ?>'></div>
</div>