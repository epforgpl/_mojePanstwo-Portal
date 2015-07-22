<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>

<div class="objectsPage fullPageHeight">
    <div id="modalPaszportLoginForm" class="paszportModal">
        <?= $this->Element('Paszport.modal_login_content'); ?>
    </div>
</div>