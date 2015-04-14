<?
echo $this->Element('dataobject/pageBegin');
?>


    <div class="patenty row">
        <div class="col-md-2 objectSide">
            <div class="objectSideInner">
                <ul class="dataHighlights side">

                    <? if ($object->getData('uprawniony')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Uprawniony</p>

                            <p class="_value"><?= $object->getData('uprawniony'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('tworcy')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Twórcy</p>

                            <p class="_value"><?= $object->getData('tworcy'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('pierwszenstwo')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Pierwszeństwo</p>

                            <p class="_value"><?= $object->getData('pierwszenstwo'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('pelnomocnik')) { ?>
                        <li class="dataHighlight">
                            <p class="_label">Pełnomocnik</p>

                            <p class="_value"><?= $object->getData('pelnomocnik'); ?></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('espacenet_url')) { ?>
                        <li class="dataHighlight">

                            <p class="_value"><a itemprop="sameAs" target="_blank" class="btn btn-default btn-sm"
                                                 href="<?= $object->getData('espacenet_url'); ?>">Zobacz w
                                    espacenet.com</a></p>
                        </li>
                    <? } ?>

                    <? if ($object->getData('register_url')) { ?>
                        <li class="dataHighlight">

                            <p class="_value"><a target="_blank" class="btn btn-default btn-sm"
                                                 href="<?= $object->getData('register_url'); ?>">Zobacz w
                                    regserv.uprp.pl/</a></p>
                        </li>
                    <? } ?>


                </ul>

            </div>
        </div>


        <div class="col-md-10 objectMain">

            <?= $this->Document->place($object->getData('dokument_id')) ?>

        </div>
    </div>


<?= $this->Element('dataobject/pageEnd'); ?>