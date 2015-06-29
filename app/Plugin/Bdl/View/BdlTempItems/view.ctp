<div class="hidden" id="id"><?= $id ?></div>
Tytul: <?= $BdlTempItem['tytul'] ?>
<br>
Opis: <?= $BdlTempItem['opis'] ?>
<br>

Lista wykorzystanych wskaźników:
<ul>
    <li>TEMP</li>
</ul>

<button class="btn btn-primary" id="edit_temp_item">Edytuj</button>


<?php $this->Combinator->add_libs('js', 'Bdl.BdlTempItems/view'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('BdlTempItems/view', array('plugin' => 'Bdl'))); ?>
<?php $this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5'); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock')); ?>

<div id="temp_item_opis_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edytuj Wskaźnik:</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-11">
                    <form method="post" action="">
                    <div class="hidden alert alert-success info"></div>
                        <input class="hidden" name="id" value="<?= $id ?>">
                    <div class="row "><label class="">Tytuł:</label></div>
                    <div class="row"><input  name="tytul" class="form-control nazwa"
                                            value="<?= $BdlTempItem['tytul'] ?>">
                    </div>
                    <br>

                    <div class="row"><label>Opis:</label></div>
                </div>
                <textarea name="opis" id="editor">
                    <?= $BdlTempItem['opis'] ?>
                </textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-md btn-primary btn-icon" id="temp_item_savebtn"><i
                        class="icon glyphicon glyphicon-ok"></i>Dodaj
                </button>
            </div>
            </form>
        </div>
    </div>
</div>