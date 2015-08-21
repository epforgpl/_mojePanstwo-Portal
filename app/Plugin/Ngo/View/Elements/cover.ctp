<?php $this->Combinator->add_libs('css', $this->Less->css('ngo', array('plugin' => 'Ngo'))) ?>

<div class="col-xs-12 col-md-3 dataAggsContainer">

    <? if(isset($_submenu) && isset($_submenu['items'])) {

        if(!isset($_submenu['base']))
            $_submenu['base'] = '/ngo';

        echo $this->Element('Dane.DataBrowser/browser-menu', array(
            'menu' => $_submenu,
        ));

    } ?>

    <div class="panel panel-primary col-xs-12" data-toggle="modal" data-target="#ngoPartnerModal">
        <div class="panel-body">
            Zostań oficjalnym partnerem mojegoPaństwa
        </div>
    </div>
    <?php echo $this->element('Ngo.ngo_partner_modal') ?>

    <? echo $this->Element('Dane.DataBrowser/aggs', array(
            'data' => $dataBrowser,
    )); ?>

</div>

<div class="col-md-9 col-xs-12">

    <div class="block col-xs-12">
        <header>Ostatnio zarejestrowane fundacje</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['fundacje']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['fundacje']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </section>
        <footer>
            <div class="buttons text-center">
                <a href="/ngo/fundacje" class="btn btn-primary btn-sm">Zobacz więcej</a>
            </div>
        </footer>
    </div>

    <div class="block col-xs-12">
        <header>Ostatnio zarejestrowane stowarzyszenia</header>
        <section class="aggs-init">
            <div class="dataAggs">
                <div class="agg agg-Dataobjects">
                    <? if ($dataBrowser['aggs']['stowarzyszenia']['doc_count']) { ?>
                        <ul class="dataobjects">
                            <? foreach ($dataBrowser['aggs']['stowarzyszenia']['top']['hits']['hits'] as $doc) { ?>
                                <li>
                                    <?
                                    echo $this->Dataobject->render($doc, 'default');
                                    ?>
                                </li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </section>
        <footer>
            <div class="buttons text-center">
                <a href="/ngo/stowarzyszenia" class="btn btn-primary btn-sm">Zobacz więcej</a>
            </div>
        </footer>
    </div>

</div>
<? /*
<div class="col-md-4">
    <div class="panel panel-primary col-xs-12" data-toggle="modal" data-target="#ngoPartnerModal">
        <div class="panel-body">
            Zostań oficjalnym partnerem mojegoPaństwa
        </div>
    </div>
    <?php echo $this->element('Ngo.ngo_partner_modal') ?>
</div>
*/ ?>
