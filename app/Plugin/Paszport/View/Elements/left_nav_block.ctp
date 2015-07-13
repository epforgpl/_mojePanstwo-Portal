<?php
$inlinejs = '$(document).ready(function(){var current_url = "' . $this->here . '";';
$inlinejs .= "$('a[href=" . '"' . "'+current_url+'" . '"' . "]').parent().addClass('active');})";
$this->Combinator->add_inline_code('js', $inlinejs);
?>

<ul class="userNav nav nav-pills nav-stacked">
    <li <?php echo ($this->request->controller == 'users') ? 'class="active"' : null; ?>><a class="accountInfo"
                                                                                            href="<?php echo $this->Html->url(array(
                                                                                                'plugin' => 'paszport',
                                                                                                'controller' => 'users',
                                                                                                'action' => 'index'
                                                                                            )); ?>"><?php echo __d('paszport', 'LC_PASZPORT_ACCOUNT_INFO'); ?></a>
    </li>
    <!--<li><a class="ourServices" href="<?php /*echo $this->Html->url(array('plugin' => 'passport','controller' => 'services',  'action' => 'index')); */ ?>"><?php /*echo __d('paszport','LC_PASZPORT_OUR_SERVICES'); */ ?></a></li>-->
    <li <?php echo ($this->request->controller == 'keys') ? 'class="active"' : null; ?>><a class="apiKeys"
                                                                                           href="<?php echo $this->Html->url(array(
                                                                                               'plugin' => 'paszport',
                                                                                               'controller' => 'keys',
                                                                                               'action' => 'index'
                                                                                           )); ?>"><?php echo __d('paszport', 'LC_PASZPORT_API_KEYS'); ?></a>
    </li>
    <li <?php echo ($this->request->controller == 'logs') ? 'class="active"' : null; ?>><a class="logs"
                                                                                           href="<?php echo $this->Html->url(array(
                                                                                               'plugin' => 'paszport',
                                                                                               'controller' => 'logs',
                                                                                               'action' => 'index'
                                                                                           )); ?>"><?php echo __d('paszport', 'LC_PASZPORT_LOGS'); ?></a>
    </li>
</ul>