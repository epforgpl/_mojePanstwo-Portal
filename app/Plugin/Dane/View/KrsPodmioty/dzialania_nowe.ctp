<?
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');
echo $this->Html->script('../plugins/cropit/dist/jquery.cropit.js', array('block' => 'scriptBlock'));

echo $this->Element('dataobject/pageBegin'); ?>

    <div class="col-md-9 objectMain">
        <div class="block block-simple col-xs-12 dodaj_dzialanie">
            <header>
                <div class="sm">Dodaj działanie</div>
            </header>

            <section>
                <div class="col-xs-12">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras id maximus ante. Integer fermentum,
                        leo
                        vitae commodo aliquet, nulla mauris egestas enim, eget volutpat urna purus quis magna. Sed
                        eleifend
                        diam eget ornare faucibus. Nunc laoreet finibus posuere. Maecenas vel justo et elit varius
                        consectetur. Nulla dolor est, gravida id molestie quis, vestibulum non metus. Aenean vitae
                        placerat
                        enim, vitae suscipit dui. Integer aliquet justo fermentum, commodo nisl pulvinar, rutrum tellus.
                        Duis sit amet mauris varius, pretium sem laoreet, posuere nisi. Donec pellentesque nibh turpis,
                        non
                        feugiat urna venenatis ut. Curabitur euismod porta arcu ultrices pretium. Ut condimentum metus
                        enim,
                        eget congue quam tincidunt quis. </p>

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

                                <div id="googleMap"></div>
                                <input type="hidden" type="text" name="geo_lat"/>
                                <input type="hidden" type="text" name="geo_lng"/>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn btn-primary submitBtn" type="submit">Dodaj</div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-3 objectSide">
        <div class="block block-simple col-xs-12 dodaj_dzialanie">
            <header>
                <div class="sm">Obserwują</div>
            </header>
            <section>
                <ul class="list col-xs-12">
                    <li class="col-md-2">//avatar</li>
                    <li class="col-md-2">//avatar</li>
                    <li class="col-md-2">//avatar</li>
                </ul>
            </section>
        </div>
    </div>

<?= $this->element('dataobject/pageEnd'); ?>