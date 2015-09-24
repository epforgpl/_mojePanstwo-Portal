<?

$this->Combinator->add_libs('css', $this->Less->css('collections-form', array('plugin' => 'Start')));
$this->Combinator->add_libs('js', 'Start.collections-form');

echo $this->element('Start.pageBegin'); ?>

<form class="collectionsForm" method="post">

    <header>
        <h1>Nowa Kolekcja</h1>
    </header>

    <div class="form-group margin-top-10">
        <label for="collectionName">Tytuł:</label>
        <input maxlength="195" type="text" class="form-control" id="collectionName" name="name"/>
    </div>

    <div class="form-group margin-top-20">
        <label for="collectionDescription">Opis:</label>
        <textarea maxlength="16383" class="form-control tinymce" id="collectionDescription" name="description"></textarea>
    </div>

    <div class="form-group margin-top-20" style="margin-bottom: 130px;">
        <label>Obrazek:</label>
        <div class="image-editor">
            <div class="cropit-image-preview"></div>
            <div class="slider-wrapper">
                <span class="icon icon-small glyphicon glyphicon-tree-conifer"></span>
                <input type="range" class="cropit-image-zoom-input" />
                <span class="icon icon-large glyphicon glyphicon-tree-conifer"></span>
            </div>
            <p>Zalecany rozmiar: 810x320px</p>
            <span class="btn btn-default btn-file">Przeglądaj<input type="file" class="cropit-image-input"/></span>
        </div>
    </div>

    <div class="form-group overflow-hidden">
        <button class="btn auto-width btn-primary btn-icon pull-right" type="submit">
            <i class="icon glyphicon glyphicon-ok"></i>
            Zapisz
        </button>
    </div>

</form>

<?= $this->element('Start.pageEnd'); ?>
