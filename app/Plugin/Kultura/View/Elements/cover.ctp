<?php

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('css', $this->Less->css('kultura', array('plugin' => 'Kultura')));
$this->Combinator->add_libs('js', 'Kultura.view.js');

?>

<div id="cultureBrowser" class="col-xs-12" data-file_id="<?= $file['id'] ?>">

    <div class="appBanner">

        <h1 class="appTitle">Kultura</h1>
        <p class="appSubtitle">Badanie postrzegania kultury w Polsce</p>
		
		<form action="/kultura" method="get">
	        <div class="appSearch form-group">
	            <div class="input-group">
	                <input name="q" class="form-control" placeholder="Szukaj..." type="text">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary input-md">
	                        <span class="glyphicon glyphicon-search"></span>
	                    </button>
					</span>
	            </div>
	        </div>
		</form>
		
    </div>
	
	<h2 class="fileTitle"><?= $file['name'] ?></h2>
	
	<? if( $hits = @$dataBrowser['aggs']['ankiety']['top']['hits']['hits'] ) { ?>
	<div class="row">
		
		<div class="col-md-9 captions">
		<? foreach( $hits as $hit ) {?>
			
			<div class="block block-captions">
				<header>
					<a href="/dane/kultura_ankiety/<?= $hit['_source']['data']['kultura_ankiety']['id'] ?>"><?= $hit['_source']['data']['kultura_ankiety']['title'] ?></a>
					<div class="spinner grey">
			            <div class="bounce1"></div>
			            <div class="bounce2"></div>
			            <div class="bounce3"></div>
			        </div>
				</header>
				<section class="content">
					
					<? if( $captions = @$hit['_source']['static']['captions'] ) {?>
					<ul class="captions">
						
						<? foreach( $captions as $c ) {?>
							<li data-caption_id="<?= $c['id'] ?>">
								<div class="row">
									<div class="col-md-4">
										<p class="_label"><?= $c['title'] ? $c['title'] : "&nbsp;" ?></p>
									</div><div class="col-md-8">
										<p class="value" style="width: 0;"></p>
									</div>
								</div>
							</li>
						<? } ?>
						
					</ul>
					<? } ?>
					
				</section>
			</div>
			
		<? } ?>
		</div><div class="col-md-3">
			
			<form onsubmit="return false;" class="filtersForm">
				<ul class="filters">
					<li class="fliterLi" data-filter_id="sex">
						<a href="#" class="title"><span class="glyphicon glyphicon-chevron-right"></span> Płeć</a>
						<ul style="display: none;">
							<li><label><input type="radio" name="sex" value="-" checked="checked">Ogółem</label></li>
							<li><label><input type="radio" name="sex" value="M">Mężczyźni</label></li>
							<li><label><input type="radio" name="sex" value="W">Kobiety</label></li>
						</ul>
					</li>
					<li class="fliterLi" data-filter_id="age">
						<a href="#" class="title"><span class="glyphicon glyphicon-chevron-right"></span> Wiek</a>
						<ul style="display: none;">
							<li><label><input type="radio" name="age" value="-" checked="checked">Ogółem</label></li>
						<? foreach( $_ages as $i => $n ) {?>
							<li><label><input type="radio" name="age" value="<?= $i ?>"><?= $n ?></label></li>
						<? } ?>
						</ul>
					</li>
					<li class="fliterLi" data-filter_id="education">
						<a href="#" class="title"><span class="glyphicon glyphicon-chevron-right"></span> Wykształcenie</a>
						<ul style="display: none;">
							<li><label><input type="radio" name="education" value="-" checked="checked">Ogółem</label></li>
						<? foreach( $_educations as $i => $n ) {?>
							<li><label><input type="radio" name="education" value="<?= $i ?>"><?= $n ?></label></li>
						<? } ?>
						</ul>
					</li>
					<li class="fliterLi" data-filter_id="region">
						<a href="#" class="title"><span class="glyphicon glyphicon-chevron-right"></span> Region</a>
						<ul style="display: none;">
							<li><label><input type="radio" name="region" value="-" checked="checked">Ogółem</label></li>
						<? foreach( $_regions as $i => $n ) {?>
							<li><label><input type="radio" name="region" value="<?= $i ?>"><?= $n ?></label></li>
						<? } ?>
						</ul>
					</li>
					<li class="fliterLi" data-filter_id="city_size">
						<a href="#" class="title"><span class="glyphicon glyphicon-chevron-right"></span> Wielkość miejscowości</a>
						<ul style="display: none;">
							<li><label><input type="radio" name="city_size" value="-" checked="checked">Ogółem</label></li>
						<? foreach( $_sizes as $i => $n ) {?>
							<li><label><input type="radio" name="city_size" value="<?= $i ?>"><?= $n ?></label></li>
						<? } ?>
						</ul>
					</li>
					<li class="fliterLi" data-filter_id="household">
						<a href="#" class="title"><span class="glyphicon glyphicon-chevron-right"></span> Typ gospodarstwa</a>
						<ul style="display: none;">
							<li><label><input type="radio" name="household" value="-" checked="checked">Ogółem</label></li>
						<? foreach( $_households as $i => $n ) {?>
							<li><label><input type="radio" name="household" value="<?= $i ?>"><?= $n ?></label></li>
						<? } ?>
						</ul>
					</li>
				</ul>
			</form>
			
		</div>
		
	</div>
	<? } ?>

</div>