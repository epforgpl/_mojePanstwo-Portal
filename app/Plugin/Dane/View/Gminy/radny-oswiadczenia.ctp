<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
echo $this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow'),
        'bigTitle' => true,
    )
));

if ($subsubid && $oswiadczenie && $oswiadczenie->getData('dokument_id')) {
    ?>
    <p class="subsubtitle">
        <a href="/dane/gminy/<?= $object->getId() ?>/radni/<?= $radny->getId() ?>/oswiadczenia"><span
                class="glyphicon glyphicon-align-justify"></span> Wszystkie oświadczenia</a>
    </p>
    <?
    echo $this->Document->place($oswiadczenie->getData('dokument_id'));

} else {

    echo $this->Element('Dane.DataBrowser/browser');

}

echo $this->Element('dataobject/pageEnd');