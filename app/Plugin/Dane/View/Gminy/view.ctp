<?php $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy');
?>

<?php if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.exp', array('block' => 'scriptBlock'));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
} ?>

<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="objectsPage<? if ($object->getId() == 903) { ?> krakow <? } ?>">
    <?
    $options = array();
    if (isset($title))
        $options['title'] = $title;
    $options['blockStyle'] = 'block-default';

    echo $this->Element('Dane.DataBrowser/browser', $options);
    ?>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
