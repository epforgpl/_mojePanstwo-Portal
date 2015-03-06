<?php
$this->Combinator->add_libs('css', $this->Less->css('kody_pocztowe', array('plugin' => 'KodyPocztowe')));
$this->Combinator->add_libs('css', $this->Less->css('kody_pocztowe_index', array('plugin' => 'KodyPocztowe')));
$this->Combinator->add_libs('js', 'KodyPocztowe.kody.js');
?>

<?= $this->Element('appheader', array('title' => 'Kody pocztowe')); ?>

<div class="container<? if ($details) {
    echo " details";
} ?>" id="kodyPocztowe">
    <div class="row<? if ($mid) {
        echo 'hide';
    } ?>">
        <div class="col-xs-12 col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2">
            <div class="kodyPocztoweBlock col-xs-12 col-sm-7 pull-left">
                <div class="row">
                    <p><?php echo __d('kody_pocztowe', "LC_KODY_POCZTOWE_SZUKAM_KODU"); ?></p>

                    <p class="subtitle"><?php echo __d('kody_pocztowe', "LC_KODY_POCZTOWE_ZNAM_ADRES"); ?></p>
                </div>
                <div class="row">
                    <form action="/kody_pocztowe" method="get">
                        <div class="input-group">
                            <?php echo $this->Form->input('miejscowosc', array(
                                'label' => false,
                                'class' => 'form-control input-lg',
                                'placeholder' => __d('kody_pocztowe', "LC_KODY_POCZTOWE_WPISZ_MIEJSCOWOSC"),
                                'id' => 'cityv',
                                'name' => 'mstr',
                                'value' => $mstr,
                                'autocomplete' => 'off'
                            )); ?>
                            <span class="input-group-btn">
                            <button class="btn btn-success btn-lg" type="submit" data-icon="&#xe600;"></button>
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
                            <?php echo $this->Form->input('kod', array(
                                'label' => false,
                                'class' => 'form-control input-lg',
                                'placeholder' => __d('kody_pocztowe', "LC_KODY_POCZTOWE_WPISZ_KOD"),
                                'name' => 'kod',
                                'value' => $kod
                            )); ?>
                            <span class="input-group-btn">
                                <button class="btn btn-success btn-lg" type="submit" data-icon="&#xe600;"></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
