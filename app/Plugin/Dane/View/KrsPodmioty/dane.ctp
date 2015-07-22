<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dane', array('plugin' => 'Dane')));

/* tinymce */
echo $this->Html->script('../tinymce/tinymce.min', array('block' => 'scriptBlock'));

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dane');

$page = $object->getLayer('page');
$description = ($page['description']) ? $page['description'] : $object->getData('cel_dzialania');

?>
<div class="container">
    <div class="krsPodmioty">

        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">

                <div class="row">
                    <div class="block block-simple col-md-12">

                        <header>
                            <div class="sm">Dane</div>
                        </header>
                        <section class="content">
                            <form action="<?= $object->getUrl(); ?>.json" method="post">

                                <input type="hidden" name="_action" value="save_edit_data_form"/>

                                <div class="form-group">
                                    <label for="descriptionTextArea">Misja</label>
                                    <textarea name="description" id="descriptionTextArea" class="form-control"><?= $description ?></textarea>
                                </div>

                                <button class="btn auto-width btn-primary btn-icon submitBtn pull-right" type="submit">
                                    <i class="icon glyphicon glyphicon-ok"></i>
                                    Zapisz
                                </button>

                            </form>
                        </section>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>