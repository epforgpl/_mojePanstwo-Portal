<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>

<?php $this->Combinator->add_libs('css', $this->Less->css('sections', array('plugin' => 'Finanse'))) ?>
<?php $this->Combinator->add_libs('js', 'Finanse.dzialy.js') ?>

<?
$this->Combinator->add_libs('js', 'Finanse.dzialy.js');
?>

<div class="container">

    <div class="row">
        <div class="col-md-12">

            <h1 class="pull-left">Wydatki gmin w Polsce</h1>

            <? /*
			<div class="range text-center pull-right">
		        <ul class="pagination">
		            <li class="active"><a href="?range=24h">Q2 2014</a></li>
		            <li><a href="?range=3d">Q1 2014</a></li>
		        </ul>
		    </div>
		    */
            ?>

        </div>
    </div>


    <div class="col-md-10 col-md-offset-1 text-center">
        <div class="row banner">

            <p>W I, II i III kwartale 2014 r. polskie gminy wydały łącznie:</p>

            <p class="number"><?= $this->Waluta->slownie($data['stats']['sum']) ?></p>

        </div>
    </div>


    <div class="col-md-8 col-md-offset-2 text-center">
        <div class="row teryt">

            <p>Poniżej widzisz wydatki gmin, według kategorii budżetowych. Możesz też sprawdzić wydatki swojej gminy i
                zobaczyć je w kontekście wydatków innych gmin.</p>

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
    <div class="mpanel" id="sections">
        <ul id="sections">
            <? foreach ($data['sections'] as $section) { ?>
                <li class="section" id="section_<?= $section['id'] ?>" data-id="<?= $section['id'] ?>">
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
                                        <li class="min" data-int="<?= $section['min'] ?>">
                                            <span class="n"><?= $section['min_nazwa'] ?></span>
                                            <span class="v"><?= _number($section['min']) ?></span>
                                        </li>
                                        <li class="section_addon" id="section_<?= $section['id'] ?>_addon">
                                            <span class="n"></span>
                                            <span class="v"></span>
                                        </li>
                                        <li class="max"  data-int="<?= $section['max'] ?>">
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