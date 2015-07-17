<?
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));

/* bootstrap3-wysihtml5
$this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5');
echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock'));
*/

/* tinymce */
echo $this->Html->script('../tinymce/tinymce.min', array('block' => 'scriptBlock'));


$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

/* tag-it */
$this->Combinator->add_libs('css', '../plugins/aehlke-tag-it/css/jquery.tagit');
$this->Combinator->add_libs('css', '../plugins/aehlke-tag-it/css/tagit.ui-zendesk');
$this->Combinator->add_libs('js', '../plugins/aehlke-tag-it/js/tag-it.min');

echo $this->Element('dataobject/pageBegin'); ?>

    <div class="col-md-9 objectMain">
        <div class="block block-simple col-xs-12 dodaj_dzialanie">
            <header>
                Edycja działania
                <div class="btn btn-danger btn-icon btn-auto-width pull-right" data-action="delete" data-id="<?= $dzialanie->getData('id'); ?>">
                    <i class="icon glyphicon glyphicon-remove"></i>
                    Usuń
                </div>
            </header>
            <section>
                <div class="col-xs-12">
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?= $dzialanie->getData('id'); ?>"/>
                        <div class="form-group">
                            <label for="dzialanieTitle">Tytuł</label>
                            <input type="text" class="form-control" value="<?= $dzialanie->getData('tytul'); ?>" id="dzialanieTitle" name="tytul">
                        </div>
                        <div class="form-group">
                            <label for="dzialanieOpis">Opis</label>
                            <textarea class="form-control" id="dzialanieOpis" name="opis"><?= $dzialanie->getData('opis'); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tagi</label>
                            <div class="row tags">
                                <input type="text" class="form-control tagit" value="<?= $dzialanie->getData('tagi'); ?>" name="tagi"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Zdjęcie</label>
                            <div class="image-editor" data-image="<?= isset($dzialanie_photo_base64) ? $dzialanie_photo_base64 : ''; ?>">
                                <div class="cropit-image-preview"></div>
                                <div class="slider-wrapper">
                                    <span class="icon icon-small glyphicon glyphicon-tree-conifer"></span>
                                    <input type="range" class="cropit-image-zoom-input" />
                                    <span class="icon icon-large glyphicon glyphicon-tree-conifer"></span>
                                </div>
                                <p>Zalecany rozmiar: 810x320px</p>
                                <span class="btn btn-default btn-file">Przeglądaj<input type="file" class= "cropit-image-input" /></span>
                            </div>
                            <!--<div class="image-editor">

                                <div class="cropit-image-preview"></div>
                                <p>Zalecany rozmiar: 874x347</p>
                                <span class="btn btn-default btn-file">Przeglądaj<input type="file"
                                                                                        class="cropit-image-input"/></span>
                                <input type="hidden" type="text" <? if(isset($dzialanie_photo_base64)) { ?>value="<?= $dzialanie_photo_base64; ?>"<? } ?> name="cover_photo"/>
                            </div>-->
                        </div>
                        <div class="form-group googleBlock">
                            <span class="btn btn-link googleBtn" data-icon="&#xe607;">Zmień lokalizację</span>

                            <div class="col-xs-12 googleMapElement">
                                <input id="pac-input" class="controls" type="text" placeholder="Szukaj...">

                                <div id="loc" class="btn btn-sm"><i data-icon="&#xe607;"></i></div>

                                <div id="googleMap"></div>
                                <input type="hidden" value="<?= $dzialanie->getData('geo_lat'); ?>" name="geo_lat"/>
                                <input type="hidden" value="<?= $dzialanie->getData('geo_lng'); ?>" name="geo_lng"/>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn btn-primary btn-icon submitBtn" type="submit">
                                <i class="icon glyphicon glyphicon-ok"></i>
                                Zapisz
                            </div>
                            <div class="btn btn-link cancelBtn">
                                Anuluj
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

<?= $this->element('dataobject/pageEnd'); ?>