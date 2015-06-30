<?php $this->Combinator->add_libs('css', $this->Less->css('view-bdl-wskazniki', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-map'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-highmap'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki'); ?>

<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>
<?= $this->Element('bdl_select', array(
    'expand_dimension' => $expand_dimension,
    'dims' => $dims,
    'redirect' => true
)); ?>

    <div id="bdl-wskazniki">
        <?
	    
	    debug($this->request->params['subid']);
	    debug($expanded_dimension); 
	       
        if (!empty($expanded_dimension)) {

            foreach ($expanded_dimension['options'] as $_option) {
                if ($this->request->params['subid'] == $_option['data']['id']) {
                    $option = $_option;
                    break;
                }
            }

            if ($option) {

                ?>

                <div class="wskaznik bdl-single" data-dim_id="<?= $option['data']['id'] ?>">
                    <h2>
                        <a href="<?= $this->here ?>/<?= $option['data']['id'] ?>">
                            <?= $option['value'] ?>
                        </a>
                    </h2>

                    <div class="stats">
                        <div class="charts">
                            <div class="head">
                                <p class="vp">
                                    <span class="v"><?= number_format($option['data']['lv'], 2, ',', ' ') ?></span>
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
                <div class="row bdl-details">
                    <div class="col-md-7">
                        <div id="highmap"></div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">

                            <!--<div class="menu col-md-3">
                                <ul class="nav nav-pills nav-stacked">
                                    <? foreach ($dimension['levels'] as $level) { ?>
                                        <li<? if (isset($level['selected'])) {
                                $menuSelect = $level['id']; ?> class="active" <? } ?>>
                                            <a href="/dane/bdl_wskazniki/<?= $object->getId() . '/' /*DS zawierało '\' zamiast '/' */ . $option['data']['id'] . '/' . $level['id'] ?>">
                                                <?= $level["label"] ?>
                                            </a>
                                        </li>
                                    <? } ?>
                                </ul>
                            </div>-->
                            <div class="content col-md-12">
                                <? if (isset($local_data)) { ?>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="input-group localDataSearch">
                                                <span class="input-group-addon" data-icon="&#xe600;"></span>
                                                <input type="text" class="form-control"
                                                       placeholder="<?php switch ($menuSelect) {
                                                           case 'wojewodztwa':
                                                               echo __d('dane', 'LC_BDL_WSKAZNIKI_SEARCH_PLACEHOLDER_WOJEWODZTWA');
                                                               break;
                                                           case 'powiaty':
                                                               echo __d('dane', 'LC_BDL_WSKAZNIKI_SEARCH_PLACEHOLDER_POWIAT');
                                                               break;
                                                           case 'gminy':
                                                               echo __d('dane', 'LC_BDL_WSKAZNIKI_SEARCH_PLACEHOLDER_GMINY');
                                                               break;
                                                           default:
                                                               echo __d('dane', 'LC_BDL_WSKAZNIKI_SEARCH_PLACEHOLDER');
                                                               break;
                                                       } ?>"
                                                       autocomplete="off"/>
                                                <button class="close"
                                                        type="button" data-icon="&#xe605;"></button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="nav nav-pills">
                                                <li role="presentation" class="dropdown bdl-levels-menu pull-right">
                                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"
                                                       role="button" aria-expanded="false">
                                                        Obszar <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <? foreach ($dimension['levels'] as $level) { ?>
                                                            <? if (!isset($level['selected'])) { ?>
                                                                <li>
                                                                    <a href="/dane/bdl_wskazniki/<?= $object->getId() . ',' . $this->request->params['slug'] . '/kombinacje/' . $option['data']['id'] . '/' . $level['id'] ?>">
                                                                        <?= $level["label"] ?>
                                                                    </a>
                                                                </li>
                                                            <? } else { ?>
                                                                <li class="disable">
                                                                    <a>
                                                                        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                                        &nbsp;<?= $level["label"] ?>
                                                                    </a>
                                                                </li>
                                                            <? } ?>
                                                        <? } ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <table class="localDataTable table table-striped">
                                        <thead>
                                        <tr>
                                            <th>
                                <span class="ay-sort sortString"
                                      data-ay-sort-index="0"><?= __d('dane', 'LC_BDL_WSKAZNIKI_NAZWA') ?>
                                            </th>
                                            <th>
                            <span class="ay-sort sortNumber"
                                  data-ay-sort-index="1"><?= __d('dane', 'LC_BDL_WSKAZNIKI_WARTOSC') ?></span>
                                                /
                            <span class="ay-sort sortNumber"
                                  data-ay-sort-index="2"><?= __d('dane', 'LC_BDL_WSKAZNIKI_ROK') ?></span>
                                            </th>
                                            <? /*
                            <th>
                                <span class="ay-sort sortNumber" data-ay-sort-index="3  "><?= __d('dane','LC_BDL_WSKAZNIKI_PRZYROST') ?></span>
                                /
                                <span class="ay-sort sortNumber" data-ay-sort-index="4"><?= __d('dane','LC_BDL_WSKAZNIKI_ROK') ?></span>
                            </th>
                            */
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <? foreach ($local_data as $local) { ?>
                                            <tr class="wskaznikStatic" data-dim_id="<?= $option['data']['id'] ?>"
                                                data-local_type="<?= $menuSelect ?>"
                                                data-local_id="<?= $local["local_id"] ?>">
                                                <td>
                                                    <div class="holder">
                                                        <a class="sortOption"
                                                           href="#<?= $local['local_id'] ?>"><?= $local['local_name'] ?></a>

                                                        <div class="wskaznikChart">
                                                            <div class="progress progress-striped active">
                                                                <div class="progress-bar" role="progressbar"
                                                                     aria-valuenow="45"
                                                                     aria-valuemin="0" aria-valuemax="100"
                                                                     style="width: 15%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                <span class="sortOption"
                                      data-ay-sort-weight="<?= $local['lv'] ?>">
                                    <?= number_format($local['lv'], 2, ',', ' ') ?>
                                    <?= $option['data']['jednostka'] ?>
                                </span>
                                <span class="sortOption"
                                      data-ay-sort-weight="<?= $local['ly'] ?>"><?= __d('dane', 'LC_BDL_WSKAZNIKI_LASTYEAR', array($local['ly'])) ?></span>
                                                </td>
                                                <? /*
                            <td>
                                <span class="sortOption factor <? if (intval($local['dv']) < 0) {echo "d";} else {echo "u";} ?>" data-ay-sort-weight="<?= $local['dv'] ?>"><?= $local['dv'] ?> %</span>
                                <span class="sortOption" data-ay-sort-weight="<?= $local['ply'] ?>"><?= __d('dane', 'LC_BDL_WSKAZNIKI_PREVLASTYEAR', array($local['ply'])) ?></span>
                            </td>
                            */
                                                ?>
                                            </tr>
                                        <? } ?>
                                        </tbody>
                                    </table>
                                <? } ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?
            }
        }
        ?>

    </div>

<? if (isset($local_data) && is_array($local_data)): ?>
    <script type="text/javascript">var local_data = <?= json_encode($local_data); ?>;
        var unitStr = '<?= $option['data']['jednostka'] ?>';</script>
<? endif; ?>

<?= $this->Element('dataobject/pageEnd'); ?>