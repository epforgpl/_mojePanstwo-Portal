<?
echo $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzeniapunkty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
echo $this->Combinator->add_libs('js', 'Dane.view-sejmglosowania');
?>
    <div class="object">
        <?

        echo $this->Element('Dane.dataobject/subobject', array(
            'object' => $glosowanie,
            'objectOptions' => array(
                'hlFields' => array('wynik_id'),
                'bigTitle' => true,
            )
        ));

        $chartData = array(
            array(
                'id' => 'z',
                'count' => $glosowanie->getData('z'),
                'label' => 'Za',
            ),
            array(
                'id' => 'p',
                'count' => $glosowanie->getData('p'),
                'label' => 'Przeciw',
            ),
            array(
                'id' => 'w',
                'count' => $glosowanie->getData('w'),
                'label' => 'Wstrzymania',
            ),
            array(
                'id' => 'n',
                'count' => $glosowanie->getData('n'),
                'label' => 'Nieobecności',
            ),
        );
        ?>

        <div class="highchart" data-wynikiKlubowe='<?= json_encode($chartData) ?>'></div>

        <?
        echo $this->Element('Dane.DataobjectsBrowser/view', array(
            'page' => $page,
            'pagination' => $pagination,
            'filters' => $filters,
            'switchers' => $switchers,
            'facets' => $facets,
            'renderFile' => $renderFile,
        ));
        ?>

    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>