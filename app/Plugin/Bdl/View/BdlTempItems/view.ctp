<?php $this->Combinator->add_libs('js', 'Bdl.BdlTempItems/view'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('BdlTempItems/view', array('plugin' => 'Bdl'))); ?>
<?php $this->Combinator->add_libs('css', '../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5'); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.all', array('block' => 'scriptBlock')); ?>
<?php echo $this->Html->script('../plugins/bootstrap3-wysiwyg/dist/locales/bootstrap-wysihtml5.pl-NEW', array('block' => 'scriptBlock')); ?>

<?= $this->Element('Bdl.leftsideaccordion', array('tree' => $tree)); ?>

<div class="container temp_items">
    <div class="container">
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
        <textarea name="opis" id="editor_opis">
                    <?= $BdlTempItem['opis'] ?>
        </textarea>
        </div>
    </form>
    <div class="row">
        <label class="">Składniki:</label>
    </div>
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
        <div class="text-center">
            <button class="btn btn-md btn-primary btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
                    class="icon glyphicon glyphicon-ok"></i>Zapisz
            </button>
            <form class="remove_btn" method="DELETE" action="/bdl/bdl_temp_items/delete/<?= $id ?>">
                <button class="btn btn-md btn-danger btn-icon temp-btn" id="bdl_temp_save_all_btn"><i
                        class="icon glyphicon glyphicon-remove"></i>Usuń
                </button>
            </form>
        </div>
    </div>
</div>
</div>
<br>