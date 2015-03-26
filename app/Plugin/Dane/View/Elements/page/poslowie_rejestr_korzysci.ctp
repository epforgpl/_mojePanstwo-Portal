<div class="avatar col-md-10">
    <div class="col-md-1">
        <div class="row">
            <img
                src="http://resources.sejmometr.pl/mowcy/a/2/<?php echo $object->getData('ludzie_poslowie.mowca_id') ?>.jpg"/>
        </div>
    </div>
    <div class="col-md-11">
        <p class="header">
            <a href="/dane/poslowie/<?php echo $object->getData('poslowie.id'); ?>"><?php echo $object->getData('poslowie.nazwa'); ?></a>
        </p>

        <p>(<?php echo $object->getData('sejm_kluby.skrot'); ?>)</p>
    </div>
</div>