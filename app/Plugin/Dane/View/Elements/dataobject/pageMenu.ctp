<div class="objectMenu <?= $menuMode ?>">
    <?php if ($menuMode == 'horizontal') { ?>
    <div class="container"><?php } ?>
        <ul class="nav nav-pills nav-stacked row">
            <?php foreach ($menu as $item) { ?>
                <li class="<?php echo $item['id'];
                echo (isset($item['selected']) && $item['selected']) ? ' active' : null;
                echo (isset($item['icon']) && $item['icon']) ? ' icon' : null; ?>">
                    <a href="<?php echo $this->Html->url(array(
                        'plugin' => 'Dane',
                        'controller' => $object->getDataset(),
                        'id' => $object->getData('id'),
                        'action' => $item['id']
                    )); ?>">
                        <?php echo __d('dane', $item['label']); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <?php if ($menuMode == 'horizontal') { ?></div><?php } ?>
</div>