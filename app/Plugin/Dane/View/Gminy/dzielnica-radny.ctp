<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => $_submenu,
    'object' => $dzielnica,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => false,
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));
?>

    <div class="object block-group">

        <div class="block">

            <div class="block-header">
                <h2 class="label">Wynik w wyborach</h2>
            </div>

            <div class="content nopadding">
                <?php echo $this->Dataobject->hlTableForObject($radny, array(
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
                <?php echo $this->Dataobject->hlTableForObject($radny, array(
                    'okreg_ulice',
                ), array(
                    'col_width' => 12,
                    'display' => 'firstRow',
                    'limit' => 100,
                )); ?>
            </div>


        </div>

        <? if ($radny->getData('dyzur') || $radny->getData('tel') || $radny->getData('email') || $radny->getData('www')) { ?>
            <div class="block">

                <div class="block-header">
                    <h2 class="label">Kontakt</h2>
                </div>

                <div class="content nopadding">
                    <?php echo $this->Dataobject->hlTableForObject($radny, array(
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
                <?php echo $this->Dataobject->hlTableForObject($radny, array(
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
                <?php echo $this->Dataobject->hlTableForObject($radny, array(
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

        <div class="block">

            <div class="block-header">
                <h2 class="label">Wyniki głosowań</h2>
            </div>

        </div>

    </div>

<?
echo $this->Element('Dane.DataobjectsBrowser/view', array(
    'page' => $page,
    'pagination' => $pagination,
    'filters' => $filters,
    'switchers' => $switchers,
    'facets' => $facets,
    'renderFile' => 'radni_dzielnic-uchwaly',
));

echo $this->Element('dataobject/pageEnd');