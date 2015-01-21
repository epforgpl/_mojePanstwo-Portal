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

<div class="container">
    <div class="col-md-12">
        <h1><?= $pismo['nazwa'] ?></h1>

        <div class="letter-meta">
            <p>Autor: Daniel Macyszyn</p>
        </div>
    </div>
    <div id="stepper">
        <div class="col-md-10 view">

            <? echo $this->Element('Pisma.render'); ?>
        </div>
        <div class="col-md-2 nopadding">
            <div class="editor-tooltip">

                <? $href_base = '/pisma/' . $pismo['alphaid'] . ',' . $pismo['slug']; ?>


                <ul class="form-buttons">
                    <li class="inner-addon">
                        <i class="glyphicon glyphicon-send"></i>
                        <a href="<?= $href_base . '/send' ?>" target="_self" class="btn btn-primary">Wyślij...</a>

                        <p class="desc">Możesz wysłać pismo do adresata poprzez e-mail.</p>
                    </li>
                    <li class="inner-addon">
                        <i class="glyphicon glyphicon-print"></i>
                        <a href="<?= $href_base . '/print' ?>" target="_self" class="btn btn-primary">Udostępnij...</a>

                        <p class="desc">Twoje pismo jest obecnie prywatne. Możesz je zanonimizować i udostępnić
                            publicznie.</p>
                    </li>
                    <li class="inner-addon">
                        <i class="glyphicon glyphicon-print"></i>
                        <a href="<?= $href_base . '/print' ?>" target="_self" class="btn btn-primary">Edytuj
                            treść...</a>
                    </li>

                    <? /*
                <p class="text-center"><a href="#">Więcej akcji</a></p>
                */ ?>

                </ul>

            </div>
        </div>
    </div>
</div>