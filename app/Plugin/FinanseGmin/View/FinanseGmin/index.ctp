<? $this->Combinator->add_libs('css', $this->Less->css('sections', array('plugin' => 'FinanseGmin'))); ?>

<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'FinanseGmin.dzialy.js') ?>

<?
$this->Combinator->add_libs('js', 'FinanseGmin.dzialy.js');
?>

<div class="container">
    <div class="col-md-10 col-md-offset-1 text-center">
        <div class="row banner">

            <p>W I, II i III kwartale 2014 r. polskie gminy wydały łącznie:</p>

            <p class="number"><?= $this->Waluta->slownie($data['stats']['sum']) ?></p>

        </div>
    </div>


    <div class="col-md-8 col-md-offset-2 text-center">
        <div class="row teryt">

            <p>Poniżej widzisz wydatki gmin, według kategorii budżetowych. Możesz też sprawdzić wydatki swojej gminy i
                zobaczyć je w kontekście wydatków innych gmin o podobnej liczbie mieszkańców.</p>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <div class="input-group">
                        <input id="teryt_search_input" class="form-control" type="text" placeholder="Szukaj gminy..."
                               value="">
						<span class="input-group-btn">
							<input type="submit" class="btn btn-primary btn-default" value="Szukaj"/>
						</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="gmina_alert" role="alert" class="alert alert-info alert-dismissible fade in">
        <button aria-label="Close" class="close" type="button"><span aria-hidden="true">×</span></button>
        <p>Zestawienie wydatków gminy Tarłów z innymi gminami o liczbie mieszkańców z przedziału od 0 do 20000</p>
    </div>
</div>

<div class="container">
    <div class="mpanel" id="sections">
        <ul id="sections">
            <? foreach ($data['sections'] as $section) { ?>
                <li class="section" id="section_<?= $section['id'] ?>" data-id="<?= $section['id'] ?>">
                    <div class="row">
                        <div class="col-md-2 text-right icon">
                            <object data="/error/brak.gif" type="image/png">
                                <img src="/finanse_gmin/img/sections/<?= $section['id'] ?>.svg"/>
                            </object>
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
                                        <li class="min" data-int="<?= $section['min'] ?>">
                                            <span class="n"><?= $section['min_nazwa'] ?></span>
                                            <span class="v"><?= number_format_h($section['min']) ?></span>
                                        </li>
                                        <li class="max" data-int="<?= $section['max'] ?>">
                                            <span class="n"><?= $section['max_nazwa'] ?></span>
                                            <span class="v"><?= number_format_h($section['max']) ?></span>
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

    <div class="mpanel" id="dsections">
        <ul>
            <? foreach ($data['sections'] as $section) { ?>
                <li class="section" id="dsection_<?= $section['id'] ?>" data-id="<?= $section['id'] ?>">
                    <div class="row">
                        <div class="col-md-2 text-right icon">
                            <object data="/error/brak.gif" type="image/png">
                                <img src="/finanse_gmin/img/sections/<?= $section['id'] ?>.svg"/>
                            </object>
                        </div>
                        <div class="col-md-10">
                            <div class="row row-header">
                                <div class="title col-md-12">
                                    <div class="col-md-10">
                                        <h3 class="name"><?= $section['tresc'] ?></h3>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <p class="value dsum"></p>
                                    </div>
                                </div>
                                <div class="histogram_cont">
                                    <div class="histogram" id="dhistogram_<?= $section['id'] ?>"
                                         data-init="0">
                                    </div>
                                </div>
                                <div class="gradient_cont">
                                    <span class="gradient"></span>
                                    <ul class="addons">
                                        <li class="min" data-int="0">
                                            <span class="n"></span>
                                            <span class="v"></span>
                                        </li>
                                        <li class="section_addon" data-int="0">
                                            <span class="n"></span>
                                            <span class="v"></span>
                                        </li>
                                        <li class="max" data-int="0">
                                            <span class="n"></span>
                                            <span class="v"></span>
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