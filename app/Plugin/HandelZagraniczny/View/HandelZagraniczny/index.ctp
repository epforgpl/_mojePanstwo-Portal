<?php
$this->Combinator->add_libs('css', $this->Less->css('handel_zagraniczny', array('plugin' => 'HandelZagraniczny')));
$this->Combinator->add_libs('css', $this->Less->css('naglosnij', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
$this->Combinator->add_libs('js', '../plugins/highcharts/plugin/map');
$this->Combinator->add_libs('js', 'HandelZagraniczny.handel_zagraniczny.js');
$this->Combinator->add_libs('js', 'Dane.naglosnij.js');
?>

<div id="morebg"></div>
<div id="more"></div>
<div class="mapMain">
    <div id="maplabel" class="maplabel">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid container">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <p class="navbar-text">Statystyki polskiego handlu zagranicznego</p>

                    <form class="navbar-form navbar-right">
                        <div class="form-group">
                            <span class="text-muted">Rok: &nbsp;</span>
                            <select class="form-control hzYearSelect">
                                <?php
                                $startYear = 2005;
                                $endYear = date("Y");

                                for ($x = $startYear; $x <= $endYear; $x++) {
                                    $option = '<option value="' . $x . '"';

                                    if ($x == $endYear)
                                        $option .= ' selected';

                                    echo $option . '>' . $x . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!--<div class="naglosnijHandler">
        <?php echo $this->element('Dane.dataobject/buttons/shoutIt'); ?>
    </div>-->
    </div>
    <ul class="nav nav-pills hzTypeMenu">
        <li class="active"><a href="#">Import</a></li>
        <li><a href="#">Eksport</a></li>
        <li><a href="#">Wymiana</a></li>
    </ul>
    <div id="hzMap">
        <div class="loading"></div>
    </div>
</div>
<div id="hzDetails">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Import</h2>

                <p class="lead">Państwa od których Polska importowała najwięcej w <span class="hzYearAttr">2014</span>
                    roku</p>
                <ul class="list-group" id="hzImportCountries"></ul>
                <p class="lead">Towary których Polska importowała najwięcej w <span class="hzYearAttr">2014</span> roku
                </p>
                <ul class="list-group" id="hzImportSymbols"></ul>
            </div>
            <div class="col-md-6">
                <h2>Eksport</h2>

                <p class="lead">Państwa do których Polska eksportowała najwięcej w <span class="hzYearAttr">2014</span>
                    roku</p>
                <ul class="list-group" id="hzExportCountries"></ul>
                <p class="lead">Towary których Polska eksportowała najwięcej w <span class="hzYearAttr">2014</span> roku
                </p>
                <ul class="list-group" id="hzExportSymbols"></ul>
            </div>
        </div>
        <div class="src text-center" style="color: #666; font-size: 12px; margin-top: 20px;">
            <p>Dane za 2014 r. są wstępne i dotyczą pierwszych trzech kwartałów.</p>

            <p>Źródło: <a href="http://hinex.stat.gov.pl/hinex/aspx/index.aspx" target="_blank">hinex.stat.gov.pl/hinex/aspx/index.aspx</a>
            </p>
        </div>
    </div>
</div>
<!--
<div class="container">

</div>-->