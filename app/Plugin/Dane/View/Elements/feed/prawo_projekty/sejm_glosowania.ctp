<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.highcharts-sejm_glosowania');
?>

<?
/*
$wynikiKlubowe = array();
$data = $object->loadLayer('wynikiKlubowe');
foreach ($data as $d) {
    $wynikiKlubowe[$d['wynik_id']][] = $d;
}
*/


$chartData = array(
    array('Za', (int)$object->getData('z')),
    array('Przeciw', (int)$object->getData('p')),
    array('Wstrzymali się', (int)$object->getData('w')),
    array('Nieobecni', (int)$object->getData('n')),
);
$dictionary = array(
    '1' => array('Za', 'z'),
    '2' => array('Przeciw', 'p'),
    '3' => array('Wstrzymanie', 'w'),
    '4' => array('Brak kworum', 'n'),
);
?>

<div class="content">
    <p class="title"><a href="<?= $object->getUrl() ?>"><?= $object->getTitle() ?></a></p>
</div>


<div class="row sejm_glosowanie-voting sgvq" data-stats='<?= (json_encode($chartData)) ?>'>
    <div class="col-md-3">
        <div class="highchart"></div>
    </div>
    <div class="col-md-9">
        <div class="row">

            <?

            $labels = array(
                'za' => 'Za',
                'przeciw' => 'Przeciw',
                'wstrzymane' => 'Wstrzymali się',
                'nieobecne' => 'Nieobecni',
            );

            $labels_keys = array_keys($labels);

            $count = 0;
            foreach ($labels_keys as $label_key)
                if ($object->getData('kluby_' . $label_key))
                    $count++;

            $width = $count ? round(12 / $count) : 3;


            foreach ($labels as $key => $value)
                if ($data = $object->getData('kluby_' . $key))
                    echo $this->element('Dane.objects/sejm_glosowania/wynik_klubowy', array(
                        'width' => $width,
                        'key' => $key,
                        'label' => $value,
                        'items' => explode("\n", $data),
                        'url' => $object->getUrl(),
                    ));

            ?>


        </div>
    </div>
</div>
