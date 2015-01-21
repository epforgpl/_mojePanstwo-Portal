<div class="appHeader">
    <div class="container innerContent">

        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'nowe'
            )); ?>
        </div>

    </div>
</div>

<div class="_container">
    <? echo $this->Element('Pisma.editor'); ?>
</div>