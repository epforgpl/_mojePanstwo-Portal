<?php echo $this->Element('logged'); ?>

<div class="container userCenter">
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <?php echo $this->element('left_nav_block'); ?>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h3><?php echo __d('paszport', $title_for_layout); ?></h3>

            <table class="logs table table-striped">
                <tr>
                    <th><?php echo __d('paszport', 'LC_PASZPORT_CREATED'); ?></th>
                    <th><?php echo __d('paszport', 'LC_PASZPORT_ACTION'); ?></th>
                    <th><?php echo __d('paszport', 'LC_PASZPORT_IP'); ?></th>
                    <th><?php echo __d('paszport', 'LC_PASZPORT_ADDITIONAL_INFO'); ?></th>
                </tr>
                <?php foreach ($this->data as $log) { ?>
                    <tr>
                        <td><a href="#" class="ago" data-toggle="tooltip"
                               data-original-title="<?php echo $log['Log']['created']; ?>"><?php echo $this->Time->timeAgoInWords($log['Log']['created']); ?></a>
                        </td>
                        <td><?php $logsName = explode(";", $log['Log']['msg']);
                            if (__d('paszport', $logsName[0]) == $logsName[0]) {
                                echo __d('paszport', substr_replace($logsName[0], "LC_PASZPORT", 0, 2));
                            } else {
                                echo __d('paszport', $logsName[0]);
                            }

                            if (count($logsName) != 1) {
                                $logsNameDetails = explode(":", $logsName[1]);
                                $logsNameDetails[0] = preg_replace('/\s+/', '', $logsNameDetails[0]);

                                echo ' ' . __d('paszport', "LC_PASZPORT_DETAIL_" . strtoupper($logsNameDetails[0])) . ': ';
                                if ($logsNameDetails[0] == 'personal_gender') {
                                    if ($logsNameDetails[1] == 0)
                                        echo __d('paszport', 'LC_PASZPORT_DETAIL_PERSONAL_GENDER_WOMEN');
                                    else
                                        echo __d('paszport', 'LC_PASZPORT_DETAIL_PERSONAL_GENDER_MEN');
                                } else {
                                    echo $logsNameDetails[1];
                                }
                            } ?></td>
                        <td><?php echo $log['Log']['ip']; ?></td>
                        <td><?php echo $log['Log']['user_agent']; ?></td>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>
</div>