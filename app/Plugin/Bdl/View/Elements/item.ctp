<div id="bdl_wskaznik_block">
    <? if ($object->getData('opis')) { ?>
        <div class="opis">
            <?= $object->getData('opis') ?>
        </div>
    <? }
    echo $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims));
    ?>

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
                    <textarea name="opis" id="editor"></textarea>
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

    <div id="bdl-wskazniki" class="col-xs-12">
        <? if (in_array('bdl_opis', $object_editable)) {
            echo $this->element('Dane.bdl_opis');
        } ?>
        <div class="object">
            <?
            if (!empty($expanded_dimension)) {
                foreach ($expanded_dimension['options'] as $option) {
                    if (isset($option['data'])) {

                        if( isset($combination) && ($combination['id']==$option['id']) ) {

                            echo $this->element('Dane.bdl_wskaznik', array(
                                'data' => $option['data'],
                                'url' => $object->getUrl(),
                                'title' => $option['value'],
                            ));

                            echo $this->element('Bdl.subitem');

                        } else {

                            echo $this->element('Dane.bdl_wskaznik', array(
                                'data' => $option['data'],
                                'url' => $object->getUrl(),
                                'title' => $option['value'],
                            ));

                        }

                    }
                }
            }
            ?>
        </div>
    </div>
</div>
