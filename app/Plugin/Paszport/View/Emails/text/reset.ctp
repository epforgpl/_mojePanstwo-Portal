<?php echo __d('paszport', 'LC_PASZPORT_RESET_PASSWORD_INFO'); ?>


<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'forgot'), true) . '?token=' . $hash; ?>
