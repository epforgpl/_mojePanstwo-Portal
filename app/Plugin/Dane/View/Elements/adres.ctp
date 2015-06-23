<? if( $adres ) { 	
	
	$this->Combinator->add_libs('css', $this->Less->css('adres', array('plugin' => 'Dane')));
	$this->Combinator->add_libs('js', 'Dane.adres');

?>
<div class="block block-default col-xs-12 adres">
    <header>
        <div class="sm">Adres</div>
        <div class="mapsOptions pull-right">
            <button
                class="googleMap btn btn-sm btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE') ?></button>
            <button
                class="streetView btn btn-sm btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE_STREET') ?></button>
        </div>
    </header>

    <section class="mp-adres nopadding" data-adres="<?= urlencode($adres) ?>">
        <div class="bg">
            <img
                src="http://maps.googleapis.com/maps/api/staticmap?center=<?= urlencode($adres) ?>&markers=<?= urlencode($adres) ?>&zoom=15&sensor=false&size=831x212&scale=2&feature:road"/>

            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"
                 class="content">
                <p><?= $adres ?></p>
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
<? } ?>