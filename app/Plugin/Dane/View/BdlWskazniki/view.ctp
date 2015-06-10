<?php $this->Combinator->add_libs('css', $this->Less->css('view-bdl-wskazniki', array('plugin' => 'Dane'))); ?>

<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki'); ?>

<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>
<?= $this->Element('bdl_select', array('expand_dimension' => $expand_dimension, 'dims' => $dims)); ?>

    <div id="bdl-wskazniki">
        <div class="object">

            <?
            if (!empty($expanded_dimension)) {
                foreach ($expanded_dimension['options'] as $option) {
                    if (isset($option['data'])) {
                        ?>

                        <div class="wskaznik" data-dim_id="<?= $option['data']['id'] ?>">
                            <h2>
                                <a href="<?= $this->here ?>/kombinacje/<?= $option['data']['id'] ?>"><?= trim($option['value']) ?></a>
                            </h2>

                            <div class="stats">
                                <div class="map call-md-2">
                                    <a href="<?= $this->here ?>/kombinacje/<?= $option['data']['id'] ?>">
                                        <img width="216" height="200"
                                             src="http://resources.sds.tiktalik.com/BDL_wymiary_kombinacje/<?= $option['data']['id'] ?>.png"
                                             class="imageInside" onerror="imgFixer(this)"/>
                                    </a>
                                </div>
                                <div class="charts col-md-9">
                                    <div class="head">
                                        <p class="vp">
                                            <span
                                                class="v"><?= number_format($option['data']['lv'], 2, ',', ' ') ?></span>
                                            <span class="u"><?= $option['data']['jednostka'] ?></span>
                                        <span
                                            class="y"><?= __d('dane', 'LC_BDL_WSKAZNIKI_LASTYEAR', array($option['data']['ly'])) ?></span>
                                        </p>

                                        <p class="fp">
                                            <?php if (isset($option['data']['dv']) && isset($option['data']['ply'])) { ?>
                                                <span class="factor <? if (intval($option['data']['dv']) < 0) {
                                                    echo "d";
                                                } else {
                                                    echo "u";
                                                } ?>">
                                                    <?= $option['data']['dv'] ?> %
                                                </span>
                                                <span class="i">
                                                    <?= __d('dane', 'LC_BDL_WSKAZNIKI_PREVLASTYEAR', array($option['data']['ply'])) ?>
                                                </span>
                                            <?php } ?>
                                        </p>
                                    </div>
                                    <div class="chart">
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="45"
                                                 aria-valuemin="0" aria-valuemax="100" style="width: 15%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                    }
                }
            }
            ?>

        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>