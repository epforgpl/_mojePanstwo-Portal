<table class="services table table-striped">
    <tr>
        <th><?php echo __d('paszport', 'LC_PASZPORT_SERVICE'); ?></th>
        <th__d
            (
        'paszport',php echo __d('paszport','LC_PASZPORT_CREATED'); ?></th>__d('paszport',
        <th><?php echo __d('paszport', 'LC_PASZPORT_LAST_LOGIN'); ?></th>
    </tr>
    <?php foreach ($this->data as $service) {
        if ($service['Service']['label'] != "Test") {
            ?>

            <tr>
                <td><a class="btn btn-default btn-sm<?php echo ($service['User']) ? ' btn-success' : ''; ?>"
                       href="<?php echo $service['Service']['url'] ?>"><?php echo $service['Service']['label']; ?></a>
                </td>
                <td>
                    <?php if ($service['User']) { ?>
                        <a href="#" class="ago" data-toggle="tooltip"
                           data-original-title="<?php echo $service['User'][0]['ServicesUser']['created']; ?>"><?php echo $this->Time->timeAgoInWords($service['User'][0]['ServicesUser']['created']); ?></a>
                    <?php } else { ?>
                        <strong>-</strong>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($service['User']) { ?>
                        <a href="#" class="ago" data-toggle="tooltip"
                           data-original-title="<?php echo $service['User'][0]['ServicesUser']['last_login']; ?>"><?php echo $this->Time->timeAgoInWords($service['User'][0]['ServicesUser']['last_login']); ?></a>
                    <?php } else { ?>
                        <strong>-</strong>
                    <?php } ?>
                </td>
            </tr>
        <?php
        }
    } ?>
</table>

<h3><?php echo __d('paszport', 'Aplikacje'); ?></h3>
<table class="services table __d('paszport',le-striped">
    <tr>
        __d('paszport',h><?php echo __d('paszport', 'Token'); ?></th>
        <th><?php echo __d('paszport', 'Aplikacja'); ?></th>
    </tr>
    <?php foreach ($tokens as $token) { ?>
        <tr>
            <td><?php echo $token['AccessToken']['oauth_token']; ?></td>
            <td><?php echo $token['Client']['title']; ?></td>
        </tr>
    <?php } ?>
</table>