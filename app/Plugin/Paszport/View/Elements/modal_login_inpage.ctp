<?php $this->Combinator->add_libs('css', $this->Less->css('paszport', array('plugin' => 'Paszport'))) ?>

<div class="objectsPage">
    <div id="modalPaszportLoginForm" class="paszportModal inpage">
        <?= $this->Element('Paszport.modal_login_content', array('close' => false)); ?>
    </div>
</div>
