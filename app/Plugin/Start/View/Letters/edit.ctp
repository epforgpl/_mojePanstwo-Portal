<?php $this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start'))) ?>
<?php $this->Combinator->add_libs('js', 'Start.letters.js') ?>

<?= $this->element('Start.pageBegin'); ?>

<? if (!$this->Session->read('Auth.User.id')) { ?>
    <div class="col-xs-12">
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

<div class="well bs-component mp-form">
  <form action="/moje-pisma" method="post" class="form-horizontal">
  <input type="hidden" name="adresat_id"<?php if (!empty($pismo['adresat_id'])) {
        echo ' value="' . $pismo['adresat_id'] . '"';
    } ?>>
    <fieldset>      
       <legend>Wpisz treść pisma według wybranego szablonu:</legend>
      <div class="form-group form-row sm">
        <label class="col-lg-2 control-label">Szablon</label>
        <div class="col-lg-10"><p class="form-value">Wniosek</p></div>
      </div>
      <div class="form-group form-row sm">
        <label for="inputEmail" class="col-lg-2 control-label">Adresat</label>
        <div class="col-lg-10"><p class="form-value">Kancelaria Prezesa Rady Ministrów</p></div>
      </div>
      <div class="form-group form-row">
        <label for="inputEmail" class="col-lg-12 control-label control-label-full">Jakie informacje chcesz uzyskać?</label>
		<div class="col-lg-12">
          <textarea class="form-control" rows="10" id="textArea"></textarea>
          <span class="help-block">Informacje publiczne to lorem ipsum...</span>
        </div>
      </div>
      <div class="form-group form-row">
        <label for="inputEmail" class="col-lg-2 control-label">Adres e-mail</label>
		<div class="col-lg-10">
          <input type="text" class="form-control" id="inputEmail" placeholder="Email">
          <span class="help-block">Podaj adres e-mail na który chcesz uzyskać odpowiedź.</span>
        </div>
      </div>
      <div class="form-group form-row">
        <div class="col-lg-10 col-lg-offset-2">
          <button type="submit" class="createBtn btn btn-md btn-primary btn-icon"><i
            class="icon icon-applications-pisma"></i>Zobacz podgląd pisma
	      </button>
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