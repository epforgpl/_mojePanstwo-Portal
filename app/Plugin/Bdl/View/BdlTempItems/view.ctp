<?php $this->Combinator->add_libs('js', 'Bdl.BdlTempItems/view'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('BdlTempItems/view', array('plugin' => 'Bdl'))); ?>
<?php $this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5'); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock')); ?>

<div class="container temp_items">
    <div class="hidden alert alert-success info"></div>
    <form method="post" action="">
        <input type="hidden" name="_method" value="PUT"/>
        <input class="hidden wskz_id" name="id" value="<?= $id ?>">

        <div class="row ">
            <label class="">Tytuł:</label>
        </div>
        <div class="row">
            <input name="tytul" class="form-control nazwa" value="<?= $BdlTempItem['tytul'] ?>">
        </div>
        <div class="row">
            <label>Opis:</label>
        </div>
        <div class="row">
        <textarea name="opis" id="editor">
                    <?= $BdlTempItem['opis'] ?>
        </textarea>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-md btn-primary btn-icon temp-btn pull-right" id="temp_item_savebtn"><i
                    class="icon glyphicon glyphicon-ok"></i>Zapisz opis i nazwę
            </button>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-6">
            <h4 class="text-center">Licznik</h4>
            <ul class="licznik_list skladniki_list list-group">

            </ul>

        </div>
        <div class="col-sm-6">
            <h4 class="text-center">Mianownik</h4>
            <ul class="mianownik_list skladniki_list list-group">

            </ul>

        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-md btn-primary btn-icon temp-btn pull-right" id="bdl_temp_savebtn"><i
                class="icon glyphicon glyphicon-ok"></i>Zapisz składniki
        </button>

    </div>
    <div class="row">
        <div class="text-center">
            <button class="btn btn-lg btn-primary btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
                    class="icon glyphicon glyphicon-ok"></i>Zapisz Wszystko
            </button>
            <button class="btn btn-lg btn-success btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
                    class="icon glyphicon glyphicon-upload"></i>Zapisz i Opublikuj
            </button>
            <form class="remove_btn" method="DELETE" action="/bdl/bdl_temp_items/delete/<?= $id ?>">
                <button class="btn btn-lg btn-danger btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
                        class="icon glyphicon glyphicon-remove"></i>Usuń
                </button>
            </form>
        </div>
    </div>
</div>
<br>