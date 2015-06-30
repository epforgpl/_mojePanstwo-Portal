<ul class="dataAggs bg">
    <? foreach ($data['aggs'] as $agg_id => $agg_data) {
        if ($agg_id == '_channels')
            continue;

        if ( 
        	( $agg_id == 'apps' ) && 
        	isset($agg_data['buckets']) && 
        	!empty($agg_data['buckets'])
        ) { ?>
            <li class="agg">
                <h2>Szukaj w aplikacji:</h2>
                <? echo $this->element('Dane.DataBrowser/apps', array('data' => $agg_data)); ?>
            </li>
            <? continue;
        }
		
        $minBucketsCountNum = (
	        ( @!isset($this->request->query['conditions'][$data['aggs_visuals_map'][$agg_id]['field']]) ) &&
        	( @$data['aggs_visuals_map'][$agg_id]['skin'] == 'pie_chart' )
        ) ? 1 : 0;		
		
        if (isset($agg_data['buckets']) && (count($agg_data['buckets']) > $minBucketsCountNum) && isset($data['aggs_visuals_map'][$agg_id])) {
            $empty = true;

            foreach ($agg_data['buckets'] as $b) {
                if ($b['doc_count']) {
                    $empty = false;
                    break;
                }
            }

            if ($empty)
                break;

            ?>
            <li class="agg<? if (isset($data['aggs_visuals_map'][$agg_id]['class'])) echo " " . $data['aggs_visuals_map'][$agg_id]['class']; ?>">
                <h2><?= $data['aggs_visuals_map'][$agg_id]['label']; ?></h2>
                <? if (isset($data['aggs_visuals_map'][$agg_id]['dictionary']) && isset($agg_data['buckets']) && ($dictionary = $data['aggs_visuals_map'][$agg_id]['dictionary']))
                    foreach ($agg_data['buckets'] as &$b)
                        $b['label']['buckets'][0]['key'] = array_key_exists($b['key'], $dictionary) ? $dictionary[$b['key']] : '';

                echo $this->element('Dane.DataBrowser/' . $data['aggs_visuals_map'][$agg_id]['skin'], array(
                    'data' => $agg_data,
                    'map' => $data['aggs_visuals_map'][$agg_id]
                ));
                ?>
            </li>
        <? } ?>
    <? } ?>
</ul>