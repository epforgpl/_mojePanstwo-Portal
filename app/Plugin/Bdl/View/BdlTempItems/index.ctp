<button class="btn btn-primary" id="new_temp_item">Dodaj Nowy</button>
<? if ($BdlTempItems == false) { ?>
    Nie ma wskaźników do wyświetlenia
<? } else { ?>
    <ul>
        <? foreach ($BdlTempItems as $key => $val) { ?>
            <li><a href="/bdl/bdl_temp_items/<?= $key ?>"><?= $val['tytul'] ?></a><form method="DELETE" action="/bdl/bdl_temp_items/delete/<?= $key ?>"><button class="btn btn-primary btn-sm" type="submit"><i
                        class="icon glyphicon glyphicon-remove"></i></button></form></li>
        <? } ?>
    </ul>
<? } ?>




<?php $this->Combinator->add_libs('js', 'Bdl.BdlTempItems/index'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('BdlTempItems/index', array('plugin' => 'Bdl'))); ?>
<?php $this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5'); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock')); ?>

<div id="temp_item_opis_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nowy Wskaźnik:</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-11">
                    <form method="post" action="">
                    <div class="hidden alert alert-success info"></div>
                    <div class="row "><label class="">Tytuł:</label></div>
                    <div class="row"><input name="tytul" class="form-control nazwa" value="">
                    </div>
                    <br>

                    <div class="row"><label>Opis:</label></div>
                </div>
                <textarea name="opis" id="editor">
                </textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-md btn-primary btn-icon" id="temp_item_savebtn"><i
                        class="icon glyphicon glyphicon-ok"></i>Dodaj
                </button>
                </form>
            </div>
        </div>
    </div>
</div>