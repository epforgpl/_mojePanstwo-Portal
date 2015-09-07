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
            <h1 class="appTitle">Wydatki gminy Kraków</h1>

        </div>
    </div>

    <div id="accountsSwitcher" class="appMenuStrip row">
        <? if (isset($twitterTimeranges) && isset($twitterTimerange)) { ?>
            <div class="appSwitchers">
                <div class="dataWrap">
                    <div class="pull-left">
                        <p class="_label">Analizowany okres:</p>
                        <ul class="nav nav-pills">
                            <? foreach ($twitterTimeranges as $key => $value) { ?>
                                <li<? if ($twitterTimerange == $key) echo ' class="active"' ?>>
                                    <a href="/media?t=<?= $key ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>">
                                        <?= $value ?>
                                    </a>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                    <div class="pull-right">
                        <ul class="nav nav-pills">
                            <li<? if (isset($this->request->query['t']) && ($this->request->query['t'] == $last_month_report['param'])) echo ' class="active"' ?>>
                                <a href="/media?t=<?= $last_month_report['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>"><?= $last_month_report['label'] ?></a>
                            </li>

                            <? if (isset($dropdownRanges)) { ?>
                                <li<? if ($twitterTimerange == $key) echo ' class="active"' ?>>
                                    <div class="dropdown">
                                        <button class="clear dropdown-toggle" type="button" id="dropdownRanges"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Więcej <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownRanges">
                                            <? foreach ($dropdownRanges as $dropdown) { ?>
                                                <li class="dropdown-title"><?= $dropdown['title'] ?></li>
                                                <? foreach ($dropdown['ranges'] as $range) { ?>
                                                    <li<? if ($twitterTimerange == $range['param'] && strlen($twitterTimerange) === strlen($range['param'])) echo ' class="active"'; ?>>
                                                        <a href="/media?t=<?= $range['param'] ?><? if (isset($twitterAccountType) && $twitterAccountType !== '0') echo "&a=" . $twitterAccountType; ?>">
                                                            <?= $range['label'] ?>
                                                        </a>
                                                    </li>
                                                <? } ?>
                                            <? } ?>
                                        </ul>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
    
    
    <? /*
    <div class="dataWrap">
        <div class="text-center">
	        <p>Suma wydatków:</p>
	        <p><?= number_format_h($dataBrowser['aggs']['gmina']['wydatki']['timerange']['wydatki']['value']); ?></p>
        </div>
    </div>
    
    <ul class="nav nav-tabs">
		<li class="active"><a href="#home" data-toggle="tab">Porównanie wydatków - w przeliczeniu na osobę</a></li>
		<li><a href="#profile" data-toggle="tab">Porównanie wydatków - wartości absolutne</a></li>
    </ul>
    */ ?>
    
    
    <div id="mp-sections">
        <div class="content">
            
            <p class="text-center">Klikniaj na rodzaj wydatków, aby dowiedzieć się więcej:</p>
            
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
													
							$left = ($min == $max) ? false : 100 * ( $cur - $min ) / ( $max - $min );
							
							$class = ($cur > $median) ? 'more' : 'less';
							
							$diff = $dzial['stats']['max'] - $dzial['stats']['min'];
							$intervals = array(100000000, 10000000, 1000000, 100000);
							$histogram_i = 0;
							
							
							for( $i=count($intervals)-1; $i--; $i>=0 ) {
								
								$v = $intervals[$i];
																								
								if( $diff<$v*100 ) {
									$histogram_i = $i;
									break;
								}
								
							}
							
				
							
							
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
