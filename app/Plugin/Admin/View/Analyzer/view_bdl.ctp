<?php
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock-more');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Combinator->add_libs('js','Admin.timeago');
$this->Combinator->add_libs('js','Admin.refresher');
$this->Combinator->add_libs('css','Admin.Analyzer/view');

$data = json_decode($analyzer['AnalyzerExecution']['data'], true);

$dict = array(
    'BDL_kategorie_status' => array(
        'title' => 'BDL_kategorie - status',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'BDL_kategorie_status_last_err' => array(
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
    'BDL_kategorie_status_last_corr' => array(
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


    'BDL_kategorie_s_status' => array(
        'title' => 'BDL_kategorie - s_status',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'BDL_kategorie_s_status_last_err' => array(
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

    'BDL_kategorie_s_status_last_corr' => array(
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


    'BDL_grupy_status' => array(
        'title' => 'BDL_grupy - status',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),

    'BDL_grupy_status_last_err' => array(
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

    'BDL_grupy_status_last_corr' => array(
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

    'BDL_grupy_s_status' =>array(
        'title' => 'BDL_grupy - s_status',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'BDL_grupy_s_status_last_err' => array(
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
    'BDL_grupy_s_status_last_corr' =>array(
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

    'BDL_podgrupy_status' => array(
        'title' => 'BDL_podgrupy - status',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'BDL_podgrupy_status_last_err' => array(
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
    'BDL_podgrupy_status_last_corr' =>array(
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

    'BDL_podgrupy_s_status' => array(
        'title' => 'BDL_podgrupy - s_status',
        '0' => ' ',
        '1' => ' ',
        '2' => ' ',
        '3' => 'OK',
        '4' => ' ',
        '5' => ' ',
        '6' => ' ',
        '7' => ' ',
    ),
    'BDL_podgrupy_s_status_last_err' =>array(
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
    'BDL_podgrupy_s_status_last_corr' =>array(
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
<?= $this->element('Admin.header'); ?>

<h2>BDL</h2>

    <script>
        var dict =<?php echo $jsdict; ?>;
    </script>

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
<?= $this->element('Admin.footer'); ?>
