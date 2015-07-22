<?


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
                                    <textarea id="descriptionTextArea" class="form-control"></textarea>
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