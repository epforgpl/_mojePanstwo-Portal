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
    'object' => $uchwala,
    'objectOptions' => array(
        'bigTitle' => true,
        'truncate' => 1024,
    )
));

$docs = $uchwala->getLayer('docs');

?>
    <div class="prawo row">

        <? if(count($docs) > 1) { ?>

            <div class="row">

                <div class="col-md-2">

                    <h4>Pliki powiązane</h4>

                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach($docs as $i => $doc_id) { ?>
                            <? $dokument_id = ($file == $doc_id) ? $doc_id : false; ?>
                            <li role="presentation" <?= ($file == $doc_id) ? 'class="active"' : ''; ?>>
                                <a href="<?= $uchwala->getUrl() ?>?file=<?= $doc_id ?>">
                                    Plik #<?= ($i + 1) ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </div>

                <div class="col-md-10">
                    <?= $this->Document->place(
                        isset($dokument_id) && $dokument_id ?
                            $dokument_id : $uchwala->getData('dokument_id')
                    ) ?>
                </div>

            </div>

        <? } else { ?>

            <div class="col-md-12">
                <div class="object">
                    <?= $this->Document->place($uchwala->getData('dokument_id')) ?>
                </div>
            </div>

        <? } ?>


    </div>
<?
echo $this->Element('dataobject/pageEnd');
