<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));
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
        <div class="block block-simple col-xs-12">
            <? if($edit) { ?>
                <header>
                    Edycja działania
                    <div class="btn btn-danger btn-icon btn-auto-width pull-right" data-action="delete" data-id="<?= $dzialanie->getData('id'); ?>">
                        <i class="icon glyphicon glyphicon-remove"></i>
                        Usuń
                    </div>
                </header>
                <input type="hidden" name="id" value="<?= $dzialanie->getData('id'); ?>"/>
            <? } else { ?>
                <header>
                    <div>Dodaj nowe działanie swojej organizacji!</div>
                </header>
            <? } ?>

            <section>
                <div class="col-xs-12">

                    <? if(!$edit) { ?>
                        <p>Poinformuj innych o działaniach swojej organizacji. Informacje o działaniach będą widoczne na stronie profilowej Twojej organizacji, a także będą pojawiały się przy wynikach wyszukiwania na portalu mojePaństwo.</p>
                    <? } ?>

                    <div class="form-group">
                        <label for="dzialanieTitle">Tytuł</label>
                        <input maxlength="195" type="text" class="form-control" id="dzialanieTitle" name="tytul" <? if($edit) echo 'value="'.$dzialanie->getData('tytul').'"'; ?>/>
                    </div>
                    <div class="form-group">
                        <label for="dzialanieOpis">Opis</label>
                        <textarea maxlength="16383" class="form-control" id="dzialanieOpis" name="opis">
                            <? if($edit) echo $dzialanie->getData('opis'); ?>
                        </textarea>
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
            </section>
        </div>
    </div>
    <div class="col-md-3">
        <div class="sticky margin-top-20">
            <button class="btn auto-width btn-primary btn-icon submitBtn" type="submit">
                <i class="icon glyphicon glyphicon-ok"></i>
                Zapisz
            </button>
            <div class="form-group margin-top-10">
                <label>Status</label>
                <div class="row">
                    <label class="radio-inline">
                        <input type="radio" name="status" value="1" <? if (!$edit || ($edit && $dzialanie->getData('status') == '1')) echo 'checked';?>> Opublikowane
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" value="0" <? if ($edit && $dzialanie->getData('status') == '0') echo 'checked';?>> Brudnopis
                    </label>
                </div>
            </div>
        </div>
    </div>

</form>

<?= $this->element('dataobject/pageEnd'); ?>