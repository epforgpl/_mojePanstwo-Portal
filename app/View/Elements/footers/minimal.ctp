<footer class="footer">
    <section class="minimal">
        <?php echo $this->Html->link(__('LC_FOOTER_ABOUT_US'), '/oportalu', array('target' => '_self')); ?>
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_FAQ'), '/pomoc', array('target' => '_self')); ?>
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self')); ?>
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_PRIVACY'), '/polityka-prywatnosci', array('target' => '_self')); ?>
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/pomoc#blad', array('target' => '_self')); ?>
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_API'), '/api', array('target' => '_self')); ?>
        <span class="separator">|</span>
        <?php echo $this->Html->link(__('LC_FOOTER_EPF'), 'http://epf.org.pl', array('target' => '_blank')); ?>
    </section>
</footer>
