<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="object block-group col-xs-12">

        <div class="block">

            <div class="block-header">
                <h2 class="label">Wynik w wyborach</h2>
            </div>

            <div class="content nopadding">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'okreg_numer',
                    'liczba_glosow',
                    'partia_wspierany_przez',
                ), array(
                    'col_width' => 4,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>

            <div class="content nopadding">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'okreg_ulice',
                ), array(
                    'col_width' => 12,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>


        </div>

        <? if ($object->getData('dyzur') || $object->getData('tel') || $object->getData('email') || $object->getData('www')) { ?>
            <div class="block">

                <div class="block-header">
                    <h2 class="label">Kontakt</h2>
                </div>

                <div class="content nopadding">
                    <?php echo $this->Dataobject->hlTableForObject($object, array(
                        'dyzur',
                        'tel',
                        'email',
                        'www'
                    ), array(
                        'col_width' => 4,
                        'display' => 'firstRow',
                        'limit' => 100,
                    )); ?>
                </div>
            </div>
        <? } ?>


        <div class="block">

            <div class="block-header">
                <h2 class="label">Aktywność</h2>
            </div>

            <div class="content nopadding">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'kadencja',
                    'funkcja',
                    'funkcje_publiczne_kiedys',
                    'ngo',
                    'social',
                    'sukcesy',
                ), array(
                    'col_width' => 6,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>
        </div>

        <div class="block">

            <div class="block-header">
                <h2 class="label">Doświadczenie</h2>
            </div>

            <div class="content nopadding">
                <?php echo $this->Dataobject->hlTableForObject($object, array(
                    'wyksztalcenie',
                    'zawod',
                    'miejsce_pracy',
                ), array(
                    'col_width' => 4,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>
        </div>


    </div>
<?= $this->Element('dataobject/pageEnd'); ?>