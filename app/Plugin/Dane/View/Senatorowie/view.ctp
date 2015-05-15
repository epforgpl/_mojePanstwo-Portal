<?php $this->Combinator->add_libs('css', $this->Less->css('view-sptezy', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="object">
        <div class="document col-md-10 col-md-offset-1">
            <?php echo $object->getData('opis'); ?>
        </div>
        <div class="document col-md-10 col-md-offset-1">
            <a href="mailto:<?php echo $object->getData('email'); ?>">
                <?php echo __d('dane', 'LC_DANE_EMAIL_KONTAKTOWY'); ?>
            </a>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>