<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>
<?= $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims)); ?>

    <div id="bdl-wskazniki" class="col-md-12">

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
            ?>

        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>