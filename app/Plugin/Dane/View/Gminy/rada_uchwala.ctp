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
$druki = @$uchwala->getLayer('druki');

?>
    <div class="prawo margin-sides-10">


        <div class="row">

            <div class="col-md-9">
				<div class="margin-top-20">
	                <?= $this->Document->place($file, array('toolbar' => false)) ?>
				</div>
            </div>

            <div class="col-md-3">

                <?if (@$druki[0]) {
                    ?>
                    <p class="margin-sides-5 margin-top-20">
                        <a href="/dane/gminy/903,krakow/druki/<?= $druki[0] ?>"><span
                                class="glyphicon glyphicon-link"></span> Zobacz proces legislacyjny</a>
                    </p>
                <?
                } ?>


                <? if (count($docs) > 1) { ?>
                    <p class="margin-top-20">Pliki powiązane:</p>

                    <ul class="nav nav-pills nav-stacked">
                        <?php foreach ($docs as $i => $doc_id) { ?>
                            <? $dokument_id = ($file == $doc_id) ? $doc_id : false; ?>
                            <li role="presentation" <?= ($file == $doc_id) ? 'class="active"' : ''; ?>>
                                <a href="<?= $uchwala->getUrl() ?>?file=<?= $doc_id ?>">
                                    Plik #<?= ($i + 1) ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                <? } ?>

                <p class="margin-sides-5 margin-top-20"><a
                        href="http://www.bip.krakow.pl/?dok_id=167&sub_dok_id=167&sub=uchwala&query=id=<?= $uchwala->getData('sid') ?>&typ=u"
                        target="_blank"><span class="glyphicon glyphicon-share"></span> Źródło</a></p>
            </div>


        </div>


    </div>
<?
echo $this->Element('dataobject/pageEnd');
