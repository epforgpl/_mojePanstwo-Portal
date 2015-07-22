<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));

echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

/* tinymce */
echo $this->Html->script('../tinymce/tinymce.min', array('block' => 'scriptBlock'));

/* tag-it */
$this->Combinator->add_libs('css', '../plugins/aehlke-tag-it/css/jquery.tagit');
$this->Combinator->add_libs('css', '../plugins/aehlke-tag-it/css/tagit.ui-zendesk');
$this->Combinator->add_libs('js', '../plugins/aehlke-tag-it/js/tag-it.min');

/* sticky */
$this->Combinator->add_libs('js', 'jquery.sticky');

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');

$edit = isset($dzialanie);

echo $this->Element('dataobject/pageBegin'); ?>

<form class="dzialanie" action="<?= $object->getUrl(); ?>.json" method="post">

    <input type="hidden" name="_action" value="<?= $edit ? 'edit_activity' : 'add_activity'; ?>"/>

    <div class="col-md-9 objectMain">
        <div class="block block-simple col-xs-12 dzialanie">
            <? if($edit) { ?>
                <header>
                    <div class="header">
                        <div class="col-sm-8">
                            <a href="<?= $dzialanie->getUrl() ?>"><?= $dzialanie->getData('tytul'); ?></a>
                        </div>
                    </div>
                </header>
                <div class="row sub-header">
                    <div class="col-sm-6">
                        <span class="date">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            <?= $this->Czas->dataSlownie(
                                $dzialanie->getData('data_utworzenia')
                            ); ?>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="share pull-right"></div>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?= $dzialanie->getData('id'); ?>"/>
            <? } else { ?>
                <header>
                    <div>Dodaj nowe działanie swojej organizacji!</div>
                </header>
            <? } ?>

            <section>
	            <div class="row">
	                <div class="col-xs-12">

	                    <? if(!$edit) { ?>
	                        <p class="margin-top-10">Poinformuj innych o działaniach swojej organizacji. Informacje o działaniach będą widoczne na stronie profilowej Twojej organizacji, a także będą pojawiały się przy wynikach wyszukiwania na portalu mojePaństwo.</p>
	                    <? } ?>
	
	                    <div class="form-group margin-top-10">
	                        <label for="dzialanieTitle">Tytuł</label>
	                        <input maxlength="195" type="text" class="form-control" id="dzialanieTitle" name="tytul" <? if($edit) echo 'value="'.$dzialanie->getData('tytul').'"'; ?>/>
	                    </div>
	                    <div class="form-group">
	                        <label for="dzialanieOpis">Krótkie podsumowanie</label>
	                        <textarea maxlength="511" class="form-control" name="podsumowanie"><? if($edit) echo $dzialanie->getData('podsumowanie'); ?></textarea>
	                    </div>
	                    <div class="form-group">
	                        <label>Tagi</label>
	                        <div class="row tags">
	                            <input type="text" class="form-control tagit" name="tagi" <? if($edit) echo 'value="'.$dzialanie->getData('tagi').'"'; ?>/>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="dzialanieOpis">Opis</label>
	                        <textarea maxlength="16383" class="form-control" id="dzialanieOpis" name="opis">
	                            <? if($edit) echo $dzialanie->getData('opis'); ?>
	                        </textarea>
	                    </div>
	                    <div class="form-group">
	                        <label>Zdjęcie</label>
	                        <div class="image-editor" <? if($edit && isset($dzialanie_photo_base64)) echo 'data-image="'.$dzialanie_photo_base64.'"'; ?>>
	                            <div class="cropit-image-preview"></div>
	                            <div class="slider-wrapper">
	                                <span class="icon icon-small glyphicon glyphicon-tree-conifer"></span>
	                                <input type="range" class="cropit-image-zoom-input" />
	                                <span class="icon icon-large glyphicon glyphicon-tree-conifer"></span>
	                            </div>
	                            <p>Zalecany rozmiar: 810x320px</p>
	                            <span class="btn btn-default btn-file">Przeglądaj<input type="file" class= "cropit-image-input" /></span>
	                        </div>
	                    </div>
	                    <div class="form-group googleBlock">
	                        <span class="btn btn-link googleBtn" data-icon="&#xe607;">
	                            <?= $edit ? 'Zmień' : 'Dodaj'; ?> lokalizację
	                        </span>
	
	                        <div class="col-xs-12 googleMapElement">
	                            <input id="pac-input" class="controls" type="text" placeholder="Szukaj...">
	
	                            <div id="loc" class="btn btn-sm"><i data-icon="&#xe607;"></i></div>
	
	                            <div id="googleMap"></div>
	                            <input type="hidden" <? if($edit) echo 'value="' . $dzialanie->getData('geo_lat') . '"'; ?> type="text" name="geo_lat"/>
	                            <input type="hidden" <? if($edit) echo 'value="' . $dzialanie->getData('geo_lng') . '"'; ?> type="text" name="geo_lng"/>
	                        </div>
	                    </div>
	                </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sticky margin-top-20">
            
            <div class="row">
            
            	<div class="col-md-12">
		            <div class="form-group margin-top-20">
		                <label>Status</label>
		                <div class="row">
		                    <label class="checkbox-label">
		                        <input type="radio" name="status" value="1" <? if (!$edit || ($edit && $dzialanie->getData('status') == '1')) echo 'checked';?>> Opublikowane
		                    </label><br/>
		                    <label class="checkbox-label">
		                        <input type="radio" name="status" value="0" <? if ($edit && $dzialanie->getData('status') == '0') echo 'checked';?>> Brudnopis
		                    </label>
		                </div>
		            </div>
            	</div>
            
	            <div class="col-md-12 margin-top-15">
		            <button class="btn auto-width btn-primary btn-icon submitBtn" type="submit">
		                <i class="icon glyphicon glyphicon-ok"></i>
		                Zapisz
		            </button>
	            </div>
            
	            <? if($edit) { ?>
                    <div class="col-md-12 margin-top-5">
                        <div class="btn btn-link btn-icon btn-auto-width deleteBtn">
                            <i class="icon glyphicon glyphicon-remove"></i>
                            Usuń działanie
                        </div>
                    </div>
	            <? } ?>
	            
	        </div>
	        
        </div>
    </div>

</form>

<?= $this->element('dataobject/pageEnd'); ?>