<div class="objectRender col-md-12 <?php echo $object->getDataset() ?>" oid="<?php echo $item['data']['id'] ?>">
    <div class="row">

        <div class="content col-md-12">

            <? echo $this->element('Dane.dataobjectSlider/_content', array(
                'object' => $object,
                'options' => $options,
            )); ?>


            <? /*
            <? if ($object->getData('wartosc_kapital_zakladowy')) { ?>
                <ul class="dataHighlights inl">
                    <li class="dataHighlight showLabels">
                        <p class="_label">Kapitał zakład.</p>

                        <div>
                            <p class="_value"><?= number_format_h($object->getData('wartosc_kapital_zakladowy')) ?>
                                PLN</p>
                        </div>
                    </li>
                </ul>
            <? } ?>
            */
            ?>

        </div>

    </div>
</div>