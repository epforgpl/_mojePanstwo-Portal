<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.highcharts-sejm_glosowania'); ?>

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


<div class="row sejm_glosowanie-voting sgvq" data-stats='<?= (json_encode($chartData)) ?>'>
    <div class="col-md-2">
        <p class="wynikGlosowania <?= $dictionary[$object->getData('wynik_id')][1]; ?> label"><?= $dictionary[$object->getData('wynik_id')][0]; ?></p>

        <? /*
        <table class="table table-striped">
            <thead>
            <tr>
                <td><?php echo sprintf(__d('dane', 'LC_DANE_KLUBY_GLOSUJACE'), $dictionary[$object->getData('wynik_id')][0]); ?></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($wynikiKlubowe[$object->getData('wynik_id')] as $wynik) { ?>
                <tr>
                    <td>
                        <div class="col-md-3 text-center">
                            <img class="kluby"
                                 src="http://resources.sejmometr.pl/s_kluby/<?php echo $wynik['klub_id']; ?>_a_t.png"/>
                        </div>
                        <div class="col-md-9">
                            <a href="<?php echo $this->Html->url(array(
                                'plugin' => 'Dane',
                                'controller' => 'sejm_kluby',
                                'action' => 'view',
                                'id' => $wynik['klub_id']
                            )); ?>">
                                <?php echo $wynik['klub_nazwa']; ?>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        */ ?>


    </div>
    <div class="col-md-3">
        <div class="highchart"></div>
    </div>
    <div class="col-md-7">
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