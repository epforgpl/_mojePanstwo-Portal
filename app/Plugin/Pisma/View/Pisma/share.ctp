<?php $this->Combinator->add_libs('css', $this->Less->css('pisma', array('plugin' => 'Pisma'))) ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma.js') ?>
<?php $this->Combinator->add_libs('js', 'Pisma.pisma-share.js') ?>

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
    <div class="col-md-12">
        <h1><?= $pismo['nazwa'] ?></h1>

        <div class="letter-meta">
            <p>Autor: Daniel Macyszyn</p>
        </div>
    </div>
    <div id="stepper">
        <div class="content clearfix">
            <div class="col-md-10 view share">

                <? echo $this->Element('Pisma.render'); ?>
            </div>
            <div class="col-md-2 nopadding">
                <div class="editor-tooltip">

                    <? $href_base = '/pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>


                    <ul class="form-buttons">
                        <li class="inner-addon">
                            <i class="glyphicon glyphicon-share"></i>
                            <a href="<?= $href_base . '/share' ?>" target="_self"
                               class="btn btn-primary">Udostępnij...</a>

                            <p class="desc">Twoje pismo jest obecnie prywatne. Możesz je zanonimizować i udostępnić
                                publicznie.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>