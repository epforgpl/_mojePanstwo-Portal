<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>

<div class="appHeader">
    <div class="container innerContent">

        <div class="col-xs-12">
            <? echo $this->Element('Pisma.menu', array(
                'selected' => 'moje'
            )); ?>
        </div>

    </div>
</div>

<div id="stepper" class="container">
    <div class="col-md-12">
        <h1><?= $pismo['nazwa'] ?></h1>
    </div>
    <div class="col-md-10 view">
        <? echo $this->Element('Pisma.render'); ?>
    </div>
    <div class="col-md-2">
        <div class="editor-tooltip">

            <? $href_base = '/pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>

            <ul class="form-buttons">
                <li class="inner-addon">
                    <i class="glyphicon glyphicon-send"></i>
                    <a href="<?= $href_base . '/send' ?>" target="_self" class="btn btn-primary">Wyślij</a>
                </li>
                <li class="inner-addon">
                    <i class="glyphicon glyphicon-print"></i>
                    <a href="<?= $href_base . '/print' ?>" target="_self" class="btn btn-primary">Wydrukuj</a>
                </li>
                <li class="inner-addon">
                    <i class="glyphicon glyphicon-download-alt"></i>
                    <a href="<?= $href_base . '/edit' ?>" target="_self" class="btn btn-primary">Edytuj</a>
                </li>
            </ul>
        </div>
    </div>
</div>