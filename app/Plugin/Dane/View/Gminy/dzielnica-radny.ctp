<style>
	.objectsPage .objectsPageWindow .objectsPageContent .object .dataHighlights .dataHighlight {
		width: 100% !important;
	}
	.theme-default .block-group, .theme-wallpaper .block-group, .theme-simply .block-group.block-border {
		padding: 0 20px;
	}
</style>
<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    ),
    'back' => array(
        'href' => $dzielnica->getUrl(),
        'title' => 'Dzielnica ' . $dzielnica->getTitle(),
    ),
));
?>
    <div class="object block-group col-xs-12">

        <? if (
            $radny->getData('okreg_numer') ||
            $radny->getData('liczba_glosow') ||
            $radny->getData('partia_wspierany_przez') ||
            $radny->getData('okreg_ulice')
        ) { ?>

            <div class="block">

                <div class="block-header">
                    <h2 class="label">Wynik w wyborach</h2>
                </div>

                <? if (
                    $radny->getData('okreg_numer') ||
                    $radny->getData('liczba_glosow') ||
                    $radny->getData('partia_wspierany_przez')
                ) { ?>
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
                <? } ?>

                <? if (
                $radny->getData('okreg_ulice')
                ) { ?>
                    <div class="content nopadding">
                        <?php echo $this->Dataobject->hlTableForObject($radny, array(
                            'okreg_ulice',
                        ), array(
                            'col_width' => 12,
                            'display' => 'firstRow',
                            'limit' => 100,
                        )); ?>
                    </div>
                <? } ?>
                <? if (
                $radny->getData('funkcja')
                ) { ?>
                    <div class="content nopadding">
                        <?php echo $this->Dataobject->hlTableForObject($radny, array(
                            'funkcja',
                        ), array(
                            'col_width' => 12,
                            'display' => 'firstRow',
                            'limit' => 100,
                        )); ?>
                    </div>
                <? } ?>
                <? if (
                $radny->getData('komisje')
                ) { ?>
                    <div class="content nopadding">
                        <?php echo $this->Dataobject->hlTableForObject($radny, array(
                            'komisje',
                        ), array(
                            'col_width' => 12,
                            'display' => 'firstRow',
                            'limit' => 100,
                        )); ?>
                    </div>
                <? } ?>


            </div>
        <? } ?>

        <? if ($radny->getData('dyzur') || $radny->getData('tel') || $radny->getData('email') || $radny->getData('www') || $radny->getData('www_dzielnica')) { ?>
            <div class="block">

                <div class="block-header">
                    <h2 class="label">Kontakt</h2>
                </div>

                <div class="content nopadding">
                    <?php echo $this->Dataobject->hlTableForObject($radny, array(
                        'dyzur',
                        'tel',
                        'email',
                        'www',
                        'www_dzielnica'
                    ), array(
                        'col_width' => 4,
                        'display' => 'firstRow',
                        'limit' => 100,
                    )); ?>
                </div>
            </div>
        <? } ?>


        <? if (
            $radny->getData('kadencja') ||
            $radny->getData('funkcja') ||
            $radny->getData('funkcje_publiczne_kiedys') ||
            $radny->getData('ngo') ||
            $radny->getData('social') ||
            $radny->getData('sukcesy')
        ) { ?>
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
        <? } ?>

        <? if (
            $radny->getData('wyksztalcenie') ||
            $radny->getData('zawod') ||
            $radny->getData('miejsce_pracy')
        ) { ?>
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
        <? } ?>

        <? if (isset($objects) && !empty($objects)) { ?>
            <div class="block">

                <div class="block-header">
                    <h2 class="label">Wyniki głosowań</h2>
                </div>

            </div>
        <? } ?>

    </div>

<?
if (isset($objects) && !empty($objects))
    echo $this->Element('Dane.DataobjectsBrowser/view', array(
        'page' => $page,
        'pagination' => $pagination,
        'filters' => $filters,
        'switchers' => $switchers,
        'facets' => $facets,
        'renderFile' => 'radni_dzielnic-uchwaly',
    ));

echo $this->Element('dataobject/pageEnd');
