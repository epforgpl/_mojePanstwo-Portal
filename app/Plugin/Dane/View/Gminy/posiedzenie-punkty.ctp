<?
echo $this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-posiedzenie');
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>

<h1 class="subheader">Rada Miasta Kraków</h1>
	
<? if (isset($_submenu) && !empty($_submenu)) { ?>
    <div class="menuTabsCont col-md-8">
            <?
            if( !isset($_submenu['base']) )
                $_submenu['base'] = $object->getUrl();
            echo $this->Element('Dane.dataobject/menuTabs', array(
                'menu' => $_submenu,
            ));
            ?>
    </div>
<? } 


echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($__submenu) ? $__submenu : false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
        'routes' => array(
            'shortTitle' => 'pageTitle'
        ),
    ),
));
?>

<div class="krsPodmiotZmiana row">


    <div class="col-lg-9 nopadding">
        <div class="object">
						
			<? if( isset($dataBrowser['hits']) && !empty($dataBrowser['hits'])) {?>
			<div class="block">
				<div class="block-header">
					<h2 class="label">Punkty porządku dziennego</h2>
				</div>
				<div class="content">
										
					<table class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>Numer</th>
								<th>Tytuł</th>
								<th>Wynik rozpatrywania</th>
							</tr>
						</thead>
						<tbody>
							<? foreach( $dataBrowser['hits'] as $object ) { ?>
							<tr>
								<td class="text-center"><span class="punkt-nr"><?= $object->getData('numer') ?></span></td>
								<td><? if($object->getUrl()) {?><a href="<?= $object->getUrl() ?>"><? } ?><?= $object->getData('tytul') ?><? if($object->getUrl()) {?></a><? } ?></td>
								<td><?= $object->getData('krakow_glosowania.wynik_str') ?></td>
							</tr>
							<? } ?>
						</tbody>
					</table>
					
				</div>
			</div>
			<? } ?>

        </div>
    </div>

</div>
<?
echo $this->Element('dataobject/pageEnd');