<?
$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');
?>

<? if (!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-ColumnsVertical" data-choose-request="<?= $map['chooseRequest']; ?>"
         data-chart="<?= htmlentities(json_encode($data)) ?>">
        <div class="chart"></div>
    </div>
<? } else { ?>
    <p class="label-browser">
        <a href="<?= $map['cancelRequest']; ?>" aria-label="Close">
            <span class="label label-primary">
                <span aria-hidden="true">&times;</span>&nbsp;
                <?
                $labelParts = explode('TO', $this->request->query['conditions'][$map['field']]);
                $from = filter_var($labelParts[0], FILTER_SANITIZE_NUMBER_INT);
                $to = filter_var($labelParts[1], FILTER_SANITIZE_NUMBER_INT);
                if ($from == 1)
                    $from = '';
                if ($to == '')
                    $label = '> ' . number_format_h($from);
                elseif ($from == '')
                    $label = '< ' . number_format_h($to);
                else
                    $label = number_format_h($from) . ' - ' . number_format_h($to);

                echo $label;
                ?>
            </span>
        </a>
    </p>
<? } ?>