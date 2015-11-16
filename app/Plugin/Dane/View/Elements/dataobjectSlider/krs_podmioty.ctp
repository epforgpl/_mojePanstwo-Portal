<div class="objectRender col-md-12 <?php echo $object->getDataset() ?>" oid="<?php echo $item['data']['id'] ?>">
    <div class="row">
        <div class="content col-md-12">
            <? echo $this->element('Dane.dataobjectSlider/_content', array(
                'object' => $object,
                'options' => $options,
            )); ?>
        </div>
    </div>
</div>
