<?
	$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
?>
<div class="objectSideInner">
    
    <div class="block block nobg noborder fix">
    
        <ul class="dataHighlights row">


            <? if ($object->getData('wykreslony')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <span class="label label-danger">Podmiot wykreślony z KRS</span>
			    </li>
			<? } ?>
						
			
			<? if ($object->getData('krs')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Numer KRS</p>
			
			        <p class="_value"><?= $object->getData('krs'); ?></p>
			    </li>
			<? } ?>
			
			<? if ($object->getData('nip')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Numer NIP</p>
			
			        <p itemprop="taxID" class="_value"><?= $object->getData('nip'); ?></p>
			    </li>
			<? } ?>
			
			<? if ($object->getData('regon')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Numer REGON</p>
			
			        <p class="_value"><?= $object->getData('regon'); ?></p>
			    </li>
			<? } ?>
			
			
			<? if ($object->getData('wartosc_kapital_zakladowy')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Kapitał zakładowy</p>
			
			        <p class="_value"><?= number_format_h($object->getData('wartosc_kapital_zakladowy')); ?> PLN</p>
			    </li>
			<? } ?>
			
						
			
			<? if ($object->getData('data_rejestracji')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Data rejestracji</p>
			
			        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_rejestracji'), array(
			                'itemprop' => 'foundingDate',
			            )); ?></p>
			    </li>
			<? } ?>
			
			<? /* if ($object->getData('data_dokonania_wpisu')) { ?>
				                    <li class="dataHighlight inl">
				                        <p class="_label">Data ostatniego wpisu</p>
				
				                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_dokonania_wpisu')); ?></p>
				                    </li>
            <? } */ ?>


			<?
			if ($www = $object->getData('www')) {
			    $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
			    ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Strona WWW</p>
			
			        <p class="_value"><a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
			                             href="<?= $url ?>"><?= $www; ?></a></p>
			    </li>
			<? } ?>
			
			<? if ($email = $object->getData('email')) { ?>
			    <li class="dataHighlight col-sm-2">
			        <p class="_label">Adres e-mail</p>
			
			        <p itemprop="email" class="_value"><a target="_blank" href="mailto:<?= $email ?>"><?= $email; ?></a></p>
			    </li>
			<? } ?>
        </ul>
        
        
        <? /*
        <ul class="dataHighlights side hide">
            <? if ($object->getData('forma_prawna_str')) { ?>
			    <li class="dataHighlight inl">
			        <p class="_label">Forma prawna</p>
			
			        <p class="_value"><?= $object->getData('forma_prawna_str'); ?></p>
			    </li>
			<? } ?>
			
			<? if ($object->getData('oznaczenie_sadu')) { ?>
			    <li class="dataHighlight">
			        <p class="_label">Oznaczenie sądu</p>
			
			        <p class="_value"><?= $object->getData('oznaczenie_sadu'); ?></p>
			    </li>
			<? } ?>
			
			<? if ($object->getData('sygnatura_akt')) { ?>
			    <li class="dataHighlight">
			        <p class="_label">Sygnatura akt</p>
			
			        <p class="_value"><?= $object->getData('sygnatura_akt'); ?></p>
			    </li>
			<? } ?>
			
			<? if ($object->getData('wczesniejsza_rejestracja_str')) { ?>
			    <li class="dataHighlight inl">
			        <p class="_label">Wcześniejsza rejestracja</p>
			
			        <p class="_value"><?= $object->getData('wczesniejsza_rejestracja_str'); ?></p>
			    </li>
			<? } ?>

        </ul>

        <p class="text-center showHideSide">
            <a class="a-more">Więcej &darr;</a>
            <a class="a-less hide">Mniej &uarr;</a>
        </p>
        
        */ ?>
    
    </div>
    
        


    <? /* if (!$object->getData('wykreslony')) { ?>
	    <div class="banner block">
	        <?php echo $this->Html->image('Dane.banners/krspodmioty_banner.png', array(
	            'width' => '69',
	            'alt' => 'Aktualny odpis z KRS za darmo',
	            'class' => 'pull-right'
	        )); ?>
	        <p>Pobierz aktualny odpis z KRS <strong>za darmo</strong></p>
	        <a href="/dane/krs_podmioty/<?= $object->getId() ?>/odpis" class="btn btn-primary">Kliknij aby
	            pobrać</a>
	    </div>
	<? } */ ?>
	
</div>