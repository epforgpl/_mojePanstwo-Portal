<?php
$this->Combinator->add_libs('js','Admin.highcharts');
$this->Combinator->add_libs('js','Admin.highcharts-more');
$this->Combinator->add_libs('js','Admin.timeago');
$this->Combinator->add_libs('js','Admin.refresher');
$this->Combinator->add_libs('css','Admin.Analyzer/view');


$data = json_decode($analyzer['AnalyzerExecution']['data'], true);


$dict = array(
    '0' => 'Nieprzetwarzane',
    '1' => 'W kolejce do przetwarzania',
    '2' => 'Aktualnie przetwarzane',
    '3' => 'OK',
    '4' => 'Brak danych',
    '5' => 'Błąd',
    '6' => 'Błąd',
    '7' => 'Błąd',
    '8' => 'Błąd'
);

$jsdict = json_encode($dict);
?>
    <script>
        var dict =<?php echo $jsdict; ?>;
    </script>
    <div class="container">
<?php
$temp = array();
foreach ($data['wartosci'] as $key => $val) {
    echo "<div class='col-sm-12'><hr></div><div class='col-sm-12'><div id='$key'></div></div>";
}
?>
        </div>