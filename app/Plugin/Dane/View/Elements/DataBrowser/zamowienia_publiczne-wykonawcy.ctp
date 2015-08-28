<?
$this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
$this->Combinator->add_libs('js', '../plugins/highstock/locals');

$counter_field = 'suma';

if( $data ) {
	foreach( $data['buckets'] as &$b ) {

        $b['label'] = $b['nazwa'];

    }
}

?>

<? if (!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-ColumnsHorizontal"<? if( isset($id) ){?> data-agg_id=<?= $id ?><? } ?> data-choose-request="<?= $map['chooseRequest']; ?>"
         data-chart="<?= htmlentities(json_encode($data)) ?>" data-counter_field="<?= $counter_field ?>">
        <div class="chart"></div>
    </div>
<? } else { ?>
    <p class="label-browser">
        <a href="<?= $map['cancelRequest']; ?>" aria-label="Close">
            <span class="label label-primary">
                <span aria-hidden="true">&times;</span>&nbsp;
                <?= $data['buckets'][0]['label']['buckets'][0]['key']; ?>
            </span>
        </a>
    </p>
<? } ?>
