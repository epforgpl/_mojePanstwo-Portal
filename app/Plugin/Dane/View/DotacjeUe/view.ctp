<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="object">

        <div class="block">

            <div class="block-header">
                <h2 class="label">Beneficjent</h2>
            </div>

            <div class="content nopadding">
                <?
                echo $this->Dataobject->hlTableForObject($object, array(
                    'beneficjent_nazwa', 'forma_prawna_str'
                ), array(
                    'col_width' => 6,
                ));
                ?>
            </div>
        </div>

        <div class="block">

            <div class="block-header">
                <h2 class="label">Finanse</h2>
            </div>

            <div class="content nopadding">
                <?
                echo $this->Dataobject->hlTableForObject($object, array(
                    'wartosc_ogolem', 'wartosc_wydatki_kwalifikowane', 'wartosc_dofinansowanie', 'wartosc_dofinansowanie_ue',
                ), array(
                    'col_width' => 3,
                ));
                ?>
            </div>
        </div>

        <div class="block">

            <div class="block-header">
                <h2 class="label">Daty</h2>
            </div>

            <div class="content nopadding">
                <?
                echo $this->Dataobject->hlTableForObject($object, array(
                    'data_podpisania', 'data_utworzenia_ksi', 'data_rozpoczecia', 'data_zakonczenia',
                ), array(
                    'col_width' => 3,
                ));
                ?>
            </div>
        </div>

        <?

        // echo( implode("', '", array_keys( $object->getData() )) );

        // 'dzialanie_id', 'forma_prawna_id', 'forma_prawna_str', 'id', 'liczba_czesci', 'os_id', 'poddzialanie_id', 'program_id', 'projekt_zakonczony', 'tytul'

        // 'gmina_id', 'powiat_id', 'wojewodztwo_id', 'poziom_id'

        ?>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>