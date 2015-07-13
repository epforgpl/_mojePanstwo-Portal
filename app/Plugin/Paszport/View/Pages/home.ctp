<?php echo $this->Element('notlogged'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('missing')) ?>

<div class="container">
    <div class="informationBlock needLogin col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
        <div class="col-xs-12 information">
            <div class="info col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
                <i class="icon" data-icon="&#xe60f;"></i>

                <p class="lead text-info"><?php echo __d('paszport', 'LC_PASZPORT_HOME_HEADLINE'); ?></p>

                <p class="lead text-info"><?php echo __d('paszport', 'LC_PASZPORT_HOME_HEADLINE_SECOND'); ?></p>
            </div>
            <p class="text-center">
                <a href="<?php echo $this->Html->url(array(
                    'plugin' => 'paszport',
                    'controller' => 'users',
                    'action' => 'login'
                )); ?>"
                   class="btn btn-primary btn-lg">
                    <?php echo __d('paszport', 'LC_PASZPORT_HOME_LOGIN'); ?>
                </a>
            </p>
        </div>
    </div>
</div>