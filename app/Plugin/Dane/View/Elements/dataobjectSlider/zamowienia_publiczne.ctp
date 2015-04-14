<div class="objectRender col-md-12 <?php echo $object->getDataset() ?>" oid="<?php echo $object->getId() ?>">
    <div class="row">

        <div class="content col-md-12">

            <? echo $this->element('Dane.dataobjectSlider/_content', array(
                'object' => $object,
                'options' => $options,
            )); ?>


            <ul class="dataHighlights inl">

                <? if ($object->getData('zamawiajacy_nazwa')) { ?>
                    <li class="dataHighlight showLabels">
                        <p class="_label">Zamawiający:</p>

                        <div>
                            <p class="_value"><?= $this->Text->truncate($object->getData('zamawiajacy_nazwa'), 40) ?></p>
                        </div>
                    </li>
                <? } ?>

                <? if ($object->getData('wartosc_cena')) { ?>
                    <li class="dataHighlight showLabels">
                        <p class="_label">Wartość:</p>

                        <div>
                            <p class="_value"><?= number_format_h($object->getData('wartosc_cena')) ?> PLN</p>
                        </div>
                    </li>
                <? } ?>
            </ul>

        </div>

    </div>
</div>