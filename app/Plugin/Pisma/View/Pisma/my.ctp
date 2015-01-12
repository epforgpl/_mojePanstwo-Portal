<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>

<div class="appHeader">
    <div class="container innerContent">

        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'moje'
            )); ?>
        </div>

    </div>
</div>

<div class="container">

    <ul>
        <? foreach ($search['items'] as $item) { ?>

            <li>
                <a href="/pisma/<?= $item['alphaid'] ?>,<?= $item['slug'] ?>"><?= $item['name'] ?></a>
                (<?= $item['created_at'] ?>)
            </li>

        <? } ?>
    </ul>

</div>