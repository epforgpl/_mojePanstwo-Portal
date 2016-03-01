<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dane', array('plugin' => 'Dane')));

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dane');

/* tag-it */
echo $this->Html->script('../plugins/tag-it/js/tag-it.min', array('block' => 'scriptBlock'));
echo $this->Html->css('../plugins/tag-it/css/jquery.tagit.css');
echo $this->Html->css('../plugins/tag-it/css/tagit.ui-zendesk.css');

$page = $object->getLayer('page');

$tagsLayer = $object->getLayer('tags');
$tags = false;
if($tagsLayer)
	$tags = @array_column($tagsLayer, 'q');

$description =
    (isset($page['description']) && strlen($page['description']) > 0)
        ? $page['description'] : $object->getData('cel_dzialania');

echo $this->Element('dataobject/pageBegin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-10 col-md-offset-1">
		<div class="well bs-component mp-form">
			<form action="<?= $object->getUrl(); ?>.json" method="post" class="dzialanie form-horizontal">
			    <input type="hidden" name="_action" value="save_edit_data_form"/>
                <fieldset>
					<legend>Edytuj dane <?= $object->getDataset() == 'krs_podmioty' ? 'organizacji' : 'urzędu gminy'; ?>:</legend>

					<? if($object->getDataset() == 'krs_podmioty') { ?>

					<div class="form-group form-row">
				        <label for="descriptionTextArea" class="col-lg-12 control-label control-label-full">Misja organizacji:</label>


                        <div class="col-lg-12">
                            <textarea class="form-control tinymceField" rows="10" id="inp1" name="description"
                                      id="descriptionTextArea"><?= $object->getPage('description') ? $object->getPage('description') : $object->getData('cel_dzialania') ?></textarea>
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
                                <input id="area_<?= ($i + 1) ?>" name="areas[]" type="checkbox"
                                       value="<?= ($i + 1) ?>" <? if (in_array($i + 1, $obszary_ids)) echo 'checked'; ?>>
                                <label for="area_<?= ($i + 1) ?>"><?= ucfirst($field) ?></label>
		                    </div>
		                <? } ?>
						</div>

                        </div>


					<div class="form-group form-row">
						<label class="col-lg-12 control-label control-label-full" for="tags">Słowa kluczowe:</label>
						<div class="col-lg-12 tags">
							<input
								id="tags"
								type="text"
								class="form-control tagit"
								name="tagi"
								<? if (isset($tags) && is_array($tags) && count($tags)) printf('data-value="%s"', htmlspecialchars(json_encode($tags), ENT_QUOTES, 'UTF-8')) ?>/>
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


						<? if(in_array($object->getData('forma_prawna_id'), array('1', '15'))) { ?>
							<? $bankAccount = $object->getLayer('bank_account'); ?>
							<div class="form-group form-row">
								<label class="col-lg-12 control-label control-label-full" for="bankAccountNumber">Numer konta bankowego:</label>
								<div class="col-lg-12">
									<? if($bankAccount && $bankAccount['status'] == '0') { ?>
										<input
											disabled
											type="text"
											class="form-control"
											value="<?= $bankAccount['bank_account'] ?>"
											id="bankAccountNumber"
											name="bank_account_number"/>
										<p class="help-block">
											Podane przez Ciebie konto bankowe oczekuje na moderacje.
										</p>
									<? } else { ?>
										<input
											type="text"
											class="form-control"
											id="bankAccountNumber"
											<?= $bankAccount ? 'value="' . $bankAccount['bank_account'] . '"' : '' ?>
											name="bank_account_number"/>

											<? if(!$bankAccount) { ?>

											<? } elseif($bankAccount['status'] == '1') { ?>
												<p class="text-success margin-top-5">Podane wyżej konto zostało zaakceptowane. Pamiętaj, że każda kolejna zmiana podlega ponownej weryfikacji.</p>
											<? } elseif($bankAccount['status'] == '2') { ?>
												<p class="text-danger margin-top-5">Podane wyżej konto zostało odrzucone. Podaj prawidłowy numer konta bądź skontaktuj się z nami w celu rozwiązania problemu.</p>
										<? } ?>

										<p class="help-block">Numer rachunku musi składać się z 26 cyfr. Podczas każdej aktualizacji numeru konta bankowego podlega on weryfikacji przez administratora (w ciągu 1-3 dni roboczych).</p>
									<? } ?>
								</div>
							</div>
						<? } ?>

                    <? } ?>

                    <div class="form-group form-row">
						<div class="col-lg-12 text-center">
							<a class="btn btn-default" type="cancel" href="<?= $object->getUrl() ?>">
	                            Anuluj
	                        </a>
                            <button class="btn width-auto btn-primary btn-icon submitBtn" type="submit">
                                <span class="icon glyphicon glyphicon-ok"></span>
	                            Zapisz
	                        </button>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>


<?= $this->element('dataobject/pageEnd'); ?>
