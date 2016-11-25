<?

if ($object->getPage()) {
    $this->Combinator->add_libs('css', $this->Less->css('radny_details', array('plugin' => 'PrzejrzystyKrakow')));
}

echo $this->Element('dataobject/pageBegin');

echo $this->Html->script('Dane.d3/d3', array('block' => 'scriptBlock'));

////$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krs-graph', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
$this->Combinator->add_libs('js', 'graph-krs');

$page = $object->getLayer('page');
$description =
    (isset($page['description']) && strlen($page['description']) > 0)
        ? $page['description'] :
        (
        $object->getData('cel_dzialania') ?
            $object->getData('cel_dzialania') :
            false
        );

?>

<div class="krsPodmioty margin-top--25">
    <div class="col-xs-12 col-md-3 objectSide">
        <? if (($page = $object->getPage()) || ($email = $object->getData('email')) || ($www = $object->getData('www'))) { ?>
            <div class="iconsList">
                <div class="col-xs-12 nopadding">

                    <? if (($tel = $object->getPage('phone')) && ($tel !== '')) { ?>
                        <div class="option pull-left" data-toggle="modal" data-target="#iconsListDetailPhone">
                            <a data-toggle="tooltip" data-placement="bottom" title="Telefon kontaktowy" href="#"
                               onclick="return false;"><span class="fa fa-phone"></span></a>
                        </div>
                        <div class="modal fade" id="iconsListDetailPhone">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Telefon kontaktowy</h4>
                                    </div>
                                    <div class="modal-body text-center">
                                        <p>Numer telefonu:
                                            <strong><?= $tel ?></strong>
                                        </p>
                                        <a class="btn btn-primary btn-social btn-skype" href="skype:<?= $tel; ?>"><span
                                                class="fa fa-skype"></span> Zadzwoń przez Skype</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Telefon kontaktowy" href="#"
                               onclick="return false;"><span class="fa fa-phone"></span></a>
                        </div>
                    <? } ?>

                    <? if ($fb = $object->getPage('facebook')) { ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="<?= $fb; ?>"
                               target="_blank"><span class="fa fa-facebook"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="#"
                               onclick="return false;"><span class="fa fa-facebook"></span></a>
                        </div>
                    <? } ?>

                    <? if ($twitter = $object->getPage('twitter')) { ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="<?= $twitter; ?>"
                               target="_blank"><span class="fa fa-twitter"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="#"
                               onclick="return false;"><span class="fa fa-twitter"></span></a>
                        </div>
                    <? } ?>
                    <? if (($www = $object->getData('www')) || ($www = $object->getPage('www'))) {
	                    
	                    if( stripos($www, 'http')!==0 )
	                    	$www = 'http://' . $www;
	                    
	                ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="WWW" href="<?= $www; ?>"
                               target="_blank"><span class="glyphicon glyphicon-link"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="WWW" href="#"
                               onclick="return false;"><span class="glyphicon glyphicon-link"></span></a>
                        </div>
                    <? } ?>

                    <? if (($email = $object->getData('email')) || ($email = $object->getPage('email'))) { ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="Adres e-mail"
                               href="mailto:<?= $email; ?>" target="_blank"><span
                                    class="glyphicon glyphicon-envelope"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Adres e-mail" href="#"
                               onclick="return false;"><span class="glyphicon glyphicon-envelope"></span></a>
                        </div>
                    <? } ?>

                    <? if ($youtube = $object->getPage('youtube')) { ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="Kanał YouTube"
                               href="<?= $youtube; ?>"
                               target="_blank"><span class="fa fa-youtube"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Kanał YouTube" href="#"
                               onclick="return false;"><span class="fa fa-youtube"></span></a>
                        </div>
                    <? } ?>

                    <? if ($instagram = $object->getPage('instagram')) { ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="Instagram" href="<?= $instagram; ?>"
                               target="_blank"><span class="fa fa-instagram"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Instagram" href="#"
                               onclick="return false;"><span class="fa fa-instagram"></span></a>
                        </div>
                    <? } ?>

                    <? if ($vine = $object->getPage('vine')) { ?>
                        <div class="option pull-left">
                            <a data-toggle="tooltip" data-placement="bottom" title="Vine" href="<?= $vine; ?>"
                               target="_blank"><span class="fa fa-vine"></span></a>
                        </div>
                    <? } else { ?>
                        <div class="option pull-left inactive">
                            <a data-toggle="tooltip" data-placement="bottom" title="Vine" href="#"
                               onclick="return false;"><span class="fa fa-vine"></span></a>
                        </div>
                    <? } ?>
                </div>
            </div>
        <? } ?>


        <? if (!$object->getData('wykreslony')) {

            $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));

            $bankAccount = $object->getLayer('bank_account');
            if ($bankAccount && $bankAccount['status'] == '1') {
                $this->Combinator->add_libs('js', 'Dane.transferuj');
                echo $this->element('tools/transferuj');
            }

        } ?>

        <ul class="dataHighlights overflow-auto">
            <?
            $nip = $object->getData('nip');
            if (isset($nip) && !empty($nip)) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Numer NIP</p>

                    <p itemprop="taxID" class="_value"><?= $nip ?></p>
                </li>
            <? } ?>

            <?
            $regon = $object->getData('regon');
            if (isset($regon) && !empty($regon)) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Numer REGON</p>

                    <p class="_value"><?= $regon ?></p>
                </li>
            <? } ?>

            <?
            $wartosc_kapital_zakladowy = $object->getData('wartosc_kapital_zakladowy');
            if (isset($wartosc_kapital_zakladowy) && !empty($wartosc_kapital_zakladowy)) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Kapitał zakładowy</p>

                    <p class="_value"><?= number_format_h($wartosc_kapital_zakladowy); ?> PLN</p>
                </li>
            <? } ?>

            <?
            $data_rejestracji = $object->getData('data_rejestracji');
            if (isset($data_rejestracji) && !empty($data_rejestracji)) { ?>
                <li class="dataHighlight col-xs-12">
                    <p class="_label">Data rejestracji</p>

                    <p class="_value"><?= $this->Czas->dataSlownie($data_rejestracji, array(
                            'itemprop' => 'foundingDate',
                        )); ?></p>
                </li>
            <? } ?>

            <div class="dataHighlight-hidden">
                <div class="dataHighlight-content">
                    <? $sygnatura_akt = $object->getData('sygnatura_akt');
                    if (isset($sygnatura_akt) && !empty($sygnatura_akt)) { ?>
                        <li class="dataHighlight col-xs-12">
                            <p class="_label">Sygnatura akt</p>

                            <p itemprop="email" class="_value"><?= $sygnatura_akt ?></p>
                        </li>
                    <? } ?>
                </div>
                <div class="dataHighlight-hidden-button text-center">
                    <button class="dataHighlight-hidden-button-show btn btn-link btn-sm">Więcej &darr;</button>
                    <button class="dataHighlight-hidden-button-hide btn btn-link btn-sm">Mniej &uarr;</button>
                </div>
            </div>
        </ul>
        
        <? if ($object->getData('wykreslony')) { ?>
        <div class="alert alert-sticky alert-danger margin-top-30 margin-bottom-0">
            Prezentowane dane dotyczą chwili, w której podmiot był wykreślany z KRS.
        </div>
        <? } ?>
        
        <? if ($obszary = $object->getPage('obszary_dzialan')) { ?>
            <? if (is_array($obszary) && count($obszary)) { ?>
                <ul class="dataHighlights overflow-auto">
                    <li class="dataHighlight col-xs-12">
                        <p class="_label">Obszary działań</p>

                        <div class="_value">
                            <ul>
                                <? foreach ($obszary as $obszar) { ?>
                                    <li><?= ucfirst($obszar['label']); ?></li>
                                <? } ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            <? } ?>
        <? } ?>
        <? if (!$object->getData('wykreslony')) {

            $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));

            echo '<div class="bannerCol col-xs-6 col-md-12">';
            echo $this->element('tools/krs_odpis', array(
                'href' => '/dane/krs_podmioty/' . $object->getId() . '/odpisy',
            ));
            echo '</div>';

            if (($email = $object->getData('email')) || ($email = $object->getPage('email'))) {
                $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
                $this->Combinator->add_libs('js', 'Pisma.pisma-button');
                echo '<div class="bannerCol col-xs-6 col-md-12">';
                echo $this->element('tools/pismo', array(
                    'href' => '/dane/krs_podmioty/' . $object->getId() . '/odpis',
                ));
                echo '</div>';
            }

            $page = $object->getLayer('page');
            if (!$page['moderated'])
                echo $this->element('tools/admin', array(
                    'href' => '/dane/krs_podmioty/' . $object->getId() . '/odpis',
                ));

        } ?>
    </div>

    <div class="col-xs-12 col-md-9 objectMain">
        <div class="object">

            <? if ($object->getData('wykreslony')) { ?>
            <div class="alert alert-danger margin-top-30 margin-bottom-0">
                Prezentowane dane dotyczą chwili, w której podmiot był wykreślany z KRS.
            </div>
            <? } ?>

            <? if ($description) { ?>
            <div class="block block-simple nobg col-xs-12">
                <header>Misja</header>
                <section class="content textBlock descBlock">
                    <div class="text"
                         data-desc="<?= $description ?>"><?= $this->Html->truncateHtml($description, 200, '...<a class="descMore" style="margin-left:5px" href="#więcej">więcej</a>') ?></div>
                </section>
            </div>
            <? } ?>

            <? if( @$object_aggs['dzialania']['top']['hits']['hits'] ) {?>
            <div class="block block-simple col-xs-12 dzialania">
                <header>Działania</header>
                <div class="margin-sides-5">
	                <section class="content">
	                    <? foreach ($object_aggs['dzialania']['top']['hits']['hits'] as $dzialanie) { ?>
	                        <div class="col-xs-12 col-sm-6 col-md-4">
	                            <h4>
	                                <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>">	                                
	                                    <?= $this->Text->truncate($dzialanie['_source']['data']['dzialania']['tytul'], 55); ?>
	                                </a>
	                            </h4>
								
								<div class="photo col-xs-4 col-sm-12">
                                    <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/dzialania/<?= $dzialanie['_source']['data']['dzialania']['id']; ?>">
	                            <? if ($dzialanie['_source']['data']['dzialania']['photo'] == '1') { ?>
	                                <img
	                                            alt="<?= $dzialanie['_source']['data']['dzialania']['tytul']; ?>"
	                                            src="http://sds.tiktalik.com/portal/2/pages/dzialania/<?= $dzialanie['fields']['id'][0]; ?>.jpg"/>
	                            <? } else { ?>
	                            	<img
	                                            alt="<?= $dzialanie['_source']['data']['dzialania']['tytul']; ?>"
	                                            src="/Ngo/icon/side_ngo.svg"/>
	                            <? } ?>
		                            </a>
                                </div>
	
	                            <div class="desc col-xs-8 col-sm-12">
	                                <?= $this->Text->truncate($dzialanie['_source']['data']['dzialania']['podsumowanie'], 200) ?>
	                            </div>
	                        </div>
	                    <? } ?>
	                </section>
                </div>
                <div class="dataAggs">
	                <div class="buttons">
	                    <a href="<?= $object->getUrl() . '/dzialania' ?>" class="btn btn-default btn-xs">Więcej</a>
	                </div>
                </div>
            </div>
            <? } ?>
									
            <? if( $pisma = @$object_aggs['pisma']['top']['hits']['hits'] ) { ?>
            <div class="block block-simple col-xs-12 dzialania">
                <header>Pisma wysłane przez organizację:</header>
                
                <div class="margin-sides-5">
	                <section class="content">
	                    <? foreach ($pisma as $pismo) { ?>
	                        <div class="col-xs-12 col-sm-6 col-md-4">
	                            <h4>
	                                <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/pisma/<?= $pismo['fields']['id'][0]; ?>">	                                
	                                    <?= $this->Text->truncate($pismo['_source']['data']['pisma']['name'], 55); ?>
	                                </a>
	                            </h4>
	
                                <div class="photo border col-xs-4 col-sm-12">
                                    <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/pisma/<?= $pismo['fields']['id'][0]; ?>"><img src="http://pisma.sds.tiktalik.com/thumbs/<?= $pismo['_source']['data']['pisma']['hash'] ?>-big.png"/></a>
                                </div>
	
	                            <div class="desc col-xs-8 col-sm-12">
	                                Adresat: <?= $pismo['_source']['data']['pisma']['to_label'] ?>
	                            </div>
	                        </div>
	                    <? } ?>
	                </section>
                </div>
                
                <div class="dataAggs margin-top-10">
	                <div class="buttons">
	                    <a href="<?= $object->getUrl() . '/pisma' ?>" class="btn btn-default btn-xs">Więcej</a>
	                </div>
                </div>
                
            </div>
            <? } ?>

            <? if( $kolekcje = @$object_aggs['kolekcje']['top']['hits']['hits'] ) { ?>
            <div class="block block-simple col-xs-12">
                <header>Kolekcje:</header>
                <section class="content margin-sides-10">

                    <div class="agg agg-Dataobjects">
                        <ul class="dataobjects">
                            <? foreach ($kolekcje as $doc) { ?>
                                <li class="margin-top-10">
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    </div>

                </section>
                <div class="linkmore text-center">
                    <a href="<?= $object->getUrl() . '/kolekcje' ?>" class="btn btn-primary btn-xs">więcej</a>
                </div>
            </div>
            <? } 
			
			

            $adres = $object->getData('adres_ulica');
            $adres .= ' ' . $object->getData('adres_numer');
            $adres .= ', ' . $object->getData('adres_miejscowosc');
            $adres .= ', Polska';

            if (($object->getData('adres_ulica')) && ($object->getData('adres_numer')) && ($object->getData('adres_miejscowosc'))) { ?>
            <div class="block block-simple nobg col-xs-12 adres<? if (!$object->getData('cel_dzialania')) { ?> block-simple<? } ?>">
                <header>
                    <div class="sm">Adres</div>
                    <div class="mapsOptions pull-right">
                        <button
                            class="googleMap btn btn-sm btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE') ?></button>
                        <button
                            class="streetView btn btn-sm btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE_STREET') ?></button>
                    </div>
                </header>

                <section class="profile_baner nopadding" data-adres="<?= urlencode($adres) ?>">
                    <div class="bg">
                        <?php switch (Configure::read('Config.language')) {
                            case 'pol':
                                $lang = "pl-PL";
                                break;
                            case 'eng':
                                $lang = "en-EN";
                                break;
                        }; ?>
                        <img
                            src="http://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($adres) ?>&markers=<?= urlencode($adres) ?>&zoom=15&sensor=false&size=831x212&scale=2&feature:road&language=<?= $lang ?>"/>

                        <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"
                             class="content">
                            <p itemprop="streetAddress">
                                ul. <?= $object->getData('adres_ulica') ?> <?= $object->getData('adres_numer') ?><? if ($object->getData('adres_lokal')) { ?>/<?= $object->getData('adres_lokal') ?><? } ?></p>
                            <? if ($object->getData('adres_poczta') != $object->getData('adres_miejscowosc')) { ?>
                                <p><?= $object->getData('adres_miejscowosc') ?></p><? } ?>
                            <p><span itemprop="postalCode"><?= $object->getData('adres_kod_pocztowy') ?></span> <span
                                    itemprop="addressLocality"><?= $object->getData('adres_poczta') ?></span>
                            </p>

                            <p><?= $object->getData('adres_kraj') ?></p>
                        </div>
                    </div>
                    <div class="googleView">
                        <script>
                            var googleMapAdres = '<?= $adres ?>';
                        </script>
                        <div id="googleMap"></div>
                        <div id="streetView"></div>
                    </div>
                </section>
            </div>
            <? }

			
			if( $object->getData('gpw_spolka_id') ) {
				
				$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
				$this->Combinator->add_libs('js', '../plugins/highstock/locals');
			?>
			
			
			
			<div data-url="/<?= $object->getSlug() ?>/notowania.json" class="block block-simple nobg gpw">
				<header><div class="sm">Kurs akcji na GPW:</div></header>
				<section style="height: 300px;">
                    <div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>
				</section>
			</div>
			
				
			<?	
			}
						
			
            if ($object->getId() == '481129') { ?>
            <div class="special banner">
                <a title="Zobacz umowy podpisywane przez Komitet Konkursowy Kraków 2022"
                   href="/dane/krs_podmioty/481129/umowy">
                    <img src="/Dane/img/krakow_special_banner.png" width="885" height="85"/>
                </a>
            </div>
            <?php }
			
			if( $rocznik = @$object_aggs['sprawozdania_opp']['rocznik']['buckets'][0] ) {
			?>
			
			<div class="block-sprawozdania_opp block block-simple col-xs-12">
                <header>
                    <div class="sm">Finanse organizacji</div>
                </header>

                <section class="content">
                    
                    <ul>
	                    <? if( $rocznik['przychody']['buckets'][0]['key'] ) {?>
	                    <li><div class="row">
		                    <div class="col-md-6">
			                    <p>Przychody w <?= $rocznik['key'] ?> r.:</p>
		                    </div>
		                    <div class="col-md-6">
			                    <p class="_value"><?= number_format_h($rocznik['przychody']['buckets'][0]['key']) ?></p>
		                    </div>
	                    </div></li>
	                    <? } ?> 
	                    
	                    <? if( $rocznik['koszty']['buckets'][0]['key'] ) {?>
	                    <li><div class="row">
		                    <div class="col-md-6">
			                    <p>Koszty w <?= $rocznik['key'] ?> r.:</p>
		                    </div>
		                    <div class="col-md-6">
			                    <p class="_value"><?= number_format_h($rocznik['koszty']['buckets'][0]['key']) ?></p>
		                    </div>
	                    </div></li>
	                    <? } ?> 
                    </ul>
                                     
                </section>
                
                <div class="dataAggs margin-top-10">
	                <div class="buttons">
	                    <a href="<?= $object->getUrl() . '/sprawozdania_opp' ?>" class="btn btn-default btn-xs">Więcej</a>
	                </div>
                </div>
                
            </div>
				
			<?	
			}
			
			
            if ($object->getData('sposob_reprezentacji')) { ?>
            <div class="reprezentacja block block-simple nobg col-xs-12">
                <header>
                    <div class="sm">Sposób reprezentacji</div>
                </header>

                <section class="content normalizeText textBlock margin-sides-5 margin-bottom-10">
                    <?= $object->getData('sposob_reprezentacji') ?>
                </section>
            </div>
            <? } ?>

            <div class="organy block-group col-xs-12">
                <? if ($organy_count = count($organy)) {
                if ($organy_count == 1) {
                    $column_width = 12;
                } elseif ($organy_count == 2) {
                    $column_width = 6;
                } elseif ($organy_count == 3) {
                    $column_width = 4;
                } else {
                    $column_width = 6;
                }

                foreach ($organy as $organ) { 
	                
	                if( !$organ['title'] ) {
		                
		                if( $organ['idTag']=='reprezentacja' );
		                	$organ['title'] = 'Organ reprezentacji';
		                
	                }
	                
                ?>
                <div class="block noborder col-xs-12 col-sm-<?= $column_width ?>">
                    <header>
                        <div class="sm normalizeText" id="<?= $organ['idTag'] ?>"><?= $organ['title'] ?></div>
                    </header>

                    <? if ($organ['content']) { ?>
                    <section class="list-group less-borders">
                        <? foreach ($organ['content'] as $osoba) { ?>
                        <? if (@$osoba['osoba_id']) { ?>
                        <a class="list-group-item" href="/dane/krs_osoby/<?= $osoba['osoba_id'] ?>" itemprop="member"
                           itemscope itemtype="http://schema.org/OrganizationRole">
                            <? } elseif (@$osoba['krs_id']) { ?>
                            <a class="list-group-item" href="/dane/krs_podmioty/<?= $osoba['krs_id'] ?>"
                               itemprop="member" itemscope itemtype="http://schema.org/OrganizationRole">
                                <? } else { ?>
                                <div class="list-group-item" itemprop="member" itemscope
                                     itemtype="http://schema.org/OrganizationRole">
                                    <? } ?>

                                    <h4 class="list-group-item-heading" itemprop="member" itemscope
                                        itemtype="http://schema.org/OrganizationPerson">
                                        <span itemprop="name"><?= $osoba['nazwa'] ?></span>
                                        <? if (
                                            ($osoba['privacy_level'] != '1') &&
                                            $osoba['data_urodzenia'] &&
                                            $osoba['data_urodzenia'] != '0000-00-00'
                                        ) {
                                            ?>
                                            <span itemprop="birthDate"
                                                  datetime="<?= substr($osoba['data_urodzenia'], 0, 4) ?>"
                                                  class="wiek"><?= substr($osoba['data_urodzenia'], 0, 4) ?>'</span>
                                        <? } ?>
                                    </h4>

                                    <? if (isset($osoba['funkcja']) && $osoba['funkcja']) {
                                        if ($organ['idTag'] == 'reprezentacja') {
                                            $useLabel = true;
                                            $class = 'warning';

                                            foreach (array('prezes', 'prezydent', 'przewodnicząc') as $phr) {
                                                if (stripos($osoba['funkcja'], ltrim($phr)) === 0) {
                                                    $class = 'danger';
                                                    break;
                                                }
                                            }
                                        } else {
                                            $useLabel = false;
                                        } ?>

                                        <p itemprop="namedPosition"
                                           class="list-group-item-text <? if ($useLabel) { ?> label label-<?= $class ?><? } ?>" title="<?= $osoba['funkcja'] ?>"><?= $this->Text->truncate($osoba['funkcja'], 50) ?></p>
                                    <? } ?>
                                    <? if (@$osoba['osoba_id'] || @$osoba['krs_id']) { ?>
                            </a>
                            <? } else { ?>
                </div>
                <? } ?>
                <? } ?>
                </section>
                <? } ?>
            </div>
            <? } ?>
            <? } ?>
        </div>

        <? if ($wspolnicy = $object->getLayer('wspolnicy')) { ?>
        <div class="wspolnicy block col-xs-12">
            <header>
                <div class="sm">Udziałowcy:</div>
            </header>

            <section>
                <div id="wspolnicy_graph">
                    <div class="list-group less-borders wspolnicy">
                        <? foreach ($wspolnicy as $osoba) { ?>
                        <span itemprop="member" itemscope itemtype="http://schema.org/OrganizationRole">
                                        <? if (@$osoba['osoba_id']) {
                                        $class = "Person"; ?>
                            <a class="list-group-item row" href="/dane/krs_osoby/<?= $osoba['osoba_id'] ?>">
                                <? } elseif (@$osoba['krs_id']) {
                                $class = "Organization"; ?>
                                <a class="list-group-item row" href="/dane/krs_podmioty/<?= $osoba['krs_id'] ?>">
                                    <? } elseif (@$osoba['gmina_id']) {
                                    $class = "Organization"; ?>
                                    <a class="list-group-item row"
                                       href="/dane/gminy/<?= $osoba['gmina_id'] ?>,<?= $osoba['gmina_slug'] ?>">
                                        <? } elseif (@$osoba['powiat_id']) {
                                        $class = "Organization"; ?>
                                        <a class="list-group-item row"
                                           href="/dane/powiaty/<?= $osoba['powiat_id'] ?>,<?= $osoba['powiat_slug'] ?>">
                                            <? } else {
                                            $class = "Intangible"; ?>
                                            <div class="list-group-item row">
                                                <? } ?>

                                                <h4 class="list-group-item-heading col-xs-6" itemprop="member" itemscope
                                                    itemtype="http://schema.org/Organization<?= $class ?>">
                                                    <span itemprop="name"><?= $osoba['nazwa'] ?></span>
                                                    <? if (($osoba['privacy_level'] != '1') && $osoba['data_urodzenia'] && $osoba['data_urodzenia'] != '0000-00-00') { ?>
                                                        <span itemprop="birthDate"
                                                              datetime="<?= substr($osoba['data_urodzenia'], 0, 4) ?>"
                                                              class="wiek"><?= substr($osoba['data_urodzenia'], 0, 4) ?>
                                                            '</span>
                                                    <? } ?>
                                                </h4>

                                                <? if (isset($osoba['funkcja']) && $osoba['funkcja']) { ?>
                                                    <p itemprop="namedPosition"
                                                       class="list-group-item-text normalizeText col-xs-6"><?= $osoba['funkcja'] ?></p>
                                                <? } ?>

                                                <? if (@$osoba['osoba_id'] || @$osoba['krs_id'] || @$osoba['gmina_id'] || @$osoba['powiat_id']) { ?>
                                        </a>
                                        <? } else { ?>
                    </div>
                    <? } ?>
                    </span>
                    <? } ?>
                </div>
        </div>
        </section>
    </div>
    <? } ?>

    <? if ($firmy = $object->getLayer('firmy')) { ?>
        <div class="wspolnicy block col-xs-12">
            <header>
                <div class="sm">Ta firma posiada udziały w:</div>
            </header>

            <section id="wspolnicy_graph">
                <div class="list-group less-borders wspolnicy">
                    <? foreach ($firmy as $firma) { ?>
                        <a class="list-group-item row" href="/dane/krs_podmioty/<?= $firma['id'] ?>">
                            <div class="list-group-item row">
                                <h4 class="list-group-item-heading col-xs-6">
                                    <?= $firma['nazwa'] ?>
                                </h4>

                                <? if (isset($firma['udzialy_str']) && $firma['udzialy_str']) { ?>
                                    <p class="list-group-item-text normalizeText col-xs-6">
                                        <?= $firma['udzialy_str'] ?>
                                    </p>
                                <? } ?>
                            </div>
                        </a>
                    <? } ?>
                </div>
            </section>
        </div>
    <? } ?>
</div>
</div>

</div>

</div></div>

<div class="powiazania block block-simple col-xs-12"<? if( $object->getData('wykreslony') ) {?> style="z-index: -1"<? } ?>>
    <section id="connectionGraph" data-id="<?php echo $object->getId() ?>" data-url="krs_podmioty">
        <div class="spinner grey">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </section>
    <div class="detailInfoWrapper"></div>
</div>

<div class="container">
    <div class="objectsPageContent main">

        <div class="krsPodmioty">
            <div class="col-xs-12 col-md-9 objectMain margin-bottom-20">
                <div class="object">

                    <? if ($dzialalnosci = $object->getLayer('dzialalnosci')) { ?>
                        <div class="block block-default col-xs-12">
                            <header>Działalność według PKD</header>
                            <section>

                                <ul class="dzialalnosci">
                                    <? foreach ($dzialalnosci as $d) { ?>
                                        <li><? if ($d['przewazajaca']) { ?><span class="label label-danger">Działalność przeważająca</span> <? } ?><?= $d['str'] ?>
                                        </li>
                                    <? } ?>
                                </ul>

                            </section>
                        </div>
                    <? } ?>

                </div>
            </div>
        </div>


        <?= $this->Element('dataobject/pageEnd'); ?>
