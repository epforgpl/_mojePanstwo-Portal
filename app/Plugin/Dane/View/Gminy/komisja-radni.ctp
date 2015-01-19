<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'menu' => isset($_submenu) ? $_submenu : false,
    'object' => $komisja,
    'objectOptions' => array(
        'hlFields' => array(),
        'bigTitle' => true,
    )
));

?>

    <div class="col-md-12">
        <div class="sklad object mpanel" style="margin-bottom: 20px;">

            <div class="innerContainer update-objects" style="">

                <? if ($sklad = $komisja->getLayer('sklad')) { ?>

                    <ul class="list-group list-dataobjects">

                        <? foreach ($sklad as $radny) { ?>

                            <div class="objectRender readed">

                                <div class="row">
                                    <div class="data col-md-12">
                                        <div class="row">

                                            <div class="content">
                                                <p class="title">
                                                    <a title="Komisja Budżetowa"
                                                       href="/dane/gminy/903/radni/<?= $radny['id'] ?>"><?= $radny['nazwa'] ?></a>
                                                    <span
                                                        class="label label-<?= $radny['label'] ?>"><?= $radny['stanowisko'] ?></span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <? } ?>
                    </ul>

                <? } ?>

            </div>

        </div>
    </div>

<? echo $this->Element('dataobject/pageEnd');