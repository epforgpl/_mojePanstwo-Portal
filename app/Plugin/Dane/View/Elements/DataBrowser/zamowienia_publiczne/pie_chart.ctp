<?
    $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
    $this->Combinator->add_libs('js', '../plugins/highcharts/locals');
    
    foreach( $data['buckets'] as &$d ) {
    	$d['doc_count'] = $d['wartosc_cena']['value'];
    	$d['str'] = number_format_h( $d['wartosc_cena']['value'] );
    }
    
?>

<? if(!isset($this->request->query['conditions'][$map['field']])) { ?>
    <div class="agg agg-PieChart" data-choose-request="<?= $map['chooseRequest']; ?>" data-chart="<?= htmlentities(json_encode($data)) ?>">
        <div class="chart">
	        Spinner
        </div>
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