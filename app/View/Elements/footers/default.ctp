<footer class="footer">
    <? if (isset($object) && (($object->getDataset() == 'gminy') && ($object->getId() == '903'))) {
        echo $this->element('Dane.stanczyk_footer');
    } ?>

    <section class="standard">
        <div class="container">
            <div class="col-xs-12 text-center">
                <a class="" href="/dane/krs_podmioty/359730,fundacja-epanstwo">&copy; 2016 Fundacja ePaństwo</a>
                <span class="separator">&mdash;</span>
                <?php echo $this->Html->link(__('LC_FOOTER_ABOUT_US'), '/oportalu', array('target' => '_self', 'class' => '')); ?>
                <span class="separator">&mdash;</span>
                <?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self', 'class' => '')); ?>
                <span class="separator">&mdash;</span>
                <?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/zglosblad', array('target' => '_self', 'class' => '')); ?>
                <span class="separator">&mdash;</span>
                <?php echo $this->Html->link(__('LC_FOOTER_API'), '/api', array('target' => '_self', 'class' => '')); ?>
            </div>
        </div>
    </section>
</footer>
