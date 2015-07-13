<p><?php echo __d('passport', 'LC_RESET_PASSWORD_INFO'); ?></p>
<p><?php echo $this->Html->link($this->Html->url(array(
            'controller' => 'users',
            'action' => 'forgot'
        ), true) . '?token=' . $hash, $this->Html->url(array(
            'controller' => 'users',
            'action' => 'forgot'
        ), true) . '?token=' . $hash); ?></p>
