<?
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
?>

<? if(!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-PieChart" data-choose-request="<?= $map['chooseRequest']; ?>" data-chart="<?= htmlentities(json_encode($data)) ?>">
        <div class="chart"></div>
    </div>
<? } else { ?>
    <p class="label-browser">
        <span class="label label-default">
            <?= $data['buckets'][0]['label']['buckets'][0]['key']; ?>
            <span class="badge"><?= $data['buckets'][0]['label']['buckets'][0]['doc_count']; ?></span>
        </span>
        <a href="<?= $map['cancelRequest']; ?>" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></a>
    </p>
<? } ?>