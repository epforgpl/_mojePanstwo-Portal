<div class="row">
    <div class="attachment col-md-1">
        <a href="<?php echo $this->Html->url(array(
            'plugin' => 'Dane',
            'controller' => $item['dataset'],
            'action' => 'view',
            'id' => $item['object_id']
        )); ?>">
                <img
                    src="http://resources.sejmometr.pl/mowcy/a/2/<?php echo $item['data']['id'] ?>.jpg"
                    alt="<?php echo $item['data']['nazwa'] ?>" onerror="imgFixer(this)"/>
        </a>
    </div>
    <div class="content col-md-11">
        <p class="title">
            <a href="<?php echo $this->Html->url(array(
                'plugin' => 'Dane',
                'controller' => $item['dataset'],
                'action' => 'view',
                'id' => $item['object_id']
            )); ?>"
               title="<?php echo $item['data']['nazwa'] ?>"><?php echo $item['data']['nazwa'] ?></a>
        </p>
    </div>
</div>