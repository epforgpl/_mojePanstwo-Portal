<script type="text/javascript">
    if (top != self) {
        window.document.write("<div style='background:black; opacity:0.5; filter: alpha (opacity = 50); position: absolute; top:0px; left: 0px;"
        + "width: 9999px; height: 9999px; zindex: 1000001' onClick='top.location.href=window.location.href'></div>");
    }
</script>


<?php
echo $this->Form->create('Authorize');

foreach ($OAuthParams as $key => $value) {
    echo $this->Form->hidden(h($key), array('value' => h($value)));
}
?>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="span9">
                <div class="alert alert-info ">
                    <?php echo __('LC_REQUIRES_PERMISSION %s', array($client['Client']['title'])); ?>
                </div>
            </div>
            <div class="span9">
                <?php
                echo $this->Form->submit(__('LC_AUTHORIZE', true), array(
                    'name' => 'accept',
                    'class' => 'btn btn-success',
                    'div' => false
                ));
                echo $this->Form->submit(__('LC_DENY', true), array(
                    'name' => 'accept',
                    'class' => 'btn btn-danger',
                    'div' => false
                ));
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>