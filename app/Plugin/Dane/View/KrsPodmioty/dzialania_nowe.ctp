<?
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5');
$this->Combinator->add_libs('css', '../plugins/aehlke-tag-it/css/jquery.tagit');
$this->Combinator->add_libs('css', '../plugins/aehlke-tag-it/css/tagit.ui-zendesk');

echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/aehlke-tag-it/js/tag-it.min', array('block' => 'scriptBlock'));

$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

echo $this->Element('dataobject/pageBegin'); ?>

    <div class="col-md-9 objectMain">
        <div class="block block-simple col-xs-12 dodaj_dzialanie">
            <header>
                <div>Dodaj nowe działanie swojej organizacji!</div>
            </header>

            <section>
                <div class="col-xs-12">
                    <p>Poinformuj innych o działaniach swojej organizacji. Informacje o działaniach będą widoczne na stronie profilowej Twojej organizacji, a także będą pojawiały się przy wynikach wyszukiwania na portalu mojePaństwo.</p>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="dzialanieTitle">Tytuł</label>
                            <input type="text" class="form-control" id="dzialanieTitle" name="tytul">
                        </div>
                        <div class="form-group">
                            <label for="dzialanieOpis">Opis</label>
                            <textarea class="form-control" id="dzialanieOpis" name="opis"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="dzialanieTagi">Tagi</label>
                            <ul id="dzialanieTagi"></ul>
                        </div>
                        <div class="form-group">
                            <div class="image-editor">

                                <div class="cropit-image-preview"></div>
                                <p>Zalecany rozmiar: 874x347</p>
                                <span class="btn btn-default btn-file">Przeglądaj<input type="file"
                                                                                        class="cropit-image-input"/></span>
                                <input type="hidden" type="text" name="cover_photo"/>
                            </div>
                        </div>
                        <div class="form-group googleBlock">
                            <span class="btn btn-link googleBtn" data-icon="&#xe607;">Dodaj lokalizację</span>

                            <div class="col-xs-12 googleMapElement">
                                <input id="pac-input" class="controls" type="text" placeholder="Szukaj...">

                                <div id="loc" class="btn btn-sm"><i data-icon="&#xe607;"></i></div>

                                <div id="googleMap"></div>
                                <input type="hidden" type="text" name="geo_lat"/>
                                <input type="hidden" type="text" name="geo_lng"/>
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