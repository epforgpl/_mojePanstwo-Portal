<?php $this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v1')); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('htmlexDoc', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'toolbar'); ?>

<?php echo $this->Html->css($document->getCSSLocation()); ?>

<?= $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)) ?>

<? /* <a href="/dane/poslowie/<?= $object->getId() ?>/finanse">Wszystkie wydatki &raquo;</a> */ ?>
    <div class="object-nav">
        <h1 class="title">Wydatki biura poselskiego w <?= $rocznik['rok'] ?> roku</h1>
    </div>

<?
echo $this->Element('docsBrowser/doc', array(
    'document' => $document,
    'documentPackage' => $documentPackage,
));
?>

<?= $this->Element('dataobject/pageEnd') ?>