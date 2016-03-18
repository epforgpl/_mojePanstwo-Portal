<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$this->Html->css(array('../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min'), array('inline' => 'false', 'block' => 'cssBlock'));
$this->Html->script(array('../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min', '../plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pl.min'), array('inline' => 'false', 'block' => 'scriptBlock'));
?>

<? if (!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-DateHistogram" data-choose-request="<?= $map['chooseRequest']; ?>"
         data-chart="<?= htmlentities(json_encode($data)) ?>">
        <a class="btn btn-default btn-sm select-date-range pull-right" data-toggle="modal"
           data-target="#selectDateRangeModal" role="button"><span class="glyphicon glyphicon-calendar"
                                                                   aria-hidden="true"></span></a>

        <div class="modal fade" id="selectDateRangeModal" tabindex="-1" role="dialog"
             aria-labelledby="selectDateRangeModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="selectDateRangeModalLabel">Wybierz zakres</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-sm form-control" name="start"/>
                            <span class="input-group-addon">do</span>
                            <input type="text" class="input-sm form-control" name="end"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                        <button type="button" class="btn btn-primary" id="selectDateSubmit">Zastosuj</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart"></div>
    </div>
<? } else {

    $label = $this->request->query['conditions'][$map['field']];

    if (preg_match('^\[(.*?) TO (.*?)\]^i', $label, $match))
        $label = dataSlownie($match[1]) . ' - ' . dataSlownie($match[2]);


    ?>
    <p class="label-browser">
        <a href="<?= $map['cancelRequest']; ?>" aria-label="Close">
            <span class="label label-primary">
                <span aria-hidden="true">&times;</span>&nbsp;<?= $label ?>
            </span>
        </a>
    </p>
<? } ?>
