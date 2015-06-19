<?
$this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzenia-databrowser-fix', array('plugin' => 'Dane')));
?>
<div class="menuTabsCont col-xs-8">
    <?
    echo $this->Element('dataobject/menuTabs', array(
        'menu' => $_menu,
    )); ?>
</div>
