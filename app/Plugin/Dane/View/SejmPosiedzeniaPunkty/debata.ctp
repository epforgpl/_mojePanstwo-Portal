<?
echo //$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzeniapunkty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');
echo $this->Element('dataobject/pageBegin');
?>
    <div class="object">

        <?
        echo $this->Element('Dane.DataobjectsBrowser/view', array(
            'page' => $page,
            'pagination' => $pagination,
            'filters' => $filters,
            'switchers' => $switchers,
            'facets' => $facets,
            'renderFile' => $renderFile,
            'hiddenFilters' => array('sejm_wystapienia.stanowisko_id'),
        ));
        ?>

    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>