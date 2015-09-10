<?
$this->Combinator->add_libs('css', $this->Less->css('finanse', array('plugin' => 'Finanse')));

$this->Combinator->add_libs('css', $this->Less->css('mp-sections', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Finanse.budzety');
$this->Combinator->add_libs('js', 'Finanse.budzety-tiles');


?>

<div class="col-xs-12 col-md-2 dataAggsContainer">
    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
</div>

<div class="col-xs-12 col-md-10">

    <div class="appBanner">
        <h1 class="appTitle">Finanse publiczne</h1>

        <p class="appSubtitle">Poznaj stan finansów publicznych Polski.</p>
    </div>

    <div id="mp-sections">
        <div class="content">
            <div class="row items">

                <?
                $GDP = array(
                    'PKB' => array(),
                    'PKB_per_capita' => array()
                );
                $ver=array();
                foreach($pkb['PKB'] as $rok){
                    $a=(float) $rok['PKB'];
                    $b=$pkb['USD'][$rok['rocznik']]['USD'];
                    $c=(float)$a * (float)$b;
                    $GDP['PKB'][]=array('name'=>$rok['rocznik'],'y'=>$pkb['USD'][$rok['rocznik']]['USD']*$rok['PKB']);
                    $GDP['PKB_per_capita'][]=array('name'=>$rok['rocznik'],'y'=>$rok['PKB_per_capita']*$pkb['USD'][$rok['rocznik']]['USD']);

                }
                ?>

                <div class="block col-md-3">
                    <div class="item" data-id="PKB">
                        <a href="#PKB" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/5.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Produkt Krajowy Brutto</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Produkt Krajowy Brutto" data-histogram='<?= json_encode($GDP['PKB']) ?>'>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item" data-id="PKB_per_capita">
                        <a href="#PKB_per_capita" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Produkt Krajowy Brutto na osobę</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Produkt Krajowy Brutto na osobę" data-histogram='<?= json_encode($GDP['PKB_per_capita']) ?>'>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
                <?
                $dlug=array();
                foreach($pkb['dlug'] as $row){
                    $dlug[]=array('name'=>$row['rocznik'], 'y'=>$row['sektor_finansow_pub']*1000000);
                }
                ?>
                <div class="block col-md-3">
                    <div class="item" data-id="dlug">
                        <a href="#dlug" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Zadłużenie</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Zadłużenie Sektora Finansów Publicznych" data-histogram='<?= json_encode($dlug) ?>'>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
                <?
                $bezrobocie=array();
                foreach($pkb['bezrobocie'] as $row){
                    $bezrobocie[]=array('name'=>$row['rocznik'], 'y'=>$row['v']);
                }?>
                <div class="block col-md-3">
                    <div class="item" data-id="bezrobocie">
                        <a href="#bezrobocie" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Stopa bezrobocia</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Stopa bezrobocia" data-histogram='<?= json_encode($bezrobocie) ?>'>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>
                </div>
                <?
                $dane_budzet=array(
                    'dochody'=>array(),
                    'wydatki'=>array(),
                    'deficyt'=>array(),
                );
                foreach($dataBrowser['aggs']['budzety']['top']['hits']['hits'] as $row){
                    if($row['fields']['source'][0]['data']['prawo.rok']!=1989) {
                        $dane_budzet['dochody'][$row['fields']['source'][0]['data']['prawo.rok']] = array('name' => $row['fields']['source'][0]['data']['prawo.rok'], 'y' => $row['fields']['source'][0]['data']['budzety.liczba_dochody']);
                        $dane_budzet['wydatki'][$row['fields']['source'][0]['data']['prawo.rok']] = array('name' => $row['fields']['source'][0]['data']['prawo.rok'], 'y' => $row['fields']['source'][0]['data']['budzety.liczba_wydatki']);
                        $dane_budzet['deficyt'][$row['fields']['source'][0]['data']['prawo.rok']] = array('name' => $row['fields']['source'][0]['data']['prawo.rok'], 'y' => $row['fields']['source'][0]['data']['budzety.liczba_deficyt']);
                    }
                }
                sort($dane_budzet['dochody']);
                sort($dane_budzet['wydatki']);
                sort($dane_budzet['deficyt']);
                $dane_budzet['dochody']=array_values($dane_budzet['dochody']);
                $dane_budzet['wydatki']=array_values($dane_budzet['wydatki']);
                $dane_budzet['deficyt']=array_values($dane_budzet['deficyt']);

                ?>
                <div class="block col-md-3">
                    <div class="item" data-id="budzet_dochody">
                        <a href="#budzet_dochody" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Dochody budżetu krajowego</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Dochody budżetu krajowego" data-histogram='<?= json_encode($dane_budzet['dochody']) ?>'>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item" data-id="budzet_wydatki">
                        <a href="#budzet_wydatki" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Wydatki budżetu krajowego</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Wydatki budżetu krajowego" data-histogram='<?= json_encode($dane_budzet['wydatki']) ?>'>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item" data-id="budzet_deficyt">
                        <a href="#budzet_deficyt" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Deficyt budżetu krajowego</div>
                            </div>
                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Deficyt budżetu krajowego" data-histogram='<?= json_encode($dane_budzet['deficyt']) ?>'>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?
                $inflacja=array();
                foreach($pkb['inflacja'] as $row){
                    $inflacja[]=array('name'=>$row['rocznik'], 'y'=>$row['v']-100);
                }?>
                <div class="block col-md-3">
                    <div class="item" data-id="inflacja">
                        <a href="#inflacja" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Inflacja</div>
                            </div>

                            <div class="highchart" style="display: none;">
                                <div class="histogram_cont">
                                    <div class="histogram" data-text="Inflacja" data-histogram='<?= json_encode($inflacja) ?>'>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="chart" data-json='<?php echo json_encode($dataBrowser['aggs']['budzety']['top']['hits']['hits']); ?>'
         style="z-index: 5; position: relative;"></div>
    <div class="mid-chart" style="margin-top: -60px; z-index: 0; position: relative;"></div>
    <div class="chart2" style="margin-top: -40px; z-index: 15; position: relative;"></div>

</div>
