<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('letters-moje', array('plugin' => 'Start'))) ?>

<?= $this->element('Start.pageBegin'); ?>

<div class="col-xs-12">
    <p class="msg-main">
        To pismo nie istnieje lub nie masz do niego dostępu.
    </p>
</div>

<?= $this->element('Start.pageEnd'); ?>
