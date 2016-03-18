<?php $this->Combinator->add_libs('css', $this->Less->css('view-bdl-wskazniki', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highstock/js/highstock'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highstock/locals'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-map'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki-highmap'); ?>
<?php $this->Combinator->add_libs('js', 'Dane.view-bdl-wskazniki'); ?>

<?= $this->Element('dataobject/pageBegin', array('renderFile' => 'page-bdl_wskazniki')); ?>

<?= $this->Element('bdl_select', array(
    'expand_dimension' => $expand_dimension,
    'dims' => $dims,
    'redirect' => true
)); ?>

    <div id="bdl-wskazniki">
        <div class="object">
            <? if (isset($combination)) {
                echo $this->element('Dane.bdl_wskaznik', array(
                    'data' => $combination,
                    'url' => $object->getUrl(),
                    'title' => $title,
                ));
            }
            ?>

            <? if (isset($combination)) { ?>
                <div class="row bdl-details">
                    <div class="col-md-7">
                        <div id="highmap"></div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="content col-md-12">
                                <? if (isset($combination['local'])) { ?>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="input-group localDataSearch">
                                                <span class="input-group-addon" data-icon="&#xe600;"></span>
                                                <input type="text" class="form-control"
                                                       placeholder="<?php switch ($levels_selected) {
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
                                                        <? foreach ($levels as $level) { ?>
                                                            <? if (!isset($level['selected'])) { ?>
                                                                <li>
                                                                    <a href="/dane/bdl_wskazniki/<?= $object->getId() . ',' . $this->request->params['slug'] . '/kombinacje/' . $combination['id'] . '/' . $level['id'] ?>">
                                                                        <?= $level["label"] ?>
                                                                    </a>
                                                                </li>
                                                            <? } else { ?>
                                                                <li class="disable">
                                                                    <a>
                                                                        <span class="glyphicon glyphicon-ok"
                                                                              aria-hidden="true"></span>
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <? foreach ($combination['local'] as $local) { ?>
                                            <tr class="wskaznikStatic" data-dim_id="<?= $combination['id'] ?>"
                                                data-local_type="<?= $levels_selected ?>"
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
                                    <?= $combination['jednostka'] ?>
	                            </span>
	                            <span class="sortOption"
                                      data-ay-sort-weight="<?= $local['ly'] ?>"><?= __d('dane', 'LC_BDL_WSKAZNIKI_LASTYEAR', array($local['ly'])) ?></span>
                                                </td>
                                            </tr>
                                        <? } ?>
                                        </tbody>
                                    </table>
                                <? } ?>
                            </div>

                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>

<? if (isset($combination['local']) && is_array($combination['local'])): ?>
    <script type="text/javascript">var local_data = <?= json_encode($combination['local']); ?>;
        var unitStr = '<?= $combination['jednostka'] ?>';</script>
<? endif; ?>

<?= $this->Element('dataobject/pageEnd'); ?>
