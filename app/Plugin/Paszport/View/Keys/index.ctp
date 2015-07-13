<?php echo $this->Element('logged'); ?>

<div class="container userCenter">
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <?php echo $this->element('left_nav_block'); ?>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h3><?php echo __d('paszport', $title_for_layout); ?></h3>


            <div class="row controlsPanel">
                <div class="col-sm-12">
                    <a class="btn btn-default" href="<?php echo $this->Html->url(array('action' => 'add')); ?>">
                        <?php echo __d('paszport', 'LC_PASZPORT_ADD_KEY'); ?>
                    </a>
                </div>
            </div>

            <table class="keys table table-striped">
                <tr>
                    <th><?php echo __d('paszport', 'LC_PASZPORT_API_KEY'); ?></th>
                    <th><?php echo __d('paszport', 'LC_PASZPORT_CREATED'); ?></th>
                    <th></th>
                </tr>
                <?php foreach ($this->data as $key) { ?>
                    <tr>
                        <td><?php echo $key['Key']['key']; ?></td>
                        <td><?php echo $this->Time->timeAgoInWords($key['Key']['created']); ?></td>
                        <td><a href="<?php echo $this->Html->url(array(
                                'action' => 'delete',
                                $key['Key']['id']
                            )); ?>"
                               class="btn btn-danger pull-right"><?php echo __d('paszport', 'LC_PASZPORT_DELETE'); ?></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>
</div>