<?php
$this->Combinator->add_libs('css', $this->Less->css('bank_danych_lokalnych', array('plugin' => 'BankDanychLokalnych')));
$this->Combinator->add_libs('css', 'BankDanychLokalnych.jqtree.css');
//$this->Combinator->add_libs('css', 'BankDanychLokalnych.jquery.scrollbar.css');
$this->Combinator->add_libs('js', '../plugins/highmaps/js/highmaps');
$this->Combinator->add_libs('js', 'BankDanychLokalnych.tree.jquery.js');
//$this->Combinator->add_libs('js', 'BankDanychLokalnych.jquery.scrollbar.js');
$this->Combinator->add_libs('js', 'BankDanychLokalnych.bank_danych_lokalnych.js');
?>

<div id="bankDanychLokalny">
    <!--<div id="loader" class="loading"></div>-->
    <div class="row no-padding">
        <div class="leftSide col-md-3">
            <div class="scroll">
                <div id="categories"></div>
            </div>
        </div>
        <div class="rightSide col-md-9 no-padding">
            <div id="indicator">
                <h3></h3>

                <div class="row"></div>
            </div>
            <div class="btn-group btn-group-sm" id="levels"></div>
            <div id="desc"></div>
            <!--<select class="form-control" id="year">
                <option>-</option>
            </select>-->
            <div id="map"></div>
        </div>
    </div>
</div>