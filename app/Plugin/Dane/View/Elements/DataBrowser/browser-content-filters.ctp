<? if(isset($dataBrowser['aggs_visuals_map']) && count($dataBrowser['aggs_visuals_map']) > 0) { $selected = false; ?>
    <ul class="nav nav-pills dataAggsDropdownList nopadding" role="tablist">
        <?
        foreach($dataBrowser['aggs_visuals_map'] as $name => $map) {

            if( ($name!='dataset') && isset($map['target']) && ($map['target']=='filters') ) {

                if( !isset($map['all']) )
                    $map['all'] = 'Wszystkie dane';

                $isSelected = $map['skin'] == 'date_histogram' ? isset($this->request->query['t']) : isset($this->request->query['conditions'][$map['field']]);

                ?>
                <li role="presentation" class="dropdown dataAggsDropdown<?= $isSelected ? ' active' : ''; ?>"
                    data-skin="<?= $map['skin'] ?>"
                    data-aggs='<?= json_encode($dataBrowser['aggs'][$name]) ?>'
                    data-cancel-request="<?= $map['cancelRequest'] ?>"
                    data-label-dictionary='<?= json_encode(isset($map['dictionary']) ? $map['dictionary'] : array()) ?>'
                    data-choose-request="<?= $map['chooseRequest'] ?>"
                    data-all-label="<?= $map['all'] ?>"
                    data-label="<?= @$map['label'] ?>"
                    data-is-selected="<?= $isSelected ?>"
                    data-selected="<?=  $map['skin'] == 'date_histogram' ? @$this->request->query['t'] : @$this->request->query['conditions'][$map['field']] ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <? if($isSelected) {

                            $selected = true;

                            if($map['skin'] == 'krs/kapitalizacja') {
                                $label = 'Kapitalizacja: ' . es_range_number($this->request->query['conditions'][$map['field']]);
                            } elseif($map['skin'] == 'date_histogram') {
                                $t = $this->request->query['t'];

                                $labels = array(
                                    '1D' => 'Ostatnie 24 godziny',
                                    '1W' => 'Ostatni tydzień',
                                    '1M' => 'Ostatni miesiąc',
                                    '1Y' => 'Ostatni rok'
                                );

                                if(array_key_exists($t, $labels)) {
                                    $label = $labels[$t];
                                } else {
                                    $label = 'Kiedykolwiek';
                                    $ranges = explode('TO', $t);
                                    if(count($ranges) == 2) {
                                        $from = trim(substr($ranges[0], 1));
                                        $to = trim(substr($ranges[1], 0, -1));
                                        if($from == $to) {
                                            $label = dataSlownie($from);
                                        } else {
                                            $label = dataSlownie($from) . ' - ' . dataSlownie($to);
                                        }
                                    }
                                }
                            } elseif(isset($map['dictionary']) && isset($map['dictionary'][$this->request->query['conditions'][$map['field']]])) {
                                $label = $map['dictionary'][$this->request->query['conditions'][$map['field']]];
                            } else {
                                foreach($dataBrowser['aggs'][$name]['buckets'] as $b => $bucket) {
                                    if($bucket['key'] == $this->request->query['conditions'][$map['field']]) {
                                        $label = isset($dataBrowser['aggs'][$name]['buckets'][$b]['label']['buckets'][0]['key']) ?
                                            $dataBrowser['aggs'][$name]['buckets'][$b]['label']['buckets'][0]['key'] :
                                            (isset($dataBrowser['aggs'][$name]['buckets'][$b]['key']) ?
                                                $dataBrowser['aggs'][$name]['buckets'][$b]['key'] :
                                                'Usuń filtr');
                                        break;
                                    }
                                }
                            }

                            echo isset($label) ? $label : $this->request->query['conditions'][$map['field']];

                        } else { ?>
                            <?= $map['all'] ?>
                        <? } ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu"></ul>
                </li>
            <? } } ?>

        <? if($selected) { ?>
            <li role="presentation">
                <a href="<?= $dataBrowser['cancel_url'] ?>" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    Usuń filtry
                </a>
            </li>
        <? } ?>

    </ul>
<? } ?>
