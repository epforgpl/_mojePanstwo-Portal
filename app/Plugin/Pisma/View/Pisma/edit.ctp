<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<div class="appHeader">
    <div class="container innerContent">

        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'moje'
            )); ?>
        </div>

    </div>
</div>
<? echo $this->Element('Pisma.editor', array('title' => $pismo['tytul'])); ?>

