<?

$this->Combinator->add_libs('js', 'Dane.view-instytucje_urzednik');
$this->Combinator->add_libs('css', $this->Less->css('view-instytucje_urzednik', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $urzednik,
    'objectOptions' => array(
        'truncate' => 1000,
        'mode' => 'subobject',
    ),
));
?>
    <div class="urzednik row">
        <div class="col-md-12">
            <div class="object">
								
				<? if( $rejestr_korzysci ) { ?>
				<div class="block block-files margin-top-20">
					<header>Rejestr korzyści:</header>
					<section class="content">
						
						<ul>
						<? foreach( $rejestr_korzysci as $c ) { ?>
							
							<li class="col-md-4 documentFastCheck">
								<a data-id="<?= $c['id'] ?>" data-documentid="<?= $c['dokument_id'] ?>" href="<?= $urzednik->getUrl() ?>?rk=<?= $c['id'] ?>" >
								<div class="avatar">
									<img src="http://docs.sejmometr.pl/thumb/1/<?= $c['dokument_id'] ?>.png" />
								</div><div class="content">
									<p class="nazwa"><?= $c['za_osobe'] ?></p>
									<p class="data"><?= dataSlownie($c['data_zgloszenia']) ?></p>
								</div>
								</a>
							</li>
							
						<? }?>
						</ul>
						
					</section>
				</div>
				<? } ?>
				
            </div>
        </div>
    </div>
<?
echo $this->Element('dataobject/pageEnd');