<?php echo $this->Element('notlogged'); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('login_page')) ?>

<?php echo $this->Session->flash('flash', array('element' => 'alert')); ?>
<?php echo $this->Session->flash('auth', array('element' => 'alert')); ?>

<div class="main">
    <div class="content">
        <div id="modalPaszportLoginForm" class="paszportModal">
            <?= $this->Element('Paszport.modal_login_content'); ?>
        </div>
    </div>
</div>