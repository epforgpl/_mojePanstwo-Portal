<footer class="footer">
    <? echo $this->element('Dane.stanczyk_footer'); ?>
    <section class="standard">
        <div class="container">
            <div class="col-xs-12 <?= isset($domainMode) && $domainMode == 'PK' ? 'text-center' : ''; ?>">
                <?php echo $this->Html->link($this->Html->image('Dane.customObject/krakow/logo_stanczyk.png', array('alt' => 'Fundacja Stańczyka', 'style' => 'width: 100px; margin-right: 10px;')), 'http://www.stanczyk.org.pl/', array('target' => '_blank', 'escape' => false, 'class' => 'link-discrete')); ?>
                <?php echo $this->Html->link(__('LC_FOOTER_FAQ'), '/pomoc', array('target' => '_self', 'class' => 'link-discrete')); ?>
                <span class="separator">|</span>
                <?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self', 'class' => 'link-discrete')); ?>
                <span class="separator">|</span>
                <?php echo $this->Html->link(__('LC_FOOTER_PRIVACY'), '/polityka-prywatnosci', array('target' => '_self', 'class' => 'link-discrete')); ?>
                <span class="separator">|</span>
                <?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/pomoc#blad', array('target' => '_self', 'class' => 'link-discrete')); ?>
                <span class="separator">|</span>
                <?php echo $this->Html->link(__('LC_FOOTER_API'), '/api', array('target' => '_self', 'class' => 'link-discrete')); ?>
            </div>
        </div>
    </section>
</footer>
