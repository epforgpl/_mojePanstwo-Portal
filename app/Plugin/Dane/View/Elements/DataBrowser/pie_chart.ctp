<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
?>

<? if (!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-PieChart" data-chart-options="false" data-choose-request="<?= $map['chooseRequest']; ?>"
         data-chart="<?= htmlentities(json_encode($data)) ?>">
        <div class="chart">
        </div>
    </div>
<? } else { ?>
    <p class="label-browser">
        <a href="<?= $map['cancelRequest']; ?>" aria-label="Close">
            <span class="label label-primary">
                <span aria-hidden="true">&times;</span>&nbsp;
                <? if(isset($data['buckets'][0]['label']['buckets'][0]['key'])) { ?>
                    <? $key = $data['buckets'][0]['label']['buckets'][0]['key']; ?>
                    <?= strlen($key) > 37 ? substr($key, 0, 37) . '..' : $key; ?>
                <? } else { ?>
                    Usuń filtr
                <? } ?>
            </span>
        </a>
    </p>
<? } ?>
