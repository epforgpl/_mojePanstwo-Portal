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

<form class="dzialanie" action="<?= $object->getUrl(); ?>.json" method="post">

    <input type="hidden" name="_action" value="save_edit_data_form"/>

    <div class="row">
        <div class="col-md-12">
            <header>Edytuj dane organizacji / urzędu gminy</header>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">

            <div class="block block-simple col-xs-12 dzialanie objectMain">
                <section>
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="form-group">
                                <label for="descriptionTextArea">Misja</label>
                                <textarea name="description" id="descriptionTextArea" class="form-control"><?= $description ?></textarea>
                            </div>

                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div class="col-md-3">
            <div class="sticky margin-top-20">
                <div class="row">

                    <div class="col-md-12 margin-top-10">
                        <button class="btn auto-width btn-primary btn-icon submitBtn" type="submit">
                            <i class="icon glyphicon glyphicon-ok"></i>
                            Zapisz
                        </button>
                        <br/>
                        <div data-opis="<?= $object->getData('cel_dzialania') ?>" class="btn auto-width btn-link btn-icon btnImport margin-top-5">
                            <i class="icon glyphicon glyphicon-download"></i>
                            Zaimportuj z KRS
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</form>


<?= $this->element('dataobject/pageEnd'); ?>
