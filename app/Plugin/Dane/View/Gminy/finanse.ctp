<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('sections', array('plugin' => 'FinanseGmin')));
    $this->Combinator->add_libs('css', $this->Less->css('administracja', array('plugin' => 'KtoTuRzadzi')));
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow-finanse', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', 'Dane.view-gminy-krakow-finanse');
}
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
$zakresy = array(
    array(0, 20000),
    array(20000, 50000),
    array(50000, 100000),
    array(100000, 500000),
    array(500000, 999999999)
);
$zakres = $zakresy[(int)$object->data('zakres')];
$data = $object->getLayer('finanse');
?>

    <div id="administracja">
        <div class="container">
            <div class="content col-xs-12 row">
                <div class="row items">
                    <? foreach ($dzialy as $item) { ?>
                        <div class="block col-md-3">
                            <div class="item" data-id="<?= $item['id'] ?>">

                                <a href="#<?= $item['id'] ?>>" class="inner"
                                   data-title="<?= $item['nazwa'] ?>">

                                    <div class="logo">
                                        <img src="/finanse_gmin/img/sections/<?= $item['id'] ?>.svg"
                                             onerror="imgFixer(this)"/>
                                    </div>

                                    <div class="details"><span class="detail">
                                            Budżet: <?= number_format_h($item['wartosc']) ?></span>
                                    </div>

                                    <div class="title">
                                        <div class="nazwa"><?= $item['nazwa'] ?></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>

<? /*
<div class="title col-md-12">
    <div class="col-md-10">
        <h3 class="name"><?= $section['tresc'] ?></h3>
    </div>
    <div class="col-md-2 text-center">
        <p class="value hide"><?= number_format_h($section['sum_wydatki']) ?></p>
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
            <span class="v"><?= number_format_h($section['min']) ?></span>
        </li>
        <li class="section_addon" data-int="<?= (int)$section['commune'] ?>"
            id="section_<?= $section['id'] ?>_addon">
            <span class="n"><?= $object->data('nazwa'); ?></span>
            <span class="v"><?= number_format_h($section['commune']) ?></span>
        </li>
        <li class="max" data-int="<?= (int)$section['max'] ?>">
            <span class="n"><?= $section['max_nazwa'] ?></span>
            <span class="v"><?= number_format_h($section['max']) ?></span>
        </li>
    </ul>
</div>
 */ ?>

<? echo $this->Element('dataobject/pageEnd', array(
    'titleTag' => 'p',
));
?>
