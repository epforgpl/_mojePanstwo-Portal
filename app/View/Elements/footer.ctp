<footer>
    <?= $this->fetch('footerBeginBlock'); ?>

    <?= $this->Element('cross_domain_login'); ?>

    <?php echo $this->Html->link(__('LC_FOOTER_ABOUT_US'), '/oportalu', array('target' => '_self')); ?>
    <?php /*
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_API'), '/api', array('target' => '_self')); ?>
    */ ?>
    <span class="separator">|</span>
    <?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self')); ?>
    <span class="separator">|</span>
    <?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/zglosblad', array('target' => '_self')); ?>
    <?php /*
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_CONTACT_US'), '/kontakt', array('target' => '_self')); ?>
    */ ?>
    <span class="separator">|</span>
    <?php echo $this->Html->link(__('LC_FOOTER_EPF'), 'http://epf.org.pl', array('target' => '_blank')); ?>

    <?= $this->fetch('footerEndBlock'); ?>
</footer>