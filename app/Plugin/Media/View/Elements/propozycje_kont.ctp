<?

$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('media-cover', array('plugin' => 'Media')));
$this->Combinator->add_libs('css', $this->Less->css('media-propozycje', array('plugin' => 'Media')));

$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Media.media-cover');

$options = array(
    'mode' => 'init',
);

?>

<div class="col-xs-12 col-md-3 dataAggsContainer">
    <div class="sticky">
	    <? echo $this->Element('Dane.DataBrowser/aggs', array(
	        	'data' => $dataBrowser,
	    )); ?>

        <? if(isset($twitterAccountTypes)) { ?>
	        <?= $this->Element('Media.twitter-account-suggestion', array(
	            'types' => $twitterAccountTypes
	        )); ?>
	    <? } ?>
    </div>
</div>

<div class="col-xs-12 col-md-9">	
	
	<p class="text-center margin-top-15">Aktualizacja: <?= date('Y-m-d- H:i:s', $time['stop']) ?></p>
	
	<? if( $accounts_keys = $dataBrowser['aggs']['new']['accounts']['buckets'] ) { ?>
	<ul class="accounts_ul">
	<? foreach( $accounts_keys as $key ) { ?>
		<li>
			
			<?
				$account = $accounts[ $key['key'] ];
				$tweets = $key['tweets']['hits']['hits'];
			?>
			
			<div class="account">
				<p class="bar pull-left"><?= $account['twitter_user_name'] ?> <a href="https://twitter.com/<?= $account['twitter_user_screenname'] ?>" target="_blank">@<?= $account['twitter_user_screenname'] ?></a></p>
				
				<form action="" method="post" />
					<input type="hidden" name="id" value="<?= $account['twitter_user_id'] ?>" />
					<div class="btn-group pull-right buttons">
						<div class="btn-group">
							<button aria-expanded="false" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
								Dodaj jako
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
							<? foreach( $twitterAccountTypes as $k => $v ) {?>
								<li><input type="submit" name="add" class="_clear" value="<?=$v?>" /></li>
							<? } ?>
							</ul>
						</div>
						<input type="submit" name="ignore" class="btn btn-sm btn-default" value="Ignoruj" />
					</div>
				</form>
				
			</div>
			
			<div class="dataAggs">
				<div class="agg agg-Dataobjects">
					<ul class="dataobjects">
					<? foreach( $tweets as $t ) {?>
						<li><?= $this->Dataobject->render($t, 'default') ?></li>
					<? } ?>
					</ul>
				</div>
			</div>
			
		</li>
	<? } ?>
	</ul>
	<? } ?>
	
</div>
