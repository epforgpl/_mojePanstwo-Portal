<?
// $this->Combinator->add_libs('css', $this->Less->css('view-administracjapubliczna', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('js', 'Dane.view-administracjapubliczna');

$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', 'Dane.view-panstwa');
$this->Combinator->add_libs('css', $this->Less->css('view-panstwa', array('plugin' => 'Dane')));
echo $this->Element('dataobject/pageBegin');
?>
</div></div></div>

    <div class="container">
        <div class="Panstwo">
            <div class="row">
                <div class="col-lg-12">
                    <div id="highchartImportExport" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <p style="font-size: 11px; margin-bottom: 20px;" class="chart-desc text-center">Dane za 2014 r. są wstępne i dotyczą pierwszych trzech kwartałów.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="tree">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-lg-offset-5">
                    <select id="selectYear" class="form-control"></select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h2>Import towarów do Polski</h2>
                    <ul id="import"></ul>
                </div>
                <div class="col-lg-6">
                    <h2>Export towarów z Polski</h2>
                    <ul id="export"></ul>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    var _chartImpEksData = <? echo json_encode($object->getLayer('stats')); ?>;
    var _objectData = <? echo json_encode($object->getData()); ?>;
    var _year = '<? echo isset($_GET['y']) ? (int) $_GET['y'] : 2014; ?>';
</script>

<div><div><div>

<?= $this->Element('dataobject/pageEnd'); ?>