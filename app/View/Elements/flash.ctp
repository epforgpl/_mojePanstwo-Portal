<?php
if ($this->Session->read('Message.flash.message')) {
    $class = $this->Session->read('Message.flash.params.class');
    $close = $this->Session->read('Message.flash.params.close');
    ?>
    <div class="flash-message">
        <div
            class="alert <?php echo($class ? $class : 'alert-info'); ?>">
            <div class="container">
                <?php if (!(isset($close) && $close == false)): ?>
                    <a class="close" data-dismiss="alert" href="#">×</a>
                <?php endif; ?>
                <?php echo $this->Session->flash(); ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php echo $this->fetch('flashBlock'); ?>
