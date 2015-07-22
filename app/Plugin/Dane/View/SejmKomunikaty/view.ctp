<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejmkomunikaty', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="object">
        <div class="document col-md-10 col-md-offset-1">
            <? if ($object->getData('img') == '1') { ?>
                <img class="imgInside" onerror="imgFixer(this)"
                     src="http://resources.sejmometr.pl/sejm_komunikaty/img/<?= $object->getId() ?>-0.jpg"
                     align="right"/>
            <? } ?>
            <?php echo $content; ?>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>