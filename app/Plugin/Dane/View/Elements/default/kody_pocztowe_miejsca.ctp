<div class="row">
    <div class="content col-md-12">
        <p class="header">
            <?php echo __d('dane', 'LC_DANE_KODY_POCZTOWE_MIEJSCA_ZIP', true); ?>
        </p>

        <p class="title">
            <a href="<?php echo $this->Html->url(array(
                'plugin' => 'Dane',
                'controller' => $item['dataset'],
                'action' => 'view',
                'id' => $item['object_id']
            )); ?>"
               title="<?php echo $item['data']['kod'] ?>"><?php echo $item['data']['kod'] ?></a>
        </p>

        <p class="line signature"><?php echo __d('dane', 'LC_DANE_KODY_POCZTOWE_MIEJSCA_VOIVODESHIP', true) . ': <strong>' . $item['data']['wojewodztwo'] . '</strong>'; ?></p>

        <p class="line signature"><?php echo __d('dane', 'LC_DANE_KODY_POCZTOWE_MIEJSCA_TOWNS', true) . ': <strong>' . $item['data']['miejscowosc'] . '</strong>'; ?></p>
    </div>
</div>