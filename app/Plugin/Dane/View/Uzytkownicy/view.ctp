<?
echo $this->Element('dataobject/pageBegin');
?>

    <div class="row margin-top-20">
        <div class="col-xs-12 col-sm-9">

            <? if( $pisma = @$object_aggs['pisma']['top']['hits']['hits'] ) { ?>
                <div class="block block-simple col-xs-12">
                    <header>Pisma:</header>
                    <section class="content margin-sides-10">

                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects">
                                <? foreach ($pisma as $doc) { ?>
                                    <li class="margin-top-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                    </section>
                </div>
            <? } ?>

            <? if( $kolekcje = @$object_aggs['kolekcje']['top']['hits']['hits'] ) { ?>
                <div class="block block-simple col-xs-12">
                    <header>Kolekcje:</header>
                    <section class="content margin-sides-10">

                        <div class="agg agg-Dataobjects">
                            <ul class="dataobjects">
                                <? foreach ($kolekcje as $doc) { ?>
                                    <li class="margin-top-10">
                                        <?
                                        echo $this->Dataobject->render($doc, 'default');
                                        ?>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                    </section>
                </div>
            <? } ?>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
