<?= $this->Dataobject->highlights() ?>

<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.highcharts-sejm_glosowania'); ?>

<?
$wynikiKlubowe = array();
$data = $object->loadLayer('wynikiKlubowe');
foreach ($data as $d) {
    $wynikiKlubowe[$d['wynik_id']][] = $d;
}

$chartData = array(
    array(
        'id' => 'z',
        'count' => $object->getData('z'),
        'label' => 'Za',
    ),
    array(
        'id' => 'p',
        'count' => $object->getData('p'),
        'label' => 'Przeciw',
    ),
    array(
        'id' => 'w',
        'count' => $object->getData('w'),
        'label' => 'Wstrzymania',
    ),
    array(
        'id' => 'n',
        'count' => $object->getData('n'),
        'label' => 'Nieobecności',
    ),
);
$dictionary = array(
    '1' => array('Za', 'z'),
    '2' => array('Przeciw', 'p'),
    '3' => array('Wstrzymanie', 'w'),
    '4' => array('Brak kworum', 'n'),
);
?>


<div class="row">
    <div class="col-md-4 sejm_glosowania">
        <p class="wynikGlosowania <?= $dictionary[$object->getData('wynik_id')][1]; ?> label"><?= $dictionary[$object->getData('wynik_id')][0]; ?></p>
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
                                 src="http://resources.sejmometr.pl/s_kluby/<?php echo $wynik['klub_id']; ?>_a_t.png"
                                 onerror="imgFixer(this)"/>
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
    </div>
    <div class="col-md-8">
        <div class="highchart" data-wynikiKlubowe='<?= json_encode($chartData) ?>'></div>
    </div>
</div>