<?
	$this->Combinator->add_libs('css', $this->Less->css('prawo', array('plugin' => 'Prawo')));

	$news = @$dataBrowser['aggs']['news']['top']['hits']['hits'];
	$kodeksy = @$dataBrowser['aggs']['kodeksy']['top']['hits']['hits'];
	$konstytucja = @$dataBrowser['aggs']['konstytucja']['top']['hits']['hits'];
?>

<div class="col-xs-12 col-md-3 col-sm-3 dataAggsContainer">
	<div class="mp-sticky mp-sticky-disable-sm-3" data-widthFromWrapper="false">
	    <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
	</div>
</div>

<div id="bdl_div" class="col-xs-12 col-md-9 col-sm-9">

	<div class="dataWrap">

		<div class="appBanner bottom-border">
			<h1 class="appTitle">Prawo</h1>
			<p class="appSubtitle">Przeglądaj teksty aktów prawnych</p>
		</div>
		
		
		<div class="block block-simple col-sm-12">
            <header class="nopadding">Aktualności:</header>
            <section class="content margin-top-10">
                
                <div class="agg agg-Dataobjects">
                    <ul class="dataobjects">
                        <? foreach ($news as $doc) { ?>
                            <li class="margin-top-10">
                                <?
                                echo $this->Dataobject->render($doc, 'default');
                                ?>
                            </li>
                        <? } ?>
                    </ul>
                    <div class="buttons text-center margin-top-10">
                        <a href="/prawo/aktualnosci" class="btn btn-primary btn-xs">Więcej aktualności &raquo;</a>
                    </div>
                </div>
                
            </section>
        </div>
        
        <? if( $konstytucja ) {?>
        <div class="block block-simple col-sm-12 konstytucja">
            <header class="nopadding">Konstytucja:</header>
            <section class="content margin-top-10">
                
                <div class="agg agg-Dataobjects">
                    <ul class="dataobjects">
                        <? foreach ($konstytucja as $doc) { ?>
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
        
        <? if( $kodeksy ) {?>
        <div class="block block-simple col-sm-12 kodeksy">
            <header class="nopadding">Kodeksy:</header>
            <section class="content margin-top-10">
                
                <div class="agg agg-Dataobjects">
                    <ul class="dataobjects">
                        <? foreach ($kodeksy as $doc) { ?>
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