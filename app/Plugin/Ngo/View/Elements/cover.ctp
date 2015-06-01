<?php $this->Combinator->add_libs('css', $this->Less->css('ngo', array('plugin' => 'Ngo'))) ?>

<div class="col-md-8">
		
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
    </div>
		
</div><div class="col-md-4">
    <div class="panel panel-primary col-xs-12" data-toggle="modal" data-target="#ngoPartnerModal">
        <div class="panel-body">
            Zostań oficjalnym partnerem mojegoPaństwa
        </div>
    </div>
    <?php echo $this->element('Ngo.ngo_partner_modal') ?>
</div>