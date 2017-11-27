<? if ($adres) {

    $this->Combinator->add_libs('css', $this->Less->css('adres', array('plugin' => 'Dane')));
    $this->Combinator->add_libs('js', 'Dane.adres');

    ?>
    <div class="block block-default col-xs-12 adres">
        <header>
            <div class="sm"><?= isset($label) ? $label : 'Adres' ?></div>
            <div class="mapsOptions pull-right">
                <button type="button" class="btn btn-default btn-sm googleMapBtnModal reload">Otwórz mapę</button>
            </div>
        </header>

        <section class="mp-adres nopadding" data-adres="<?= urlencode($adres) ?>">
            <div class="bg">
                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"
                     class="content">
                    <p><?= $adres ?></p>
                </div>
            </div>
        </section>

        <div class="modal show fade first" id="googleMapBtnModal" tabindex="-1" role="dialog"
             aria-labelledby="googleMapBtnModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="googleMapBtnModalLabel">Adres</h4>
                    </div>
                    <div class="modal-body">
                        <div class="googleViewBtn">
                            <button
                                class="showGoogleMap active btn btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE') ?></button>
                            <button
                                class="showStreetView btn btn-default"><?= __d('dane', 'LC_DANE_VIEW_KRSPODMIOTY_OTWORZ_MAPE_STREET') ?></button>
                        </div>
                        <div class="googleView">
                            <script>
                                var container = document.createElement('div');
                                container.innerHTML = '<?= trim(preg_replace('/\s+/', ' ', $adres)) ?>';
                                var googleMapAdres = container.textContent || container.innerText;
                            </script>
                            <div id="googleMap"></div>
                            <div id="streetView"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>
