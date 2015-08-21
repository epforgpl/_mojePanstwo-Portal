<?
$this->Combinator->add_libs('css', $this->Less->css('bdl', array('plugin' => 'Bdl')));

echo $this->Html->script('jstree.min', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Bdl.bdl');
?>

<div class="container">
    <div
        id="tree" <?= printf('data-structure="%s"', htmlspecialchars(json_encode($tree), ENT_QUOTES, 'UTF-8')) ?>></div>
</div>
