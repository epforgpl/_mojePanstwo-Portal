<?
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

?>
<div class="col-sm-2 col-xs-12 dataAggsContainer">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $object->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu,
        ));

    }

    $dzialy = $dataBrowser['aggs']['gmina']['wydatki']['timerange']['dzialy']['buckets'];

    ?>



</div>
<div class="col-sm-10">


    <div class="dataWrap">
        <div class="appBanner">
            <h1 class="appTitle">Wydatki gminy <?= $object->getTitle(); ?></h1>

        </div>
    </div>

    <div id="expensesSwitcher" class="appMenuStrip row">
        <div class="appSwitchers text-center">
            <div class="dataWrap">
                <form class="form-inline" method="get">

                    <div class="form-group">
                        <label for="rangeSelect">Analizowany okres: </label>
                        <? if(isset($ranges)) { ?>
                            <select id="rangeSelect" class="form-control" name="range">
                                <? foreach($ranges as $year => $quarters) { ?>
                                    <option value="<?= $year ?>">
                                        <?= $year ?> - całość
                                    </option>
                                    <? foreach($quarters as $quarter) { ?>
                                        <option value="<?= $year ?>Q<?= $quarter?>">
                                            <?= $year ?> - kwartał <?= $quarter ?>
                                        </option>
                                    <? } ?>
                                <? } ?>
                            </select>
                        <? } ?>
                    </div>

                    <div class="form-group">
                        <label for="modeSelect">Porównywane gminy: </label>
                        <? if(isset($modes)) { ?>
                            <select id="modeSelect" class="form-control" name="mode">
                                <? foreach($modes as $value => $mode) { ?>
                                    <option value="<?= $value ?>">
                                        <?= $mode['label'] ?>
                                    </option>
                                <? } ?>
                            </select>
                        <? } ?>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <? /*
    <div class="dataWrap">
        <div class="text-center">
	        <p>Suma wydatków:</p>
	        <p><?= number_format_h($dataBrowser['aggs']['gmina']['wydatki']['timerange']['wydatki']['value']); ?></p>
        </div>
    </div> */ ?>
    <? if(isset($actions)) { ?>
        <ul class="nav nav-tabs nav-actions margin-top-10">
            <? foreach($actions['actions'] as $param => $a) { ?>
                <li<? if($action == $param) echo ' class="active"'; ?>>
                    <a href="<?= $object->getUrl(); echo '/finanse'; if($param != '') { ?>?<?= $actions['name'] ?>=<?= $param ?><? } ?>">
                        <?= $a ?>
                    </a>
                </li>
            <? } ?>
        </ul>
    <? } ?>

    <div id="mp-sections">
        <div class="content">

            <p class="text-center margin-top-20">Klikniaj na rodzaj wydatków, aby dowiedzieć się więcej:</p>

            <div class="row items">
                <? foreach ($dzialy as $item) { ?>
                    <div class="block col-md-3">

	                    <?

		                    $dzial = false;
							foreach( $dataBrowser['aggs']['gminy']['wydatki']['timerange']['dzialy']['buckets'] as $b ) {
								if( $b['key']==$item['key'] ) {
									$dzial = $b;
									break;
								}
							}

							$min = @$dzial['min']['buckets'][0]['key'];
							$cur = $item['wydatki']['value'];
							$max = @$dzial['max']['buckets'][0]['key'];
							$median = (int) @$dzial['percentiles']['values']['50.0'];

							$class = ($cur > $median) ? 'more' : 'less';

							$diff = $dzial['stats']['max'] - $dzial['stats']['min'];
							$intervals = array(100000000, 10000000, 100000, 1000);
							$histogram_i = 0;

							for($i = count($intervals) - 1; $i >= 0; $i--) {

								$v = $intervals[$i];

								if( $diff<$v*100 ) {
									$histogram_i = $i;
									break;
								}

							}

                            $left = ($min == $max) ? false : 100 * ( $cur - $min ) / ( $max - $min );
                            $median_left = ($min == $max) ? false : 100 * ( $median - $min ) / ( $max - $min );

                            $dzial['histogram']['buckets'] = $dzial['histogram_' . $histogram_i]['buckets'];

	                    ?>

                        <div class="item <?= $class ?>" data-id="<?= $item['key'] ?>">

                            <a href="#<?= $item['key'] ?>>" class="inner"
                               data-title="<?= $item['nazwa']['buckets'][0]['key'] ?>">

                                <div class="logo">
                                    <img src="/finanse_gmin/img/sections/<?= $item['key'] ?>.svg"
                                         onerror="imgFixer(this)"/>
                                </div>

                                <div class="details"><span class="detail">
                                        <?= number_format_h($item['wydatki']['value']) ?></span>
                                </div>

                                <div class="title">
                                    <div class="nazwa"><?= $this->Text->truncate($item['nazwa']['buckets'][0]['key'], 50) ?></div>
                                </div>

                                <div class="subtitle" style="display: none;">
	                                <h3>Szczegółowe wydatki gminy <?= $object->getTitle() ?> w tym dziale:</h3>
                                </div>

                                <div class="chart" style="display: none;">
	                                <div class="histogram_cont">
		                                <div class="histogram" data-median="<?= $median ?>" data-text="<?= $item['nazwa']['buckets'][0]['key'] ?>" data-histogram='<?= json_encode($dzial['histogram']['buckets']) ?>'>
		                                </div>
	                                </div>
	                                <div class="gradient_cont">
		                                <span class="gradient"></span>
		                                <ul class="addons">
			                                <li class="min" style="left: 2%;">
			                                	<span class="n"><?= @$dzial['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['fields']['source'][0]['data']['gminy.nazwa'] ?></span>
			                                	<span class="v"><?= number_format_h($min) ?></span>
			                                </li>
                                            <li class="_median" style="<?

                                            echo 'left: ' . round($median_left) . '%';

                                            ?>">Mediana<br/><?= number_format_h($median) ?></li>
			                                <li class="_teryt" style="<?

			                                	if( $left===false )
			                                		echo 'display: none;';
			                                	else
			                                		echo 'left: ' . round($left) . '%';

			                                ?>">
			                                	<span class="n"><?= $object->getTitle() ?></span>
			                                	<span class="v"><?= number_format_h($item['wydatki']['value']) ?></span>
			                                </li>
			                                <li class="max">
			                                	<span class="n"><?= @$dzial['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['fields']['source'][0]['data']['gminy.nazwa'] ?></span>
			                                	<span class="v"><?= @number_format_h($max) ?></span>
			                                </li>
		                                </ul>
	                                </div>
                                </div>




								<? /*
								gradient = $('<div></div>').addClass('gradient_cont').append(
									$('<span></span>').addClass('gradient')
								).append(
									$('<ul></ul>').addClass('addons').append(
										$('<li></li>').addClass('min').attr('data-init', d['dzial']['min']).append(
											$('<span></span>').addClass('n').text(d['dzial']['min_nazwa'])
										).append(
											$('<span></span>').addClass('v').text(pl_currency_format(d['dzial']['min']))
										)
									).append(
										$('<li></li>').addClass('max').attr('data-init', d['dzial']['max']).append(
											$('<span></span>').addClass('n').text(d['dzial']['max_nazwa'])
										).append(
											$('<span></span>').addClass('v').text(pl_currency_format(d['dzial']['max']))
										)
									)
								);
								*/ ?>


                                <table class="rozdzialy" style="display: none">
	                            <? if( @$item['rozdzialy']['buckets'] ) { foreach($item['rozdzialy']['buckets'] as $r) {?>

	                            	<? if( $title = @$r['nazwa']['buckets'][0]['key'] ) {?>
	                            	<tr data-id="<?= $r['key'] ?>">
		                            	<td><?= $title ?></td>
		                            	<td><?= number_format_h($r['wydatki']['value']) ?></td>
	                            	</tr>
	                            	<? } ?>

	                            <? } } ?>
                                </table>

                            </a>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>




</div>
