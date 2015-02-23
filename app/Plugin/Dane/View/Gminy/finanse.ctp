<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('view-gminy-finanse', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-gminy-finanse.js') ?>

<?

$zakresy = array(
    array(0, 20000),
    array(20000, 50000),
    array(50000, 100000),
    array(100000, 500000),
    array(500000, 999999999)
);
$zakres = $zakresy[(int) $object->data('zakres')];
$data = $object->getLayer('finanse');

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="pull-left">Wydatki gminy <?= $object->data('nazwa'); ?></h1>
        </div>
    </div>
    <div class="col-md-10 col-md-offset-1 text-center">
        <div class="row banner">
            <p>Zestawienie wydatków gminy <?= $object->data('nazwa'); ?> w I, II i III kwartale 2014 r. z innymi gminami o liczbie mieszkańców z zakresu <?php echo $zakres[0]; ?> - <?php echo $zakres[1]; ?></p>
        </div>
    </div>
</div>

<div class="container">
    <div class="mpanel" id="sections">
        <ul id="sections">
            <? foreach ($data['sections'] as $section) { ?>
                <li class="section" id="section_<?= $section['id'] ?>" data-sum="<?=(int)$section['sum_wydatki']?>" data-id="<?= $section['id'] ?>">
                    <div class="row">
                        <div class="col-md-2 text-right icon">
                            <img src="/finanse/img/sections/<?= $section['id'] ?>.svg"/>
                        </div>
                        <div class="col-md-10">
                            <div class="row row-header">
                                <div class="title col-md-12">
                                    <div class="col-md-10">
                                        <h3 class="name"><?= $section['tresc'] ?></h3>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <p class="value"><?= number_format_h($section['sum_wydatki']) ?></p>
                                    </div>
                                </div>
                                <div class="histogram_cont">
                                    <div class="histogram"
                                         data-init="<?= htmlspecialchars(json_encode($section['buckets'])) ?>">
                                    </div>
                                </div>
                                <div class="gradient_cont">
                                    <span class="gradient"></span>
                                    <ul class="addons">
                                        <li class="min" id="minmin" data-int="<?= (int)$section['min'] ?>">
                                            <span class="n"><?= $section['min_nazwa'] ?></span>
                                            <span class="v"><?= _number($section['min']) ?></span>
                                        </li>
                                        <li class="section_addon" data-int="<?= (int)$section['commune'] ?>" id="section_<?= $section['id'] ?>_addon">
                                            <span class="n"><?= $object->data('nazwa'); ?></span>
                                            <span class="v"><?= _number($section['commune']) ?></span>
                                        </li>
                                        <li class="max"  data-int="<?= (int)$section['max'] ?>">
                                            <span class="n"><?= $section['max_nazwa'] ?></span>
                                            <span class="v"><?= _number($section['max']) ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <? } ?>
        </ul>
    </div>
</div>