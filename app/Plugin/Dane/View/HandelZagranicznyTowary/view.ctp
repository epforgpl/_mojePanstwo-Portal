<?
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
    $this->Combinator->add_libs('js', 'Dane.view-handel-zagraniczny-towary');
    echo $this->Element('dataobject/pageBegin');
?>
    <div class="Towar">
        <div class="row">
            <div class="col-lg-12">
                <div id="highchartImportExport" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <select id="selectYear" class="form-control"></select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h2 class="text-center">Import</h2>
                <ul class="list-group" id="topImportList"></ul>
            </div>
            <div class="col-lg-6">
                <h2 class="text-center">Eksport</h2>
                <ul class="list-group" id="topExportList"></ul>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var _chartImpEksData = <? echo json_encode($object->getLayer('stats')); ?>;
        var _objectData = <? echo json_encode($object->getData()); ?>;
    </script>

<?= $this->Element('dataobject/pageEnd'); ?>