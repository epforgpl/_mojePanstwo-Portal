<?php $this->Combinator->add_libs('css', $this->Less->css('powiadomienia', array('plugin' => 'Powiadomienia'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('frazy', array('plugin' => 'Powiadomienia'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dane', array('plugin' => 'Powiadomienia'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('tagsInput', array('plugin' => 'Powiadomienia'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))); ?>

<?php echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/scriptaculous/src/scriptaculous', array('block' => 'scriptBlock')); ?>
<?php $this->Combinator->add_libs('js', 'Powiadomienia.powiadomieniaModal.js'); ?>
<?php $this->Combinator->add_libs('js', 'Powiadomienia.powiadomienia.js'); ?>
<?php $this->Combinator->add_libs('js', 'Powiadomienia.tagsInput.js'); ?>

<div id="powiadomienia">
    <div class="content col-xs-12">

        <div class="frazy col-xs-12 col-md-3 pull-left">

            <?php echo $this->element('Powiadomienia.groups-full', array('groups' => $groups)); ?>

        </div>
        <div class="dane col-xs-12 col-md-9 pull-right">

            <?php echo $this->element('Powiadomienia.tabs'); ?>

            <?php echo $this->element('Powiadomienia.objects-container', array('objects' => $objects)); ?>

        </div>

    </div>
</div>