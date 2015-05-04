<?php
$this->Combinator->add_libs('css', $this->Less->css('view-kodypocztowe', array('plugin' => 'Dane')));

echo $this->Html->script('//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false', array('block' => 'scriptBlock'));
echo $this->Html->script('../plugins/scriptaculous/lib/prototype', array('block' => 'scriptBlock'));
$this->Combinator->add_libs('js', 'Dane.view-kodypocztowe');
?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
    <div class="object">

        <div class="block">
            <div class="block-header">
                <h2 class="label">Zasięg występowania kodu pocztowego</h2>
            </div>

            <div class="content row">

                <div class="col-md-5">

                    <?php foreach ($object->getLayer('struktura') as $gmina) { ?>
                        <ul class="gminy_ul">
                            <li class="gminy gmina_li" _gs="<?php echo $gmina['nazwa']; ?>">
                                <h2>
                                    <a href="<?php echo $this->Html->url(array(
                                        'plugin' => 'Dane',
                                        'controller' => 'gminy',
                                        'action' => 'view',
                                        'id' => $gmina['id']
                                    )); ?>"><?php echo $gmina['nazwa']; ?></a>
                                    <span class="badge badge-position"><?= $gmina['typ'] ?></span>
                                </h2>
                                <?php if (!empty($gmina['miejscowosci'])) { ?>
                                    <ul class="miejscowosci_ul">
                                        <?php foreach ($gmina['miejscowosci'] as $miejscowosc) { ?>
                                            <li class="miejscowosc_li<?php if ($miejscowosc === end($gmina['miejscowosci'])) {
                                                echo ' last';
                                            } ?>">
                                                <h3><?php echo $miejscowosc['nazwa']; ?> <span
                                                        class="badge badge-position"><?= $miejscowosc['typ'] ?></span>
                                                </h3>
                                                <? if (isset($miejscowosc['miejsca']) && !empty($miejscowosc['miejsca'])) { ?>
                                                    <ul class="miejsca_ul">
                                                        <?php foreach ($miejscowosc['miejsca'] as $miejsce) { ?>
                                                            <li class="miejsce_li
		                                                    <?php if (!(isset($miejscowosc['czesci']) && !empty($miejscowosc['czesci']))) {
                                                                if ($miejsce['adres']) {
                                                                    if ($miejsce === end($miejscowosc['miejsca'])) {
                                                                        echo ' last';
                                                                    }
                                                                } else {
                                                                    echo ' last';
                                                                }
                                                            } ?>">

                                                                <? if ($miejsce['adres']) { ?>
                                                                    <h4><?= $miejsce['adres'] ?></h4>
                                                                <? } else { ?>
                                                                    <p class="all_addresses">Wszystkie adresy</p>
                                                                <? } ?>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <? } ?>

                                                <? if (isset($miejscowosc['czesci']) && !empty($miejscowosc['czesci'])) { ?>
                                                    <ul class="czesci_ul">
                                                        <?php foreach ($miejscowosc['czesci'] as $czesc) { ?>
                                                            <li class="czesc_li<?php if ($czesc === end($miejscowosc['czesci'])) {
                                                                echo ' last';
                                                            } ?>">

                                                                <h4><a href="#"><?php echo $czesc['nazwa']; ?></a> <span
                                                                        class="badge badge-position"><?= $czesc['typ'] ?></span>
                                                                </h4>

                                                                <? if (isset($czesc['miejsca']) && !empty($czesc['miejsca'])) { ?>
                                                                    <ul class="miejsca_ul">
                                                                        <?php foreach ($czesc['miejsca'] as $miejsce) { ?>
                                                                            <li class="miejsce_li<?php if ($miejsce === end($czesc['miejsca'])) {
                                                                                echo ' last';
                                                                            } ?>">

                                                                                <? if ($miejsce['adres']) { ?>
                                                                                    <h4>
                                                                                        <a href="#"><?= $miejsce['adres'] ?></a>
                                                                                    </h4>
                                                                                <? } else { ?>
                                                                                    <p class="all_addresses">Wszystkie
                                                                                        adresy</p>
                                                                                <? } ?>

                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                <? } ?>


                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <? } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        </ul>
                    <?php } ?>


                </div>
                <div class="col-md-7 maps">
                    <div id="map_cont">
                        <div id="mapa"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>