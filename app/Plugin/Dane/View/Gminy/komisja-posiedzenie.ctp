<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.dataobjects-ajax');
$this->Combinator->add_libs('js', 'Dane.filters');

if ($object->getId() == '903') $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => false,
    'object' => $posiedzenie,
    'objectOptions' => array(
        'bigTitle' => true,
        'hlFields' => array('krakow_komisje.nazwa'),
        'thumbWidth' => 2,
    ),
));


if( isset($wybrany_dokument) ) {
?>

	<div class="margin-sides-20">
		<div class="row">
			<div class="block block-simple col-xs-12">
			    <header><h1><?= $wybrany_dokument['fields']['source'][0]['data']['krakow_komisje_dokumenty.title'] ?></h1></header>
			    <section class="content">

				    <div class="row">
					    <div class="col-xs-9">
						    <? echo $this->Document->place($wybrany_dokument['fields']['source'][0]['data']['krakow_komisje_dokumenty.dokument_id']); ?>
					    </div>
					    <div class="col-xs-3">
						    <p><a href="<?= $posiedzenie->getUrl() ?>">Zobacz wszystkie dokumenty z posiedzenia &raquo;</a></p>
						    <? foreach( $wybrany_dokument['fields']['source'][0]['data']['krakow_komisje_dokumenty.druk_id'] as $druk_id ) {?>
						    <p class="margin-top-20"><a href="/dane/gminy/903,krakow/druki/<?= $druk_id ?>">Zobacz więcej informacji na temat rozpatrywanego projektu &raquo;</a></p>
						    <? } ?>
					    </div>
				    </div>

			    </section>
			</div>
		</div>
	</div>

    <?
} else {

	if ($posiedzenie->getData('yt_video_id') && $punkty) {

        $this->Combinator->add_libs('css', $this->Less->css('view-dzielnica_posiedzenie', array('plugin' => 'Dane')));
	    $this->Combinator->add_libs('js', 'Dane.view-dzielnica_posiedzenie');
	    ?>


        <div id="ytVideoCont" class="row">
	        <div class="<? if ($punkty) { ?>col-md-7 text-right<? } else { ?>col-md-9 col-md-offset-3<? } ?>">
	            <div id="ytVideo" class="row">
	                <div id="player" data-youtube="<?php echo $posiedzenie->getData('yt_video_id'); ?>"></div>
	            </div>
	        </div>

            <? if ($punkty) { ?>
	            <div class="col-md-5 wystapienia">

                    <div class="block">

                        <div class="block-header">
	                        <h2 class="label">Punkty</h2>
	                    </div>

                        <div class="content nopadding">
	                        <ul class="nav nav-pills nav-stacked">
	                            <?php foreach ($punkty as $id => $punkt) { ?>
	                                <li>
	                                    <a data-video-position="<?php echo $punkt['video_start']; ?>"
	                                       href="#<?php echo $punkt['id']; ?>">
	                                        <!--<span><?php echo (date('H', $punkt['video_start']) - 1) . date(':i:s', $punkt['video_start']); ?></span>--><?php echo $punkt['mowca_str']; ?>
	                                    </a>
	                                </li>
	                            <?php } ?>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	        <? } ?>

        </div>
	<?
	}


    if( isset($dokumenty) ) { ?>
		<div class="margin-sides-20">
			<div class="row">

                <? foreach( $dokumenty as $dokument ) { ?>
				<div class="block block-simple col-xs-9">
				    <header><?= $dokument['key'] ?></header>
				    <section class="content">

                        <ul class="dataobjects">
		                    <? foreach( $dokument['top']['hits']['hits'] as $doc ) { ?>
		                        <li class="margin-top-10">
		                            <?
		                            echo $this->Dataobject->render($doc, 'default');
		                            ?>
		                        </li>
		                    <? } ?>
		                </ul>

                    </section>
				</div>
				<? } ?>

            </div>
		</div>
        <?
	}
}

echo $this->Element('dataobject/pageEnd');
