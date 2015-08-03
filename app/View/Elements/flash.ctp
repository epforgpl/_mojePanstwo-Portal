<?php if ($this->Session->read('Message.flash.message')) { ?>
    <div class="flash-message">
        <div class="alert <?php echo (isset($class)) ? $class : 'alert-info'; ?>">
            <div class="container">
                <?php if (isset($close) || @$this->Session->read('Message.flash.params.close')): ?>
                    <a class="close" data-dismiss="alert" href="#">×</a>
                <?php endif; ?>
                <?php echo $this->Session->flash(); ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($this->Session->read('Message.auth.message')) { ?>
    <div class="flash-message">
        <div class="alert <?php echo (isset($class)) ? $class : 'alert-info'; ?>">
            <div class="container">
                <?php if (isset($close)): ?>
                    <a class="close" data-dismiss="alert" href="#">×</a>
                <?php endif; ?>
                <?php echo $this->Session->flash('auth'); ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php echo $this->fetch('flashBlock'); ?>