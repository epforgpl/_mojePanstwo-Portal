<?php
$this->Combinator->add_libs('css', $this->Less->css('bank_danych_lokalnych', array('plugin' => 'BankDanychLokalnych')));
$this->Combinator->add_libs('js', '../plugins/highmaps/js/highmaps');
$this->Combinator->add_libs('js', 'BankDanychLokalnych.bank_danych_lokalnych.js');
?>

<div id="bankDanychLokalny">
    <div class="row">
        <div class="leftSide col-md-3">
            <ul class="tree">
                <li>List tree</li>
            </ul>
        </div>
        <div class="rightSide col-md-9">
            <div id="mapa"></div>
        </div>
    </div>
</div>