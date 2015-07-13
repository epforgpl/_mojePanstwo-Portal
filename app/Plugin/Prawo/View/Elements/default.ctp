<div class="objectRender <?php echo $file ?>" oid="<?php echo $item['data']['id'] ?>">
    <div class="row">
        <div class="formatDate col-lg-1">
            <?php echo($this->Dataobject->getDate()); ?>
        </div>
        <div class="data col-lg-11">
            <?php echo $this->element($theme . '/' . $file, array('item' => $item)); ?>
        </div>
    </div>
</div>