<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy-dyzury', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('js', 'Dane.view-gminy-dyzury');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'bigTitle' => true,
    )
));

$dyzury_data = $radny->getLayer('dyzury');
?>
	
	
    <script type="text/javascript" src="http://js.addthisevent.com/atemay.js"></script>
    <div class="col-md-10 col-md-offset-1">
        
        <h1 class="light"><a href="<?= $radny->getUrl() ?>"
                                     class="btn-back glyphicon glyphicon-circle-arrow-left"></a> Dyżury radnego</h1>
        
        <div id="dyzury" class="object">

            <div class="block-group">

                <? if ($dyzury = $dyzury_data['future']) { ?>
                    <div id="future" class="block">


                        <div class="content">
                            <ul>
                                <? foreach ($dyzury as $d) { ?>
                                    <li style="margin: 15px 0;">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <b><?= $this->Czas->dataSlownie($d['data']) ?></b>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $d['godz_str'] ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?= $d['adres'] ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?= $d['adres_wiecej'] ?>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="http://example.com/link-to-your-event"
                                                   title="Dodaj do kalendarza" class="addthisevent">
                                                    Dodaj do kalendarza
                                                    <span class="_start"><?= $d['timestart'] ?></span>
                                                    <span class="_end"><?= $d['timestop'] ?></span>
                                                    <span class="_zonecode">41</span>
                                                    <span
                                                        class="_summary">Dyżur poselski <?= $radny->getData('nazwa') ?></span>
                                                    <span class="_description"><?= $d['godz_str'] ?>
                                                        , <?= $d['adres'] ?></span>
                                                    <span class="_location"><?= $d['adres_wiecej'] ?></span>
                                                    <span class="_organizer"><?= $radny->getData('nazwa') ?></span>
                                                    <span
                                                        class="_organizer_email"><?= $radny->getData('email') ?></span>
                                                    <span class="_all_day_event">false</span>
									    <span class="_date_format"><?
                                            $parts = explode('-', $d['data']);
                                            echo $parts[2] . '/' . $parts[1] . '/' . $parts[0];
                                            ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                    </div>
                <? } ?>

                <? if ($dyzury = $dyzury_data['past']) { ?>
                    <div id="past" class="block">


                        <div id="archive" class="content" style="display: none;">
                            <ul>
                                <? foreach ($dyzury as $d) { ?>
                                    <li style="margin: 15px 0;">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <b><?= $this->Czas->dataSlownie($d['data']) ?></b>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $d['godz_str'] ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?= $d['adres'] ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?= $d['adres_wiecej'] ?>
                                            </div>
                                        </div>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>

                        <br/>

                        <div id="archive_btn_div" class="text-center">
                            <button class="btn btn-default" id="archive_btn">Pokaż archiwum &darr;</button>
                        </div>

                    </div>
                <? } ?>

            </div>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
?>