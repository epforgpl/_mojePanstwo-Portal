<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('sejmometr', array('plugin' => 'Sejmometr'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('posiedzenia', array('plugin' => 'Sejmometr'))) ?>

<?php $this->Combinator->add_libs('js', 'Sejmometr.posiedzenia.js'); ?>

<?php echo $this->Html->script('../plugins/TimelineJS/build/js/storyjs-embed.js', array('block' => 'scriptBlock')); ?>

<div id="sejmometr" class="newLayout">
    <div id="timeline-embed" data-source="1">

    </div>
</div>