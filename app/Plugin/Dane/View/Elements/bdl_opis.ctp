<?php $this->Combinator->add_libs('js', 'Dane.bdl_opis'); ?>
            <?php $this->Combinator->add_libs('css', $this->Less->css('bdl_opis', array('plugin' => 'Dane'))); ?>
            <?php $this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5'); ?>
            <?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
            <?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock')); ?>

            <div id="bdl_opis_modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Edycja nazwy i opisu wskaźnika:</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-11">
                                <div class="hidden alert alert-success info"></div>
                                <div class="row "><label class="">Nazwa:</label></div>
                                <div class="row"><input class="form-control nazwa"
                                                        value="<?= $object->getData('bdl_podgrupa.nazwa') ? $object->getData('bdl_podgrupa.nazwa') : $object->getData('bdl_podgrupa.tytul'); ?>">
                                </div>
                                <br>

                                <div class="row"><label>Opis:</label></div>
                            </div>
                            <article id="editor">
                                <?= $object->getData('bdl_podgrupa.opis'); ?>
                            </article>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-md btn-primary btn-icon" id="bdl_savebtn"><i
                                    class="icon glyphicon glyphicon-ok"></i>Zapisz
                            </button>
                        </div>
                    </div>
                </div>
            </div>