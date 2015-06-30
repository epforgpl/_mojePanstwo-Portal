<?php $this->Combinator->add_libs('css', $this->Less->css('view-bdl-wskazniki', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki'); ?>

<div class="wskaznik" data-dim_id="<?= $data['id'] ?>" data-years="<?= htmlspecialchars(json_encode($data['years']), ENT_QUOTES, 'UTF-8') ?>">
    <h2>
        <a href="<?= $url ?>/kombinacje/<?= $data['id'] ?>"><?= trim($title) ?></a>
        <? if (in_array('bdl_opis', $object_editable)) { ?>
            <button class="btn btn-sm btn-primary add_to_item pull-right"><span
                    class="icon glyphicon glyphicon-plus"></span></button>
        <? } ?>
    </h2>
    
    <div class="stats">
        <div class="map call-md-2">
            <a href="<?= $object->getUrl() ?>/kombinacje/<?= $data['id'] ?>">
                <img width="216" height="200"
                     src="http://resources.sds.tiktalik.com/BDL_wymiary_kombinacje/<?= $data['id'] ?>.png"
                     class="imageInside" onerror="imgFixer(this)"/>
            </a>
        </div>
        <div class="charts col-md-9">
            <div class="head">
                <p class="vp">
                    <span
                        class="v"><?= number_format($data['lv'], 2, ',', ' ') ?></span>
                    <span class="u"><?= $data['jednostka'] ?></span>
                <span
                    class="y"><?= __d('dane', 'LC_BDL_WSKAZNIKI_LASTYEAR', array($data['ly'])) ?></span>
                </p>

                <p class="fp">
                    <?php if (isset($data['dv']) && isset($data['ply'])) { ?>
                        <span class="factor <? if (intval($data['dv']) < 0) {
                            echo "d";
                        } else {
                            echo "u";
                        } ?>">
                            <?= $data['dv'] ?> %
                        </span>
                        <span class="i">
                            <?= __d('dane', 'LC_BDL_WSKAZNIKI_PREVLASTYEAR', array($data['ply'])) ?>
                        </span>
                    <?php } ?>
                </p>
            </div>
            <div class="chart">
            </div>
        </div>
    </div>
</div>