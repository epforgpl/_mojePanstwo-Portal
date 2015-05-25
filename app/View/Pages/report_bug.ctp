<?php $this->Combinator->add_libs('css', $this->Less->css('report_bug')) ?>

<div id="reportBug" class="container">
    <div class="col-xs-12 col-md-8">
        <div class="block">
            <header>Zgłoś błąd</header>
            <section>
                <p><?= __('LC_REPORTBUG_HEADLINE') ?></p>
                <?php echo $this->Html->link('<i class="fa fa-github"></i>' . __('LC_REPORTBUG_VIA_GITHUB'), 'https://github.com/epforgpl/_mojePanstwo-Portal/issues?state=open', array(
                    'class' => 'btn btn-social btn-github btn-lg',
                    'target' => '_blank',
                    'escape' => false
                )); ?>
            </section>
        </div>
    </div>
</div>