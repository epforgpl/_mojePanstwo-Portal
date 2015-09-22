<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.view-gminy');
?>

<?php if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

    switch (Configure::read('Config.language')) {
        case 'pol':
            $lang = "pl-PL";
            break;
        case 'eng':
            $lang = "en-EN";
            break;
    };
    echo $this->Html->script('//maps.googleapis.com/maps/api/js?language=' . $lang, array('block' => 'scriptBlock'));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow');
} ?>

<? echo $this->Element('dataobject/pageBegin'); ?>

<div class="objectsPage">
    <?
    $options = array();
    if (isset($title))
        $options['title'] = $title;

    echo $this->Element('Dane.DataBrowser/browser', $options);
    ?>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>
