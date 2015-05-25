<footer>
    <section class="standard">
        <div class="container">
            <div class="left col-xs-12 col-md-8">
                <ul>
                    <li>Aplikacje
                        <ul>
                            <? foreach ($_applications as $a) {
                                if ($a['tag'] == 1) { ?>
                                    <li><a href="<?= $a['href'] ?>" target="_self"><?= $a['name'] ?></a></li>
                                <? }
                            } ?>
                        </ul>
                    </li>
                    <li>Raporty
                        <ul>
                            <? foreach ($_applications as $a) {
                                if ($a['tag'] == 2) { ?>
                                    <li><a href="<?= $a['href'] ?>" target="_self"><?= $a['name'] ?></a></li>
                                <? }
                            } ?>
                        </ul>
                    </li>
                    <li><a href="/dane" target="_self"><?php echo __('LC_COCKPITBAR_USER_PUBLIC_DATA'); ?></a></li>
                    <li><a href="/moje-dane" target="_self"><?php echo __('LC_COCKPITBAR_USER_MY_DATA'); ?></a></li>
                    <li><a href="/moje-pisma" target="_self"><?php echo __('LC_COCKPITBAR_USER_MY_DOCS'); ?></a></li>
                </ul>
            </div>
            <div class="right col-xs-12 col-md-4">
                <?php echo $this->Html->link($this->Html->image('logo-epanstwo-white.svgz', array('alt' => __('LC_FOOTER_EPF'))), 'http://epf.org.pl', array('target' => '_blank', 'escape' => false)); ?>
                <?php echo $this->Html->link(__('LC_FOOTER_REPORT_BUG'), '/zglosblad', array('target' => '_self')); ?>
                <span class="separator">|</span>
                <?php echo $this->Html->link(__('LC_FOOTER_REGULATIONS'), '/regulamin', array('target' => '_self')); ?>
                <span class="separator">|</span>
                <?php echo $this->Html->link(__('LC_FOOTER_ABOUT_US'), '/oportalu', array('target' => '_self')); ?>
            </div>
        </div>
    </section>
</footer>