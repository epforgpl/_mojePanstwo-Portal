<?php
$this->Combinator->add_libs('css', $this->Less->css('kody_pocztowe', array('plugin' => 'KodyPocztowe')));
$this->Combinator->add_libs('js', 'KodyPocztowe.kody.js');
?>

<div class="container">
    <h1>
        <?php echo $city; ?>
    </h1>
    <table class="table table-stripped">
        <tr>
            <th><?php echo __d('kody_pocztowe', 'LC_KODY_POCZTOWE_NAZWA'); ?></th>
            <th></th>
        </tr>
        <?php foreach ($cities as $city) { ?>
            <tr>
                <td><?php debug($city); ?></td>
                <td></td>
            </tr>
        <?php } ?>
    </table>
</div>