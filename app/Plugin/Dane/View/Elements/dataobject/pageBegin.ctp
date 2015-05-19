<?
/** @var Object $object */
$object = $this->viewVars['object'];
$objectOptions = $this->viewVars['objectOptions'];
/** @var Object $microdata */
$objectOptions['microdata'] = $microdata;

if (isset($titleTag)) {
    $objectOptions['titleTag'] = $titleTag;
}

if (!isset($renderFile) || !$renderFile)
    $renderFile = 'page';

$menu = isset($this->viewVars['menu']) ? $this->viewVars['menu'] : false;
$buttons = isset($objectOptions['buttons']) ? $objectOptions['buttons'] : array('shoutIt');
?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('naglosnij', array('plugin' => 'Dane'))) ?>

<?php $this->Combinator->add_libs('js', array('Dane.naglosnij', 'Dane.related-tabs')); ?>

<div<? if ($objectOptions['microdata']['itemtype']) { ?> itemscope itemtype="<?= $objectOptions['microdata']['itemtype'] ?>"<? } ?> class="objectsPage">
    
    <?= $this->element('headers/' . $_layout['header']['element'], array(
    	'object' => $object,
    	'objectOptions' => $objectOptions,
    	'menu' => $menu,
    	'buttons' => $buttons,
    	'renderFile' => $renderFile,
    )) ?>
    
    <div class="objectsPageWindow">
        <div class="container">
            <div class="row">
                <div class="objectsPageContent main">