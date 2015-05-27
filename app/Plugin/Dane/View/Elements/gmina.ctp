<?

$path = App::path('Plugin');
$file = $path[0] . '/Dane/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
$file_exists = file_exists($file);

?>
<div class="objectRender col-md-12 <?php echo $object->getDataset(); ?>" oid="<?php echo $item['data']['id'] ?>">
    <div class="row">
        <? if ($this->Dataobject->getDate()) { ?>
            <div class="formatDate col-md-2">
                <?php echo($this->Dataobject->getDate()); ?>
            </div>
        <? } ?>
        <div class="data col-md-<?= $this->Dataobject->getDate() ? '10' : '12' ?>">
            <div class="row">
                <? if ($object->getThumbnailUrl()) { ?>
                    <div class="attachment col-md-2">
                        <a href="<?= $object->getUrl() ?>">
                            <object data="/error/brak.gif" type="image/png">
                                <img src="<?= $object->getThumbnailUrl() ?>"
                                     alt="<?= strip_tags($object->getTitle()) ?>"/>
                            </object>
                        </a>
                    </div>
                    <div class="content col-md-10">

                        <p class="title">
                            <a href="<?= $object->getUrl() ?>"
                               title="<?= strip_tags($object->getTitle()) ?>"><?= $object->getShortTitle() ?></a>
                        </p>
                        <?
                        if ($file_exists) {
                            echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                                'item' => $item,
                                'object' => $object
                            ));
                        }
                        ?>
                    </div>

                <? } else { ?>
                    <div class="content">

                        <p class="title">
                            <a href="<?= $object->getUrl() ?>"
                               title="<?= strip_tags($object->getTitle()) ?>"><?= $object->getShortTitle() ?></a>
                        </p>
                        <?
                        if ($file_exists) {
                            echo $this->element('Dane.' . $theme . '/' . $object->getDataset(), array(
                                'item' => $item,
                                'object' => $object
                            ));
                        }
                        ?>

                    </div>

                <? } ?>


            </div>

        </div>
    </div>
</div>