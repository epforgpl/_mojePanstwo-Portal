<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dane', array('plugin' => 'Dane')));

/* tinymce */
echo $this->Html->script('../tinymce/tinymce.min', array('block' => 'scriptBlock'));

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dane');

$page = $object->getLayer('page');
$description = isset($page['description']) ? $page['description'] : $object->getData('cel_dzialania');

?>
<div class="container">
    <div class="krsPodmioty row">

        <form action="<?= $object->getUrl(); ?>.json" method="post">
            <div class="col-md-9 objectMain">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="margin-top-10">Poinformuj innych o działaniach swojej organizacji. Informacje o działaniach będą widoczne na stronie profilowej Twojej organizacji, a także będą pojawiały się przy wynikach wyszukiwania na portalu mojePaństwo.</p>
                        <input type="hidden" name="_action" value="save_edit_data_form"/>
                        <div class="form-group">
                            <label for="descriptionTextArea">Misja</label>
                            <textarea name="description" id="descriptionTextArea" class="form-control"><?= $description ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="sticky margin-top-15">
                    <div class="row">

                        <div class="col-md-12">
                            <button class="btn auto-width btn-primary btn-icon submitBtn" type="submit">
                                <i class="icon glyphicon glyphicon-ok"></i>
                                Zapisz
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    </div>
</div>