<?php echo $this->Html->css('/plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min', array('block' => 'cssBlock')); ?>

<?php echo $this->Html->script('/plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('/plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-PL', array('block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.jquery.autosize.min.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.jquery_steps.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<?php
if (!empty($pismo['szablon_id'])) {
    $pismo_init['szablon_id'] = $pismo['szablon_id'];
}
if (!empty($pismo['adresat_id'])) {
    $pismo_init['adresat_id'] = $pismo['adresat_id'];
}
?>

<div class="container editPage">
    
    <? echo $this->element('Pisma.pismo-header', array(
		'pismo' => $pismo,
		'alert' => true,
        'editable' => true
	)); ?>

    <div id="stepper" class="stepper"<? if (!empty($pismo_init)) {
        echo ' data-pismo=' . json_encode($pismo_init);
    } ?> data-status-check="<?= $pismo['saved'] ?>">

        <h2>Wybierz szablon i adresata</h2>
        <section>
            <div class="container start">
                <div class="col-xs-12">
                    <form class="letter form-horizontal">
                        <?php echo $this->element('Pisma.start') ?>
                        <fieldset class="final">
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-1 text-center">
                                    <button type="submit" class="btn btn-md btn-default">Wróć do edycji treści pisma
                                        <span class="glyphicon glyphicon-play"></span>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>

        <h2>Wpisz treść</h2>
        <section>
            <div class="container edit">
                <div class="editor-container row">
                    <div class="col-xs-12 col-md-10">
                        <? echo $this->Element('Pisma.render', array('pismoEditPage' => true)); ?>
                    </div>
                    <div class="col-xs-12 col-md-2 nopadding">
                        <div class="editor-tooltip">
                            
                            <ul class="form-buttons">
                                <li class="inner-addon left-addon">
	                                <form class="form-save" method="post" action="/pisma/<?=$pismo['alphaid']?>,<?=$pismo['slug']?>">
	                                    <i class="glyphicon glyphicon-save"></i>
                                        <input type="submit" class="btn btn-primary action savePismo" name="_save"
                                               value="Zapisz"/>
	                                    <input type="hidden" name="save" value="1" />
	                                    <p class="desc">Po zapisaniu będziesz mógł wysłać bądź udostępnić pismo.</p>
	                                </form>
                                </li>
                                <? if( isset($pismo['saved']) && $pismo['saved'] ) {?>
                                <li class="inner-addon">
                                    <a href="/pisma/<?= $pismo['alphaid'] ?>,<?= $pismo['slug'] ?>" class="btn btn-default" name="cancel">Anuluj edycję</a>
                                </li>
                                <? } ?>
                            </ul>
                            
                            <ul class="form-buttons more-buttons-target" style="display: none;">
		                        <li class="inner-addon left-addon">
			                        <form onsubmit="return confirm('Czy na pewno chcesz usunąć to pismo?');" method="post" action="/pisma/<?=$pismo['alphaid']?>,<?=$pismo['slug']?>">
										<i class="glyphicon glyphicon-trash"></i>
										<input name="delete" type="submit" class="form-control btn btn-danger" value="Skasuj" />
				                    </form>
		                        </li>
		                    </ul>
		                    
		                    <p class="more-buttons-switcher-cont">
			                    <a class="more-buttons-switcher" data-mode="more" href="#more"><span class="glyphicon glyphicon-chevron-down"></span> <span class="text">Więcej</span></a>
			                </p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>