<?php
$this->Combinator->add_libs('css', $this->Less->css('kody_pocztowe', array('plugin' => 'KodyPocztowe')));
$this->Combinator->add_libs('js', 'KodyPocztowe.kody.js');
?>

<?= $this->Element('appheader', array('title' => 'Kody pocztowe')); ?>

<div class="header">
    <div class="container details" id="kodyPocztowe">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
                <div class="kodyPocztoweBlock col-xs-12 col-sm-7 pull-left">
                    <div class="row">
                        <p><?php echo __d('kody_pocztowe', "LC_KODY_POCZTOWE_SZUKAM_KODU"); ?></p>

                        <p class="subtitle"><?php echo __d('kody_pocztowe', "LC_KODY_POCZTOWE_ZNAM_ADRES"); ?></p>
                    </div>
                    <div class="row">
                        <form action="/kody_pocztowe" method="get">
                            <div class="input-group">
                                <?php
                                echo $this->Form->input('miejscowosc', array(
                                    'label' => false,
                                    'class' => 'form-control input-lg',
                                    'placeholder' => __d('kody_pocztowe', "LC_KODY_POCZTOWE_WPISZ_MIEJSCOWOSC"),
                                    'id' => 'cityv',
                                    'name' => 'mstr',
                                    'value' => '',
                                    'autocomplete' => 'off'
                                ));
                                ?>
                                <span class="input-group-btn">
	                                <button class="btn btn-success btn-lg" type="submit"
                                            data-icon="&#xe600;"></button>
	                            </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="kodyPocztoweBlock col-xs-12 col-sm-5 pull-right">
                    <div class="row">
                        <p><?php echo __d('kody_pocztowe', "LC_KODY_POCZTOWE_SZUKAM_ADRESU"); ?></p>

                        <p class="subtitle"><?php echo __d('kody_pocztowe', "LC_KODY_POCZTOWE_ZNAM_KOD"); ?></p>
                    </div>
                    <div class="row">
                        <form action="/kody_pocztowe" method="get">
                            <div class="input-group">
                                <?php
                                echo $this->Form->input('kod', array(
                                    'label' => false,
                                    'class' => 'form-control input-lg',
                                    'placeholder' => __d('kody_pocztowe', "LC_KODY_POCZTOWE_WPISZ_KOD"),
                                    'name' => 'kod',
                                    'value' => ''
                                ));
                                ?>
                                <span class="input-group-btn">
	                                <button class="btn btn-success btn-lg" type="submit"
                                            data-icon="&#xe600;"></button>
	                            </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="display">
    <div class="adresList col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <? if (count($adres->getData()) > 0) {
            $adr = $adres->getData(); ?>
            <div class="col-xs-4">
                <small><?= __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_GMINA') ?></small>
                <a href="/dane/gminy/<?= $adr['miejscowosci.gmina_id'] ?>"
                   target="_self"><?= $adr['gminy.nazwa'] ?></a>
            </div>
            <div class="col-xs-4">
                <small><?= __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_MIEJSCOWOSC') ?></small>
                <a href="/dane/miejscowosci/<?= $adr['miejscowosci.id'] ?>"
                   target="_self"><?= $adr['miejscowosci.nazwa'] ?></a>
            </div>
            <div class="col-xs-4">
                <? if (isset($adr['ulica']) && $adr['ulica'] != null) { ?>
                    <? if ($adr['typ_id'] > 1) {
                        switch ($adr['typ_id']) {
                            case '2':
                                $label = __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_ULICA');
                                break;
                            case '3':
                                $label = __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_PLAC');
                                break;
                            case '4':
                                $label = __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_OSIEDLE');
                                break;
                            case '5':
                                $label = __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_ALEJA');
                                break;
                            case '6':
                                $label = __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_SKWER');
                                break;
                            case '7':
                                $label = __d('kody_pocztowe', 'LC_KODY_TABLE_ADRES_WYBRZEZE');
                                break;
                        }
                    } ?>
                    <small><?= $label ?></small>
                    <p><?= $adr['ulica'] ?></p>
                <? } ?>
            </div>
        <? } ?>
    </div>
    <div class="kodyList col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <? if (count($adres->getLayer('kody')) > 0) {
            $kody = $adres->getLayer('kody');
            if (count($kody) == 1) {
                foreach ($kody as $kod) {
                    ?>
                    <span class="center theonlyone">
                        <small><? if (isset($kod['numery'])) {
                                echo $kod['numery'];
                            } ?></small>
                        <a href="/dane/kody_pocztowe/<?= $kod['kod_id'] ?>" target="_self"><?= $kod['kod'] ?></a>
                    </span>
                <?
                }
            } else {
                ?>
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                    <table class="table">
                        <? foreach ($kody as $kod) { ?>
                            <tr>
                                <td>
                                    <small><? if (isset($kod['numery'])) {
                                            echo $kod['numery'];
                                        } ?></small>
                                </td>
                                <td>
                                    <a href="/dane/kody_pocztowe/<?= $kod['kod_id'] ?>"
                                       target="_self"><?= $kod['kod'] ?></a>
                                </td>
                            </tr>
                        <? } ?>
                    </table>
                </div>
            <?
            }
        } ?>
    </div>
</div>