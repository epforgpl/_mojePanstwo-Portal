<?
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);

$dzialy = $dataBrowser['aggs']['gmina']['wydatki']['timerange']['dzialy']['buckets'];


/*
?>
<div class="col-sm-2 col-xs-12 dataAggsContainer">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if (!isset($_submenu['base']))
            $_submenu['base'] = $object->getUrl();

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu,
        ));

    }


    ?>



</div>
<? */ ?>
<div class="col-sm-12">


    <div class="dataWrap">
        <div class="appBanner">
            <h1 class="appTitle">Budżet gminy <?= $object->getTitle(); ?></h1>

        </div>
    </div>

    <? if(isset($filter_options)) { ?>
        <div>
            <div class="appSwitchers text-center">
                <form id="dataForm" method="get" class="col-sm-12">

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="dataSelect">Dane: </label>
                                <select id="dataSelect" class="form-control" name="data">
                                    <? foreach($filter_options['data']['items'] as $i => $item) { ?>
                                        <option value="<?= $item['id'] ?>"<? if($filter_options['data']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                            <?= $item['label'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="rangeSelect">Analizowany okres: </label>
                                <select id="rangeSelect" class="form-control" name="timerange">
                                    <? foreach($filter_options['timerange']['items'] as $i => $item) { ?>
                                        <option value="<?= $item['id'] ?>"<? if($filter_options['timerange']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                            <?= $item['label'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="modeSelect">Porównywane gminy: </label>
                                <select id="modeSelect" class="form-control" name="compare">
                                    <? foreach($filter_options['compare']['items'] as $i => $item) { ?>
                                        <option value="<?= $item['id'] ?>"<? if($filter_options['compare']['selected_id'] == $item['id']) echo ' selected'; ?>>
                                            <?= $item['label'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    <? } ?>


    <div id="mp-sections">
        <div class="content">

			<?
				// debug( array_keys($dataBrowser['aggs']['gminy']['wydatki']['timerange'] )); die();
				// debug( $dataBrowser['aggs']['gmina']['wydatki']['timerange']['wydatki']['value'] ); die();

				$min = @$dataBrowser['aggs']['gminy']['wydatki']['timerange']['min']['buckets'][0]['key'];
				$cur = $dataBrowser['aggs']['gmina']['wydatki']['timerange']['wydatki']['value'];
				$max = @$dataBrowser['aggs']['gminy']['wydatki']['timerange']['max']['buckets'][0]['key'];
				$median = (int) @$dataBrowser['aggs']['gminy']['wydatki']['timerange']['percentiles']['values']['50.0'];
				$left = ($min == $max) ? 0 : 100 * ( $cur - $min ) / ( $max - $min );
				$median_left = ($min == $max) ? 0 : 100 * ( $median - $min ) / ( $max - $min );

			?>



			<? // debug($dataBrowser['aggs']['gminy']['wydatki']['timerange']['histogram_0']); ?>


			<div id="mainChart" class="">
                <div class="histogram_cont">
                    <div class="histogram" data-median="<?= $dataBrowser['aggs']['gminy']['wydatki']['timerange']['percentiles']['values']['50.0'] ?>" data-text="Wydatki w przeliczeniu na osobę" data-histogram='<?= json_encode($dataBrowser['aggs']['gminy']['wydatki']['timerange']['histogram_1']['buckets']) ?>'>
                    </div>
                </div>
                <div class="gradient_cont">
                    <span class="gradient"></span>
                    <ul class="addons">
                        <li class="min">
                        	<span class="n"><?= @$dataBrowser['aggs']['gminy']['wydatki']['timerange']['min']['buckets'][0]['reverse']['top']['hits']['hits'][0]['fields']['source'][0]['data']['gminy.nazwa'] ?></span>
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
                        	<span class="v"><?= number_format_h($cur) ?></span>
                        </li>
                        <li class="max">
                        	<span class="n"><?= @$dataBrowser['aggs']['gminy']['wydatki']['timerange']['max']['buckets'][0]['reverse']['top']['hits']['hits'][0]['fields']['source'][0]['data']['gminy.nazwa'] ?></span>
                        	<span class="v"><?= @number_format_h($max) ?></span>
                        </li>
                    </ul>
                </div>
            </div>

			<div class="row text-center margin-top-20">
				<div class="col-sm-8 col-sm-offset-2">

		            <p>Wydatki zaznaczone kolorem zielonem, to wydatki na które <?= $object->getTitle() ?> wydaje <strong>więcej</strong> niż przeciętna gmina. Wydatki zaznaczone kolorem czerwonym, to wydatki na które <?= $object->getTitle() ?> wydaje <strong>mniej</strong> niż przeciętna gmina.</p>
		            <p>Kliknij na rodzaj wydatków, aby dowiedzieć się więcej:</p>

				</div>
			</div>

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
			                                <li class="min">
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
