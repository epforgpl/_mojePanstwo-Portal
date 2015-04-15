<footer>
    <? if (isset($crossdomain_login_token)) { ?>
    <img src="http://przejrzystykrakow.pl/cross-domain-login?token=<? echo $crossdomain_login_token; ?>">
    <? } ?>
    <?php echo $this->Html->link(__('LC_FOOTER_ABOUT_US'), '/oportalu', array('target' => '_self')); ?>
    <span class="separator">|</span>
    <?php /*echo $this->Html->link(__('LC_FOOTER_API'), '/api', array('target' => '_self')); */ ?><!--
            <span class="separator">|</span>-->
    <?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self')); ?>
    <span class="separator">|</span>
    <?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/zglosblad', array('target' => '_self')); ?>
    <? /*
            <span class="separator">|</span>
            <?php echo $this->Html->link(__('LC_FOOTER_CONTACT_US'), '/kontakt', array('target' => '_self')); ?>
        */ ?>
    <span class="separator">|</span>
    <?php echo $this->Html->link(__('LC_FOOTER_EPF'), 'http://epf.org.pl', array('target' => '_blank')); ?>
</footer>