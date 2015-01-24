<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('pisma-moje', array('plugin' => 'Pisma'))) ?>

<div class="appHeader">
    <div class="container innerContent">
        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(
            )); ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-md-10 col-md-offset-1">

        <p class="msg-main">
	        To pismo nie istnieje lub nie masz do niego dostępu.
        </p>
        
    </div>
</div>