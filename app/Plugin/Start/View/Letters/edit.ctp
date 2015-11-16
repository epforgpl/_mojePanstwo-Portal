<?php
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.letters.js');

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

echo $this->element('Start.pageBegin'); ?>

<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="col-xs-12 nopadding">
        <div class="alert-identity alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Uwaga!</h4>

            <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                    class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                swoim koncie.</p>
        </div>
    </div>
<? } ?>

<ul class="breadcrumb">
  <li><a href="/moje-pisma">Moje Pisma</a></li>
  <li class="active">Tworzenie nowego pisma</li>
</ul>

<div class="well bs-component mp-form mp-form-letter">
  <form action="/moje-pisma/<?= $pismo['id'] ?>,<?= $pismo['slug'] ?>" method="post" class="form-horizontal">
  <input type="hidden" name="edit_from_inputs" value="1" />
      <fieldset>
       <legend>Wpisz treść pisma:</legend>

      <? if( $pismo['template_id'] ) {?>
      <div class="form-group form-row sm">
        <label class="col-lg-2 control-label">Szablon</label>
        <div class="col-lg-10"><p class="form-value hl"><?= $pismo['template_name'] ?></p></div>
      </div>
      <? } ?>

      <? if( $pismo['to_name'] ) {?>
      <div class="form-group form-row sm">
        <label for="inputEmail" class="col-lg-2 control-label">Adresat</label>
        <div class="col-lg-10"><p class="form-value hl"><?= $pismo['to_name'] ?></p></div>
      </div>
      <? } ?>

      <hr/>

          <?
	  if( $pismo['_inputs'] ) {
	      if( $inputs = $pismo['_inputs'] ) {
		      foreach( $inputs as $input ) {
			      			      
			      $full = true;
				  $v = '';
				  if( $input['value'] )
				  	$v = $input['value'];
				  elseif( $input['default_value'] ) {
					  
				  	$v = $input['default_value'];
				  	
				  	if( 
				  		$v && 
				  		( $v[0]=='$' ) && 
				  		preg_match('/^\$session\[(.*?)\]$/i', $v, $match)
				  	) 
					  	$v = $this->Session->read( $match[1] );					  	
				  		
				  }
				  
				  if( $input['type']=='richtext' ) {
                      ?>
			      <div class="form-group form-row">
			        <label for="inp<?= $input['id'] ?>" class="col-lg-12 control-label control-label-full"><?= $input['label'] ?></label>
					<div class="col-lg-12">
                        <textarea class="form-control tinymceField" rows="10" id="inp<?= $input['id'] ?>"
                                  name="inp<?= $input['id'] ?>"><?= $v ?></textarea>
			          <? if( @$input['desc'] ) {?><span class="help-block"><?= $input['desc'] ?></span><? } ?>
			        </div>
                  </div>
                      <?
				  } elseif( $input['type']=='text' ) {
                      ?>
				  <div class="form-group form-row">
			        <label for="inp<?= $input['id'] ?>" class="<?if($full) {?>col-lg-12 control-label-full<?}else{?>col-lg-2 control-label<?}?>"><?= $input['label'] ?></label>
					<div class="<?if($full) {?>col-lg-12<?}else{?>col-lg-10<?}?>">
			          <input value="<?= $v ?>" type="text" class="form-control" id="inp<?= $input['id'] ?>" name="inp<?= $input['id'] ?>"<? if( @$input['placeholder'] ) {?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
			          <? if( @$input['desc'] ) {?><span class="help-block"><?= $input['desc'] ?></span><? } ?>
			        </div>
			      </div>
                      <?
				  } elseif( $input['type']=='date' ) {
                      ?>
				  <div class="form-group form-row">
			        <label for="inp<?= $input['id'] ?>" class="<?if($full) {?>col-lg-12 control-label-full<?}else{?>col-lg-2 control-label<?}?>"><?= $input['label'] ?></label>
					<div class="<?if($full) {?>col-lg-12<?}else{?>col-lg-10<?}?>">
			          <input value="<?= $v ?>" style="max-width: 130px;" maxlength="10" type="text" class="form-control" id="inp<?= $input['id'] ?>" name="inp<?= $input['id'] ?>"<? if( @$input['placeholder'] ) {?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
			          <? if( @$input['desc'] ) {?><span class="help-block"><?= $input['desc'] ?></span><? } ?>
			        </div>
			      </div>
                      <?
				  } elseif( $input['type']=='email' ) {
                      ?>
				  <div class="form-group form-row">
			        <label for="inp<?= $input['id'] ?>" class="<?if($full) {?>col-lg-12 control-label-full<?}else{?>col-lg-2 control-label<?}?>"><?= $input['label'] ?></label>
					<div class="<?if($full) {?>col-lg-12<?}else{?>col-lg-10<?}?>">
			          <input value="<?= $v ?>" type="text" class="form-control" id="inp<?= $input['id'] ?>" name="inp<?= $input['id'] ?>"<? if( @$input['placeholder'] ) {?> placeholder="<?= $input['placeholder'] ?>"<? } ?>>
			          <? if( @$input['desc'] ) {?><span class="help-block"><?= $input['desc'] ?></span><? } ?>
			        </div>
			      </div>
                      <?
				  }

              }
		  }
	  } else {


      }
          ?>

      <div class="form-group form-row">
          <div class="col-lg-12 text-center">
	          <? if($pismo['saved']) {?>
		          <a href="/moje-pisma/<?= $pismo['id'] ?>,<?= $pismo['slug'] ?>" class="btn btn-md btn-default">Anuluj</a>
		          <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
		            class="icon icon-applications-pisma"></i>Zapisz
			      </button>
		      <? } else { ?>
		      	<button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
		            class="icon icon-applications-pisma"></i>Zapisz i zobacz podgląd pisma
			      </button>
		      <? } ?>
        </div>
      </div>
    </fieldset>
  </form>
</div>


<?= $this->element('Start.pageEnd'); ?>








<? /*
<?php echo $this->Html->css('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min', array('block' => 'cssBlock')); ?>

<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-PL', array('block' => 'scriptBlock')); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<?= $this->element('Start.pageBegin'); ?>

<? echo $this->element('Start.letters-editor', array('title' => isset($pismo['tytul']) ? $pismo['tytul'] : '')); ?>

<?= $this->element('Start.pageEnd'); ?>

*/ ?>
