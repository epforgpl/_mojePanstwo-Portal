<div class="block">
    <div class="block-header">
        <h2 class="pull-left label">Ostatnie twitty</h2>
        <a class="btn btn-default btn-sm pull-right"
           href="/dane/twitter_accounts/<?= $object->getId() ?>">Zobacz wszystkie</a>
    </div>
    <div class="content">
        <div class="dataobjectsSliderRow row">
            <div>
                <?php echo $this->DataobjectsSlider->render($twitts, array(
                    'perGroup' => 3,
                    'rowNumber' => 1,
                    'labelMode' => 'none',
                    'file' => 'twitter_min',
                )) ?>
            </div>
        </div>
    </div>
</div>

<div class="block">
    <div class="block-header">
        <h2 class="pull-left label">Liczba obserwujących</h2>
    </div>
    <div class="content followers"
         data-json='<?php echo json_encode($object->getLayer('followers_chart')) ?>'>
    </div>
</div>