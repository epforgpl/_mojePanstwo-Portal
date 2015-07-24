<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts', false); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-map', false); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals', false); ?>

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
                    echo $this->element('Dane.bdl_wskaznik', array(
                        'data' => $option['data'],
                        'url' => $object->getUrl(),
                        'title' => $option['value'],
                    ));
                }
            }
        }

        if (isset($combination)) {
            echo $this->element('Dane.bdl_wskaznik', array(
                'data' => $combination,
                'url' => $object->getUrl(),
                'title' => $title,
            ));

            echo $this->element('Bdl.subitem');
        }
        ?>
    </div>
</div>