<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dane', array('plugin' => 'Dane')));

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dane');

$page = $object->getLayer('page');

$description =
    (isset($page['description']) && strlen($page['description']) > 0)
        ? $page['description'] : $object->getData('cel_dzialania');

echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
				
		<div class="well bs-component mp-form">
			<form action="<?= $object->getUrl(); ?>.json" method="post" class="dzialanie form-horizontal">
		
			    <input type="hidden" name="_action" value="save_edit_data_form"/>
			
				<fieldset>      
					<legend>Edytuj dane <?= $object->getDataset() == 'krs_podmioty' ? 'organizacji' : 'urzędu gminy'; ?>:</legend>
					
					<? if($object->getDataset() == 'krs_podmioty') { ?>
					
					<div class="form-group form-row">
				        <label for="descriptionTextArea" class="col-lg-12 control-label control-label-full">Misja organizacji:</label>
						<div class="col-lg-12">
							<textarea class="form-control" rows="10" id="inp1" name="description" id="descriptionTextArea"></textarea>
							<span class="help-block">Misja opis</span>
						</div>
					</div>
					
					<div class="form-group form-row">
		                <label class="col-lg-12 control-label control-label-full">Obszar działania:</label>
						<div class="col-lg-12">
		                <?
		
		                    $obszary = $object->getPage('obszary_dzialan') ? $object->getPage('obszary_dzialan') : array();
		                    $obszary_ids = array_column($obszary, 'id');
		
		                foreach(array(
		                    'działalność charytatywna',
		                    'pomoc społeczna',
		                    'ochrona praw obywatelskich i praw człowieka',
		                    'rozwój przedsiębiorczości',
		                    'nauka, kultura, edukacja',
		                    'ekologia',
		                    'działalność międzynarodowa',
		                    'aktywność społeczna',
		                    'sport, turystyka',
		                    'bezpieczeństwo publiczne',
		                    'inne',
		                    'uchodźcy'
		                ) as $i => $field) { ?>
		                    <div class="checkbox col-sm-6">
		                        <label>
		                            <input name="areas[]" type="checkbox" value="<?= ($i + 1) ?>" <? if(in_array($i + 1, $obszary_ids)) echo 'checked'; ?>>
		                            <?= ucfirst($field) ?>
		                        </label>
		                    </div>
		                <? } ?>
						</div>
		
		            </div>
		            
		            
		            <div class="form-group form-row">
                        <label class="col-lg-12 control-label control-label-full" for="phoneNumber">Numer telefonu:</label>
                        <div class="col-lg-12"><input maxlength="195" type="text" class="form-control" id="phoneNumber" name="phone" <? if($object->getPage('phone')) echo 'value="'.$object->getPage('phone').'"'; ?>/></div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-lg-12 control-label control-label-full" for="emailAddress">Adres e-mail:</label>
                        <div class="col-lg-12"><input maxlength="195" type="text" class="form-control" id="emailAddress" name="email" <? if($object->getPage('email')) echo 'value="'.$object->getPage('email').'"'; ?>/></div>
                    </div>

                    <div class="form-group form-row">
                        <label class="col-lg-12 control-label control-label-full" for="www">Adres strony WWW:</label>
                        <div class="col-lg-12"><input maxlength="195" type="text" class="form-control" id="www" name="www" <? if($object->getPage('www')) echo 'value="'.$object->getPage('www').'"'; ?>/></div>
                    </div>

                    <? foreach(array(
                        'facebook',
                        'twitter',
                        'instagram',
                        'youtube',
                        'vine'
                    ) as $i => $field) { ?>
                        <div class="form-group form-row">
                        <label class="col-lg-12 control-label control-label-full" for="<?= $field ?>">Profil <?= ucfirst($field) ?>:</label>
                        <div class="col-lg-12"><input maxlength="195" type="text" class="form-control" id="<?= $field ?>" name="<?= $field ?>" <? if($object->getPage($field)) echo 'value="'.$object->getPage($field).'"'; ?>/></div>
                        </div>
                    <? } ?>
					
					<? } ?>
					
					<div class="form-group form-row">
						<div class="col-lg-12 text-center">
							<a class="btn btn-default" type="cancel" href="<?= $object->getUrl() ?>">
	                            Anuluj
	                        </a>
							<button class="btn auto-width btn-primary btn-icon submitBtn" type="submit">
	                            <i class="icon glyphicon glyphicon-ok"></i>
	                            Zapisz
	                        </button>
						</div>
					</div>
					
				</fieldset>
				
			</form>
		</div>
		
	</div>
</div>


<? /*
<form class="dzialanie" action="" method="post">


    <div class="row">
        <div class="col-md-9">

            <div class="block block-simple col-xs-12 dzialanie objectMain">
                <section>
                    <div class="row">
                        <div class="col-xs-12">


                            

                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div class="col-md-3">
            <div class="sticky margin-top-20">
                <div class="row">
                    <div class="col-md-12 margin-top-10">

                        

                        <? if($object->getDataset() == 'krs_podmioty') { ?>
                            <br/>
                            <div data-opis="<?= $object->getData('cel_dzialania') ?>" class="btn auto-width btn-link btn-icon btnImport margin-top-5">
                                <i class="icon glyphicon glyphicon-download"></i>
                                Zaimportuj z KRS
                            </div>
                        <? } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
*/ ?>


<?= $this->element('dataobject/pageEnd'); ?>
