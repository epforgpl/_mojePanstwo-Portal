<?php

class DataobjectHelper extends AppHelper
{
    public $helpers = array('Number');
    /**
     * @var array
     */
    protected $object;
    private $thumbnail_sizes_map = array(
        'poslowie' => '0',
    );

    public function __construct(View $view, $settings = array())
    {
        parent::__construct($view, $settings);
    }


    public function getDate($field = null, $add_hour = false)
    {

        if ($this->object->getDate()) {

            $temp = '<span>{day}</span><p>{month} {year}</p>';
            $ts = strtotime($this->object->getDate());

            $formatting = array(
                'day' => date('j', $ts),
                'year' => date('Y', $ts),
                'month' => __(date('M', $ts), true),
            );

            if ($this->object->getTime()) {
                $ts = strtotime($this->object->getTime());
                $hour = date('H:i', $ts);
                $formatting['hour'] = $hour;

                $temp .= '<div class="times">{hour}</div>';
            }

            foreach ($formatting as $key => $partial) {
                $temp = preg_replace('/\{' . $key . '\}/', $partial, $temp);
            }

            return $temp;
        }

        return false;
    }

    public function getData($key = null)
    {
        if (is_null($key)) {
            return $this->object->getData();
        } else {
            if ($this->object->getData($key)) {
                return $this->object->getData($key);
            } else {
                return false;
            }
        }
    }

    public function render($object, $theme = 'default', $options = array())
    {
				
        if (is_array($object)) {
			
			if( isset($object['fields']['source']) ) {
				
				$dataset = $object['fields']['dataset'][0];

	            $class = ucfirst($dataset);
	            $file = APPLIBS . 'Dataobject/' . $class . '.php';
	            
	            $data = array();
	            $_data = $object['fields']['source'][0]['data'];
	                       
	            foreach( $_data as $k => $d )
	        		$data[ $dataset . '.' . $k ] = $d;
	            	            	
	            $object = array(
	                'dataset' => $dataset,
	                'global_id' => $object['_id'],
	                'id' => $object['fields']['id'][0][0],
	                'data' => $data,
	                'static' => isset($object['fields']['static']) ? $object['fields']['static'] : false,
	                'slug' => isset($object['fields']['slug']) ? $object['fields']['slug'] : false,
	            );
				
			} else {
			
	            $dataset = $object['fields']['dataset'][0];
								
	            $class = ucfirst($dataset);
	            $file = APPLIBS . 'Dataobject/' . $class . '.php';
	            	            
	            $data = array();
	            $_data = $object['_source']['data'];
	            
	            foreach( $_data as $k => $d )
	            	if( is_array($d) )
		            	if( !empty($d) )
			            	foreach( $d as $dk => $dv )
			            		$data[ $k . '.' . $dk ] = $dv;
	            									
	            $object = array(
	                'dataset' => $object['fields']['dataset'][0],
	                'global_id' => $object['_id'],
	                'id' => $object['fields']['id'][0],
	                'data' => $data,
	                'static' => isset($object['_source']['static']) ? $object['_source']['static'] : false,
	                'slug' => isset($object['_source']['slug']) ? $object['_source']['slug'] : false,
	            );
            
            }
            
                        
			require_once( APPLIBS . 'Dataobject.php' );
            if (file_exists($file)) {
                require_once($file);
                $class = 'MP\\Lib\\' . $class;
                $object = new $class($object, $options);
            } else {
                $object = new MP\Lib\Dataobject($object, $options);
            }

        }
        
        $object->setOptions($options);

        $bg = isset($options['bg']) ? $options['bg'] : false;
        $hlFields = isset($options['hlFields']) ? $options['hlFields'] : false;
        $bigTitle = isset($options['bigTitle']) ? $options['bigTitle'] : false;
        $hlFieldsPush = isset($options['hlFieldsPush']) ? $options['hlFieldsPush'] : false;
        $routes = isset($options['routes']) ? $options['routes'] : array();
        $forceLabel = isset($options['forceLabel']) ? $options['forceLabel'] : false;
        $file = isset($options['file']) ? $options['file'] : false;
        $titleTag = isset($options['titleTag']) ? $options['titleTag'] : 'h1';
        $defaults = isset($options['defaults']) ? $options['defaults'] : array();
        $microdata = isset($options['microdata']) ? $options['microdata'] : array();
        $disable_link = isset($options['disable_link']) ? (boolean)$options['disable_link'] : false;
        $selected = isset($options['selected']) ? (boolean)$options['selected'] : false;
        $thumbWidth = isset($options['thumbWidth']) ? $options['thumbWidth'] : 1;

        $class = isset($options['class']) ? $options['class'] : false;
        $alertsButtons = isset($options['alertsButtons']) ? $options['alertsButtons'] : false;
        $alertsStatus = isset($options['alertsStatus']) ? $options['alertsStatus'] : false;
        $truncate = isset($options['truncate']) ? $options['truncate'] : 150;
				
        $this->setObject($object);
        if (!empty($routes)) {
            $object->addRoutes($routes);
        }

        /*
        if ($theme != 'dataobjectSlider') {
            $path = $this->getRenderPath($object, $theme);
            if (!file_exists($path))
                $theme = 'default';
        }
        */


        $params = array(
            'object' => $this->object,
            'theme' => $theme,
            'bg' => $bg,
            'hlFields' => $hlFields,
            'hlFieldsPush' => $hlFieldsPush,
            'bigTitle' => $bigTitle,
            'forceLabel' => $forceLabel,
            'thumbSize' => $this->getThumbSize(),
            'gid' => @$this->object->id,
            'file' => $file,
            'options' => $options,
            'class' => $class,
            'alertsButtons' => $alertsButtons,
            'alertsStatus' => $alertsStatus,
            'titleTag' => $titleTag,
            'defaults' => $defaults,
            'microdata' => $microdata,
            'show_link' => !$disable_link,
            'selected' => $selected,
            'thumbWidth' => $thumbWidth,
            'truncate' => $truncate,
        );
				
        return $this->_View->element($theme, $params, array('plugin' => 'Dane'));
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    private function getThumbSize()
    {

        return array_key_exists($this->object->getDataset(), $this->thumbnail_sizes_map) ?
            $this->thumbnail_sizes_map[$this->object->getDataset()] :
            '1';

    }

    public function highlights($fields = false, $fieldsPush = false, $options = array())
    {

        $output = '';
        $fields = $this->object->getHiglightedFields($fields, $fieldsPush);

        $fields_count = count($fields);
        if ($fields_count) {

            $col_width = 3;

            if ($fields_count == 1) {
                $col_width = 12;
            } elseif ($fields_count == 2) {
                $col_width = 6;
            } elseif ($fields_count == 3) {
                $col_width = 4;
            } elseif ($fields_count == 5) {
                $col_width = 2;
            } elseif ($fields_count == 6) {
                $col_width = 2;
            }

            $output .= '<div class="row dataHighlights dimmed';

            if (($col_width >= 4) || (isset($options['inl']) && $options['inl'])) {
                $output .= ' inl';
            }
            $output .= '"';

            if (isset($options['details']) && ($options['details'] === false)) {
                $output .= ' style="display: none;"';
            }

            $output .= '>';

            foreach ($fields as $field => $field_params) {

                $output .= $this->getHTMLForField($field, $field_params, array(
                    'col_width' => $col_width,
                ));

            }

            $output .= '</div>';
        }

        return $output;

    }

    public function getHTMLForField($field, $field_params, $options = array())
    {
        $output = '';
        $normalizeText = false;
        $col_width = isset($options['col_width']) ? $options['col_width'] : 4;
        $hidden = isset($options['hidden']) ? $options['hidden'] : false;

        $field_label = $field_params['label'];
        $field_value = $field_params['value'];
        $field_options = (isset($field_params['options']) && is_array($field_params['options'])) ? $field_params['options'] : array();

        $field_type = $field_params['type'];
        if (stripos($field, 'data') === 0) {
            $field_type = 'date';
        }


        if (($field_type == 'date') && !isset($field_options['format'])) {
            if ($field_value == '0000-00-00') {
                return false;
            }
            $field_value = dataSlownie($field_value);
        } elseif ($field_type == 'pln') {
            $field_value = (float)$field_value;
            if (!$field_value) {
                return false;
            }
            $field_value = number_format_h($field_value, 2, ',', ' ') . ' PLN';
        } elseif ($field_type == 'integer') {
            if (!$field_value) {
                return false;
            } else {
                $field_value = number_format($field_value, 0, '', ' ');
            }
        } elseif ($field_type == 'percent') {
            $field_value .= '%';
        } elseif ($field_type == 'duration') {
            if (!$field_value) {
                return false;
            } else {
                $field_value = number_format($field_value, 0, '', ' ') . 'm';
            }
        } elseif ($field_type == 'vote') {
            $field_value = '<div class="voted btn btn-default btn-glos-' . $field_value . '" data-glos="' . $field_value . '">' . $this->voted($field_value) . '</div>';
        }

        if (isset($field_options['format'])) {
            switch ($field_options['format']) {
                case 'wiek': {
                    $field_value = pl_dopelniacz(pl_wiek($field_value), 'rok', 'lata', 'lat');
                    break;
                }

                case 'bytes': {
                    $field_value = round($field_params['value'] / 1024);
                    $field_value = number_format($field_value, 0, '', ' ') . 'kB';
                    break;
                }
            }
        }


        if (isset($field_options['dictionary'])) {
            if (is_array($field_value)) {
                if (!empty($field_value)) {
                    foreach ($field_value as &$v) {
                        $v = @$field_options['dictionary'][$v];
                    }
                }
            } else {
                $field_value = @$field_options['dictionary'][$field_value];
            }
        }


        if (isset($field_options['truncate'])) {


            $base_part = mb_substr($field_value, 0, $field_options['truncate']);
            $add_part = mb_substr($field_value, $field_options['truncate']);
            $field_value = '<span class="base">' . $base_part . '</span>';

            if ($add_part) {
                $field_value .= ' <a href="#" onclick="return false;">...</a><span class="add">' . $add_part . '</span>';
            }

        }


        if (isset($field_options['img'])) {
            if (preg_match_all('/\{\$(.*?)\}/i', $field_options['img'], $matches)) {
                for ($m = 0; $m < count($matches[0]); $m++) {
                    $field_value = '<img src="' . str_replace($matches[0][$m], $this->object->getData($matches[1][$m]), $field_options['img']) . '" /> ' . $field_value;
                }
            }
        }


        if (isset($field_options['normalizeText']) && $field_options['normalizeText']) {
            $normalizeText = true;
        }


        if (isset($field_options['link'])) {
            if (is_array($field_options['link']) && isset($field_options['link']['dataset']) && isset($field_options['link']['object_id'])) {

                if (is_array($field_value)) {
                    for ($f = 0; $f < count($field_value); $f++) {
                        $object_id = ($field_options['link']['object_id'][0] == '$') ?
                            $this->object->getData(mb_substr($field_options['link']['object_id'], 1)) :
                            $field_options['link']['object_id'];

                        $object_id = @$object_id[$f];
                        $href = '/dane/' . $field_options['link']['dataset'] . '/' . $object_id;

                        $field_value[$f] = '<a href="' . $href . '">' . $field_value[$f] . '</a>';
                    }
                } else {
                    $object_id = ($field_options['link']['object_id'][0] == '$') ?
                        $this->object->getData(mb_substr($field_options['link']['object_id'], 1)) :
                        $field_options['link']['object_id'];

                    $href = '/dane/' . $field_options['link']['dataset'] . '/' . $object_id;

                    $field_value = '<a href="' . $href . '">' . $field_value . '</a>';
                }

            } elseif (is_array($field_options['link']) && $field_options['link']['href']) {
                $href = ($field_options['link']['href'][0] == '$') ?
                    $this->object->getData(mb_substr($field_options['link']['href'], 1)) :
                    $field_options['link']['href'];

                $_field_value = $field_value;

                $field_value = '<a';
                if (isset($field_options['link']['newWindow']) && $field_options['link']['newWindow']) {
                    $field_value .= ' target="_blank"';
                }
                $field_value .= ' href="' . $href . '">' . $_field_value . '</a>';
            }
        }


        if (isset($field_options['dopelniacz'])) {
            $field_value = pl_dopelniacz($field_value, $field_options['dopelniacz'][0], $field_options['dopelniacz'][1], $field_options['dopelniacz'][2]);
        }

        if (!empty($field_value)) {

            if (!is_array($field_value) && stripos($field_value, $field_label) === 0) {
                $field_value = trim(mb_substr($field_value, strlen($field_label)));
            }

            $output .= '<div class="dataHighlight';
            if ($col_width) {
                $output .= ' col-md-' . $col_width;
            }
            if ($hidden) {
                $output .= ' secondRow';
            }
            $output .= '"';
            $output .= '>';

            if ($field_label && !isset($field_options['hide']) && $field_type != 'vote') {
                $output .= '<p class="_label">' . $field_label . ':</p>';
            }

            $output .= '<p class="_value';

            if ($normalizeText) {
                $output .= ' normalizeText';
            }

            $output .= '">';

            if (is_array($field_value)) {
                $output .= '<ul class="hl_ul normalizeText"><li>' . implode('</li><li>', $field_value) . '</li></ul>';
            } else {
                $output .= $field_value;
            }

            $output .= '</p></div>';

        }

        return $output;

    }

    public function voted($i)
    {
        switch ($i) {
            case 1:
                return 'Za';
            case 2:
                return 'Przeciw';
            case 3:
                return 'Wstrzymanie';
            case 4:
                return 'Nieobecność';
        }
    }

    public function hlTableForObject($object, $fields, $options = array())
    {
        $data = array();
        if (empty($fields)) {
            return '';
        }

        if (is_numeric($options)) {
            $options = array(
                'col_width' => $options,
            );
        }

        foreach ($fields as $field) {

            $schema = $object->getSchemaForFieldname($field);
            if ($schema) {

                $data_options = array(
                    'type' => isset($schema[2]) ? $schema[2] : 'string',
                );

                if (!empty($schema[3]) && is_array($schema[3])) {
                    $data_options = array_merge($data_options, $schema[3]);
                }

                $data[] = array(
                    'id' => $field,
                    'label' => $schema[1],
                    'value' => $object->getData($field),
                    'options' => $data_options,
                );

            }

        }

        return $this->hlTable($data, $options);
    }

    public function hlTable($data, $options = array())
    {

        if (empty($data)) {
            return '';
        }

        $output = '<div class="dataHighlights normal row">';
        $index = 0;
        $limit = isset($options['limit']) ? $options['limit'] : 4;
        if (!isset($options['col_width'])) {
            $options['col_width'] = 3;
        }

        foreach ($data as $d) {

            $id = $d['id'];
            $label = $d['label'];
            $value = $d['value'];

            $d['type'] = $d['options']['type'];
            if (isset($options['display']) && ($options['display'] == 'firstRow')) {
                $html = $this->getHTMLForField($id, $d, array_merge($options, array(
                    'hidden' => ($index >= $limit),
                )));
            } else {
                $html = $this->getHTMLForField($id, $d, $options);
            }

            if ($html) {
                $output .= $html;
                $index++;
            }
        }

        $output .= '</div>';
        if (isset($options['display']) && ($options['display'] == 'firstRow') && ($index >= $limit)) {
            $output .= '<div class="row dataHighlightsOptions">';
            $output .= '<button class="btn btn-info btn-sm showMore pull-right">' . __d('dane', 'LC_DANE_BDL_WSKAZNIKI_POKAZ_WIECEJ') . '</button>';
            $output .= '<button class="btn btn-info btn-sm showLess hidden pull-right">' . __d('dane', 'LC_DANE_BDL_WSKAZNIKI_POKAZ_MNIEJ') . '</button>';
            $output .= '</div>';
        }

        return $output;
    }

    public function feed($params)
    {

        return $this->_View->element('DataobjectsFeed/view', array(
            'objects' => $params['data'],
            'preset' => $params['dataset'],
            'direction' => $params['direction'],
            'perPage' => $params['perPage'],
            'pagination' => $params['pagination'],
        ), array('plugin' => 'Dane'));

    }

    private function getRenderPath($object, $theme)
    {
        return App::pluginPath('Dane') . '/View/Elements/' . $theme . '/' . $object->getDataset() . '.ctp';
    }

} 