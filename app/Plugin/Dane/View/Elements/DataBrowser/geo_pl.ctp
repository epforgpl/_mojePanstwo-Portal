<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/plugin/map');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');
?>

<? if (!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-GeoPL" data-chart-options="<?= htmlentities(json_encode($map['params'])) ?>" data-choose-request="<?= $map['chooseRequest']; ?>"
         data-chart="<?= htmlentities(json_encode($data)) ?>">
        <div class="chart">
        </div>
    </div>
<? } else { ?>
    <p class="label-browser">
        <a href="<?= $map['cancelRequest']; ?>" aria-label="Close">
            <span class="label label-primary">
                <span aria-hidden="true">&times;</span>&nbsp;
                <span class="to-replace"><?= isset($data['buckets'][0]['key']) ? $data['buckets'][0]['key'] : 'Usuń filtr'; ?></span>
            </span>
        </a>
    </p>
    <script type="text/javascript">
        window.onload = function() {
            $.get(mPHeart.constant.ajax.api + '/geo/geojson/getLabel?type=<?= $map['params']['unit']; ?>&id=<?= $data['buckets'][0]['key']; ?>', function (res) {
                if(res)
                    $('span.to-replace').first().html(res);
            });
        }
    </script>
<? } ?>
