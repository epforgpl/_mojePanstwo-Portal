<?
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
    $this->Combinator->add_libs('js', 'Dane.view-handel-zagraniczny-towary');
    $this->Combinator->add_libs('css', $this->Less->css('view-handel-zagraniczny-towary', array('plugin' => 'Dane')));
    echo $this->Element('dataobject/pageBegin');
?>
</div></div></div>

    <div class="container">
        <div class="Towar">
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
                    <h2>Import do Polski</h2>
                    <ul id="import"></ul>
                </div>
                <div class="col-lg-6">
                    <h2>Export z Polski</h2>
                    <ul id="export"></ul>
                </div>
            </div>
        </div>
    </div>

<!--
        <div class="row">
            <div class="col-lg-6" id="childsMain">
                <h2 class="text-center">Towary w tej grupie</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="text-center">Import do Polski</h3>
                        <ul class="list-group" id="childsImport"></ul>
                    </div>
                    <div class="col-lg-6">
                        <h3 class="text-center">Eksport z Polski</h3>
                        <ul class="list-group" id="childsExport"></ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12" id="countriesMain">
                <h2 class="text-center">Państwa handlujące tym towarem</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="text-center">Import do Polski</h3>
                        <ul class="list-group" id="topImportList"></ul>
                    </div>
                    <div class="col-lg-6">
                        <h3 class="text-center">Eksport z Polski</h3>
                        <ul class="list-group" id="topExportList"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <script type="text/javascript">
        var _chartImpEksData = <? echo json_encode($object->getLayer('stats')); ?>;
        var _objectData = <? echo json_encode($object->getData()); ?>;
        var _year = '<? echo isset($_GET['y']) ? (int) $_GET['y'] : 2014; ?>';
    </script>


<div><div><div>
<?= $this->Element('dataobject/pageEnd'); ?>