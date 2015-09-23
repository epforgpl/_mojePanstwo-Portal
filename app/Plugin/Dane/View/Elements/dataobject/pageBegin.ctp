<?
$objectOptions = @$this->viewVars['objectOptions'];
/** @var Object $microdata */
$objectOptions['microdata'] = @$microdata;

?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane'))) ?>

<div<? if ($objectOptions['microdata']['itemtype']) { ?> itemscope itemtype="<?= $objectOptions['microdata']['itemtype'] ?>"<? } ?>
    class="objectsPage">

    <div class="objectsPageWindow">
        <div class="container">
            <div class="objectsPageContent main">