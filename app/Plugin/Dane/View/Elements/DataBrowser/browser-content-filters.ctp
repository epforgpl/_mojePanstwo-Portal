<? if(isset($dataBrowser['aggs_visuals_map']) && count($dataBrowser['aggs_visuals_map']) > 0) { ?>
    <ul class="nav nav-pills margin-top-10 dataAggsDropdownList nopadding" role="tablist">
        <?
            foreach($dataBrowser['aggs_visuals_map'] as $name => $map) {

                if( isset($map['target']) && ($map['target']=='filters') ) {

                    if( !isset($map['all']) )
                    	$map['all'] = 'Wszystkie dane';

        ?>
            <li role="presentation" class="dropdown dataAggsDropdown<?= isset($this->request->query['conditions'][$map['field']]) ? ' active' : ''; ?>"
                data-skin="<?= $map['skin'] ?>"
                data-aggs='<?= json_encode($dataBrowser['aggs'][$name]) ?>'
                data-cancel-request="<?= $map['cancelRequest'] ?>"
                data-label-dictionary='<?= json_encode(isset($map['dictionary']) ? $map['dictionary'] : array()) ?>'
                data-choose-request="<?= $map['chooseRequest'] ?>"
                data-all-label="<?= $map['all'] ?>"
                data-is-selected="<?= isset($this->request->query['conditions'][$map['field']]) ?>"
                data-selected="<?= @$this->request->query['conditions'][$map['field']] ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <? if(isset($this->request->query['conditions'][$map['field']])) {

                        if(isset($map['dictionary']) && isset($map['dictionary'][$this->request->query['conditions'][$map['field']]]))
                            $label = $map['dictionary'][$this->request->query['conditions'][$map['field']]];
                        else
                            $label = isset($dataBrowser['aggs'][$name]['buckets'][0]['label']['buckets'][0]['key']) ?
                                $dataBrowser['aggs'][$name]['buckets'][0]['label']['buckets'][0]['key'] :
                                (isset($dataBrowser['aggs'][$name]['buckets'][0]['key']) ?
                                    $dataBrowser['aggs'][$name]['buckets'][0]['key'] :
                                    'Usuń filtr');

                        echo $label;

                    } else { ?>
                        <?= $map['all'] ?>
                    <? } ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu"></ul>
            </li>
        <? } } ?>
    </ul>
<? } ?>
