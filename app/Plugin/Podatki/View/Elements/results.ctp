<?php
$this->Combinator->add_libs('css', $this->Less->css('podatki', array('plugin' => 'Podatki')));
$this->Combinator->add_libs('js', 'Podatki.podatki.js');
?>

<div id="podatki">
    <div class="container">
        <div class="content col-xs-12 row">
            <h1 class="text-center"><?= __d('podatki', 'LC_PODATKI_HEADLINE'); ?></h1>

            <h2 class="text-center"><?= __d('podatki', 'LC_PODATKI_RESULTS_SUBHEADLINE'); ?></h2>
            <hr/>
            <div class="progress">
                <div class="progress-bar progress-bar-success"
                     data-template='<div class="tooltip progress-bar-success" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='Podatek dochodowy (PIT): <strong>23 234,23zł (17%)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top" style="width: 35%">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
                <div class="progress-bar progress-bar-warning"
                     data-template='<div class="tooltip progress-bar-warning" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='Podatek dochodowy (PIT): <strong>23 234,23zł (17%)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top" style="width: 10%">
                    <span class="sr-only">20% Complete (warning)</span>
                </div>
                <div class="progress-bar progress-bar-danger"
                     data-template='<div class="tooltip progress-bar-danger" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='Podatek dochodowy (PIT): <strong>23 234,23zł (17%)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top" style="width: 17%">
                    <span class="sr-only">Podatek dochodowy (PIT): <strong>23 234,23zł (17%)</strong></span>
                </div>
                <div class="progress-bar progress-bar-primary"
                     data-template='<div class="tooltip progress-bar-primary" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                     title='Podatek dochodowy (PIT): <strong>23 234,23zł (17%)</strong>'
                     data-html="true" data-toggle="tooltip" data-placement="top" style="width: 38%">
                    <span class="sr-only">10% Complete (danger)</span>
                </div>
            </div>
            <div class="info_numbers">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_BRUTTO'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PRZYCHODY_NETTO'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-newline">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS_TY'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS_PRACODAWCA'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_ZUS'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_PIT'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_VAT'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <small><?= __d('podatki', 'LC_PODATKI_RESULTS_INFO_NUMBERS_AKCYZA'); ?></small>
                    <strong>123 234,23 zł</strong>
                </div>
            </div>
            <div class="row items">
                <div class="block col-xs-12 col-sm-6 col-md-3">
                    <div data-id="5" class="item more">
                        <a data-title="Oświata i wychowanie" class="inner" href="#5">
                            <div class="logo">
                                <i class="icon-dzialy-5"></i>
                            </div>
                            <div class="details">
                                <span class="detail">262&nbsp;mln</span>
                            </div>
                            <div class="title">
                                <div class="nazwa">Oświata i wychowanie</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="block col-xs-12 col-sm-6 col-md-3">
                    <div data-id="5" class="item more">
                        <a data-title="Oświata i wychowanie" class="inner" href="#5">
                            <div class="logo">
                                <i class="icon-dzialy-5"></i>
                            </div>
                            <div class="details">
                                <span class="detail">262&nbsp;mln</span>
                            </div>
                            <div class="title">
                                <div class="nazwa">Oświata i wychowanie</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
