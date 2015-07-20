<?php
$this->Combinator->add_libs('js','Admin.highcharts');
$this->Combinator->add_libs('js','Admin.highcharts-more');
$this->Combinator->add_libs('js','Admin.timeago');
$this->Combinator->add_libs('js','Admin.refresher');
$this->Combinator->add_libs('css','Admin.Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);

$dict = array(
    'uzp_dokumenty' => array(
        'title' => 'uzp_dokumenty',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'uzp_dokumenty_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'uzp_dokumenty_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),


    'uzp_wykonawcy' => array(
        'title' => 'uzp_wykonawcy',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'uzp_wykonawcy_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'uzp_wykonawcy_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),


    'uzp_zamawiajacy' => array(
        'title' => 'uzp_zamawiajacy',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'uzp_zamawiajacy_last_err' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'uzp_zamawiajacy_last_corr' => array(
        'title' => ' ',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

);


$jsdict = json_encode($dict);
?>
    <script>
        var dict =<?php echo $jsdict; ?>;
    </script>
    <div class="container">
<?php

foreach ($data as $key => $val) {

    if (strpos($key, 'err') !== false) {
        echo "<div id='$key' class='col-sm-3 label-danger text-white'></div><BR>";
    } elseif (strpos($key, 'corr') !== false) {
        echo "<div id='$key' class='col-sm-3 label-success text-white'></div><BR>";
    } elseif (strpos($key, 'wydania') !== false) {
        echo "<div id='$key' class='col-sm-3 label-info text-white'></div>";
    } else {
        echo "<div class='col-sm-12'><hr></div><div class='col-sm-9'><div id='$key'></div></div>";
    }
}
?>
    </div>