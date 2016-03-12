<?php $this->Combinator->add_libs('css', $this->Less->css('missing')) ?>
<?php
if (!isset($code_desc)) {
    $code_desc = 'Coś poszło nie tak';
}
if (!isset($action)) {
    $action = 'main_page';
}
?>

<div class="objectsPage" style="min-height: 350px;">
	<div class="block missing-msg">
    
    <img src="/icon/error.svg" />
    
    <p class="msg"><?= $message ?></p>
    
    <div class="links">
    	<p><a href="/">Wróć na stronę główną &raquo;</a></p>
    	<p><a href="/pomoc/zglos_blad">Zgłoś błąd &raquo;</a></p>
    </div>
    
    <? /* if (Configure::read('debug') > 0) { ?>
	    <div class="error-description">
	        <h3><?php echo get_class($error); ?></h3>
	
	        <p><?php echo $error->getMessage(); ?></p>
	        <?php echo $this->element('exception_stack_trace'); ?>
	    </div>
	<? } */ ?>
    
    </div>
</div>


