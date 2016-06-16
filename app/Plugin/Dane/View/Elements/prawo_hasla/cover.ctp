<?
$this->Combinator->add_libs('css', $this->Less->css('zamowienia', array('plugin' => 'ZamowieniaPubliczne')));
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$options = array(
    'mode' => 'init',
);
?>
<div class="row margin-top-10">
<div class="col-md-9">
	
	
    <? if (@$dataBrowser['aggs']['prawo']['ustawy']['top']['hits']['hits']) { ?>
        <div class="block block-simple">
            <header>Ustawy</header>
            <section class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['prawo']['ustawy']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects margin-sides-10">
                                <? foreach ($dataBrowser['aggs']['prawo']['ustawy']['top']['hits']['hits'] as $doc) { ?>
                                    <li class="margin-bottom-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons text-center margin-top-10">
                                <a href="<?= $object->getUrl() ?>/akty?conditions[prawo.typ_id]=1" class="btn btn-primary btn-xs">Więcej
                                    ustaw &raquo;</a>
                            </div>
                        <? } ?>

                    </div>
                </div>
            </section>
        </div>
    <? } ?>

    <? if (@$dataBrowser['aggs']['prawo']['rozporzadzenia']['top']['hits']['hits']) { ?>
        <div class="block block-simple">
            <header>Rozporządzenia</header>
            <section class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['prawo']['rozporzadzenia']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects margin-sides-10">
                                <? foreach ($dataBrowser['aggs']['prawo']['rozporzadzenia']['top']['hits']['hits'] as $doc) { ?>
                                    <li class="margin-bottom-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons text-center margin-top-10">
                                <a href="<?= $object->getUrl() ?>/akty?conditions[prawo.typ_id]=3" class="btn btn-primary btn-xs">Więcej
                                    rozporządzeń &raquo;</a>
                            </div>
                        <? } ?>

                    </div>
                </div>
            </section>
        </div>
    <? } ?>

    <? if (@$dataBrowser['aggs']['prawo']['inne']['top']['hits']['hits']) { ?>
        <div class="block block-simple">
            <header>Pozostałe akty prawne</header>
            <section class="aggs-init">

                <div class="dataAggs">
                    <div class="agg agg-Dataobjects">
                        <? if ($dataBrowser['aggs']['prawo']['inne']['top']['hits']['hits']) { ?>
                            <ul class="dataobjects margin-sides-10">
                                <? foreach ($dataBrowser['aggs']['prawo']['inne']['top']['hits']['hits'] as $doc) { ?>
                                    <li class="margin-bottom-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                            <div class="buttons text-center margin-top-10">
                                <a href="<?= $object->getUrl() ?>/akty" class="btn btn-primary btn-xs">Pozostałe akty prawne &raquo;</a>
                            </div>
                        <? } ?>

                    </div>
                </div>
            </section>
        </div>
    <? } ?>

</div>
</div>
