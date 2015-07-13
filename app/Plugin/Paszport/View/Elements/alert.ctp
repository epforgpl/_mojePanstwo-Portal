<div class="flash-message">
    <div class="alert<?php echo (isset($class)) ? ' ' . $class : null; ?>">
        <div class="container">
            <?php if (isset($close)): ?>
                <a class="close" data-dismiss="alert" href="#">×</a>
            <?php endif; ?>
            <?php echo $message; ?>
        </div>
    </div>
</div>