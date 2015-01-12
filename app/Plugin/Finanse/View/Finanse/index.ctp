<?php $this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse'))) ?>

<? /*
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne'))) ?>

<?php $this->Combinator->add_libs('js', '../plugins/highstock/js/highstock'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highstock/locals'); ?>
<?php $this->Combinator->add_libs('js', 'ZamowieniaPubliczne.zamowieniapubliczne') ?>
<?php $this->Combinator->add_libs('js', 'Dane.dataobjectsslider') ?>
*/
?>

<div class="container" id="zamowienia">
    <div class="mpanel" id="wydatki">

        <? if ($dzialy = $spendings['dzialy']) { ?>

            <div class="buttons">
                <input type="button" value="Rozwiń rozdziały" onclick="$('.rozdzialy').slideToggle(); return false;"/>
            </div>

            <ul class="dzialy">
                <? foreach ($dzialy as $dzial) { ?>

                    <li>
                        <div class="row">
                            <p class="col-md-6 nazwa"><?= $dzial['nazwa'] ?></p>

                            <p class="col-md-6 budzet"><?= number_format_h($dzial['plan'] * 1000) ?></p>
                        </div>
                        <ul class="rozdzialy">
                            <? foreach ($dzial['rozdzialy'] as $rozdzial) { ?>
                                <li>
                                    <div class="row">
                                        <p class="col-md-6 nazwa"><?= $rozdzial['nazwa'] ?></p>

                                        <p class="col-md-6 budzet"><?= number_format_h($rozdzial['plan'] * 1000) ?></p>
                                    </div>
                                </li>
                            <? } ?>
                        </ul>
                    </li>

                <? } ?>
            </ul>

        <? } ?>

    </div>
</div>