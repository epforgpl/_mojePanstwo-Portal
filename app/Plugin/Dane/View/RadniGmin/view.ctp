<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="object block-group col-xs-12">

        <? if ($wystapienia) { ?>
            <div class="block">

                <div class="block-header"><h2 class="label">Wystąpienia na sesjach rady gminy</h2></div>

                <div class="content">
                    <div class="dataobjectsSliderRow row">
                        <div>
                            <?php echo $this->dataobjectsSlider->render($wystapienia, array(
                                'perGroup' => 4,
                                'rowNumber' => 1,
                                'labelMode' => 'none',
                                'file' => 'radni_gmin_wystapienia',
                                'dfFields' => array('rady_gmin_posiedzenia.data'),
                            )) ?>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>

        <div class="block">
            <div class="block-header"><h2 class="label">Dane wyborcze</h2></div>

            <div class="content">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'rady_gmin_komitety.nazwa',
                    'poparcie'
                ), array(
                    'col_width' => 3,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>
        </div>

        <div class="block">

            <div class="content">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'rady_gmin_okregi.nr_okregu',
                    'numer_listy',
                    'pozycja',
                    'liczba_glosow',
                    'procent_glosow_w_okregu'
                ), array(
                    'col_width' => 2,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>
        </div>

        <div class="block">
            <div class="block-header"><h2 class="label">Pochodzenie</h2></div>

            <div class="content">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'miejsce_zamieszkania',
                    'obywatelstwo'
                ), array(
                    'col_width' => 3,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>
        </div>


    </div>
<?= $this->Element('dataobject/pageEnd'); ?>