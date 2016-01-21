<?
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-dyzury', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-gminy-dyzury');

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $radny,
    'objectOptions' => array(
        'hlFields' => array('komitet', 'liczba_glosow', 'procent_glosow_w_okregu'),
        'bigTitle' => true,
    )
));

?>


    <div class="col-md-10 col-md-offset-1">
        <div id="komisje" class="object">


            <? if ($komisje = $radny->getLayer('komisje')) { ?>

                <h1 class="light"><a href="<?= $radny->getUrl() ?>"
                                     class="btn-back glyphicon glyphicon-circle-arrow-left"></a> Komisje, w których
                    zasiada radny</h1>

                <div class="block sklad padding">
                    <ul class="list-group list-dataobjects">

                        <? foreach ($komisje as $komisja) { ?>

                            <div class="objectRender readed">

                                <div class="row">
                                    <div class="data col-md-12">
                                        <div class="row">

                                            <div class="content">
                                                <p class="title">
                                                    <a title="Komisja Budżetowa"
                                                       href="/dane/gminy/903/komisje/<?= $komisja['id'] ?>"><?= $komisja['nazwa'] ?></a>
                                                    <span
                                                        class="label label-<?= $komisja['label'] ?>"><?= $komisja['stanowisko'] ?></span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        <? } ?>

                    </ul>
                </div>


            <? } ?>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
?>
