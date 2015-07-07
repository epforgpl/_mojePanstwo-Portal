<?
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

echo $this->Element('dataobject/pageBegin'); ?>

    <div class="col-md-9 objectMain">
        <div class="block block-simple col-xs-12 dodaj_dzialanie">
            <header>
                Edycja działania
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
                            <div class="image-editor">

                                <div class="cropit-image-preview"></div>
                                <p>Zalecany rozmiar: 874x347</p>
                                <span class="btn btn-default btn-file">Przeglądaj<input type="file"
                                                                                        class="cropit-image-input"/></span>
                                <input type="hidden" type="text" <? if($dzialanie->getData('photo') == '1') { ?>value="http://sds.tiktalik.com/portal/pages/dzialania/<?= $dzialanie->getData('dataset'); ?>/<?= $dzialanie->getData('object_id'); ?>/<?= $dzialanie->getData('id'); ?>.jpg"<? } ?> name="cover_photo"/>
                            </div>
                        </div>
                        <div class="form-group googleBlock">
                            <span class="btn btn-link googleBtn" data-icon="&#xe607;">Dodaj lokalizację</span>

                            <div class="col-xs-12 googleMapElement">
                                <input id="pac-input" class="controls" type="text" placeholder="Szukaj...">

                                <div id="loc" class="btn btn-sm"><i data-icon="&#xe607;"></i></div>

                                <div id="googleMap"></div>
                                <input type="hidden" value="<?= $dzialanie->getData('geo_lat'); ?>" name="geo_lat"/>
                                <input type="hidden" value="<?= $dzialanie->getData('geo_lng'); ?>" name="geo_lng"/>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn btn-warning btn-icon cancelBtn">
                                <i class="icon glyphicon glyphicon-remove"></i>
                                Anuluj
                            </div>
                            <div class="btn btn-primary btn-icon submitBtn" type="submit">
                                <i class="icon glyphicon glyphicon-ok"></i>
                                Zapisz
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

<?= $this->element('dataobject/pageEnd'); ?>