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
                   $a=(double) $rok['PKB'];
                        $b=(double) $pkb['USD'][$rok['rocznik']];
                    $f_pkb=$a*$b;
                    $GDP['PKB'][]=array('name'=>$rok['rocznik'],'y'=>$f_pkb);
                    //$GDP['PKB_per_capita'][]=array('name'=>$rok['rocznik'],'y'=>$rok['PKB_per_capita']*$pkb['USD'][$rok['rocznik']]);

                 //   $ver[]=$rok['PKB']/$rok['PKB_per_capita'];
                }
//debug($ver);
debug($GDP);
                ?>

                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

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
                    <div class="item">
                        <a href="#" class="inner">

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
                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Zadłużenie</div>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Stopa bezrobocia</div>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Dochody budżetu krajowego</div>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Wydatki budżetu krajowego</div>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Deficyt budżetu krajowego</div>
                            </div>

                        </a>
                    </div>
                </div>
                <div class="block col-md-3">
                    <div class="item">
                        <a href="#" class="inner">

                            <div class="logo">
                                <img src="/finanse_gmin/img/sections/1.svg" onerror="imgFixer(this)"/>
                            </div>

                            <div class="details">
                                <span class="detail">123</span>
                            </div>

                            <div class="title">
                                <div class="nazwa">Inflacja</div>
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
