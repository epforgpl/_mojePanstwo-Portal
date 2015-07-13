<?php

class FilterHelper extends AppHelper
{
    public $helpers = array(
        'Form',
        'Html',
        'Number'
    );

    public $filters = array();
    public $facets = array();
    public $switchers = array();
    public $conditions = array();

    public function generateFilters($filters = array(), $switchers = array(), $facets = array(), $page = array(), $conditions = array(), $hiddenFilters = array())
    {


        $this->facets = $facets;
        $this->filters = $filters;
        $this->switchers = $switchers;
        $this->conditions = $conditions;

        $out = $this->Form->create('Dataset', array(
            'id' => 'DatasetViewForm',
            'type' => 'get',
            'url' => $page['href']
        ));


        if (isset($this->params->query['order'])) {
            $out .= $this->Form->hidden('order', array('value' => $this->params->query['order']));
        }

        $out .= '<ul id="filters">';


        // SEARCH

        /*
        $out .= '<li class="form-group filter innerSearch">';
        $out .= '<input id="innerSearch" type="text" class="form-control" autocomplete="off" name="q" placeholder="' . __d('dane', __('LC_DANE_SEARCH')) . '" data-icon-after="&#xe600;" value="' . ((isset($this->params->query['q'])) ? htmlspecialchars($this->params->query['q']) : '') . '"/>';
        $out .= '</li>';
        */


        /*
        if (($page['mode'] == 'dataset') && !$page['datasetLocked']) {

            // DATASET INFO
            $out .= '<li class="filter form-group">';
            $out .= '<div class="label_cont"><label>Zbiór danych:</label></div>';
            $out .= '<ul class="options list-group">';
            $out .= '<li class="option checkbox list-group-item">';
            $out .= '<div class="checkbox-inline">';
            $out .= '<input name="dataset" type="checkbox" checked="checked" value="' . $page['tag'] . '" />';
            $out .= '<label>' . $page['title'] . '</label>';

            $href = $page['href'];
            if (isset($this->params->query['q']) && $this->params->query['q'])
                $href .= '?' . http_build_query(array(
                        'q' => $this->params->query['q'],
                    ));

            $out .= '<p class="sublink"><a href="' . $href . '">Usuń wybór zbioru danych</a></p>';

            $out .= '</div>';
            $out .= '</li>';
            $out .= '</ul>';
            $out .= '</li>';

        }
        */


        // SWITCHERS
        if (!empty($this->switchers)) {

            $out .= '<li class="filter form-group changeable';
            if (isset($filter['filter']['default_hidden']) && $filter['filter']['default_hidden'] == 1) $out .= " inactive";
            $out .= '">';
            $out .= '<div class="label_cont"><label><span class="glyphicon glyphicon-cog"></span> Opcje</label></div>';
            $out .= '<ul class="options list-group">';

            foreach ($this->switchers as $switcher) {
                $out .= $this->_View->element('Dane.dataset-switcher', array(
                    'switcher' => $switcher['switcher'],
                    'conditions' => $this->conditions,
                ));
            }

            $out .= '</ul>';
            $out .= '</li>';

        }


        // FILTERS
        foreach ($this->filters as $filter) {

            if ($filter['filter']['parent_field'] && !isset($this->request->query[$filter['filter']['parent_field']])) {
                continue;
            }

            $facet = $this->getFacets($filter['filter']['field']);

            if (($filter['filter']['typ_id'] == 1) && @empty($facet['params']['options'])) {
            } else {

                $out .= '<li class="filter form-group changeable';

                if (
                    (!array_key_exists($filter['filter']['field'], $conditions)) &&
                    (
                        (
                            isset($filter['filter']['default_hidden']) &&
                            ($filter['filter']['default_hidden'] == 1)
                        ) ||
                        (
                        in_array($filter['filter']['field'], $hiddenFilters)
                        )
                    )
                )
                    $out .= " inactive";

                $out .= '">';
                $out .= '<div class="label_cont"><label><span class="glyphicon glyphicon-filter"></span> ' . $filter['filter']['label'] . '</label>';

                if ($filter['filter']['desc']) {
                    $out .= '<p class="sublabel">' . $filter['filter']['desc'] . '</p>';
                }

                $out .= '</div>';


                switch ($filter['filter']['typ_id']) {
                    case 1:
                        $out .= $this->_View->element('Dane.filters/option', array(
                            'conditions' => $conditions,
                            'filter' => $filter,
                            'facet' => $facet
                        ));
                        break;
                    case 2:
                        $out .= $this->_View->element('Dane.filters/enum', array(
                            'conditions' => $conditions,
                            'filter' => $filter,
                            'facet' => $facet
                        ));
                        break;
                    case 3:
                        $out .= $this->_View->element('Dane.filters/number', array(
                            'conditions' => $conditions,
                            'filter' => $filter,
                            'facet' => $facet
                        ));
                        break;
                    case 4:
                        $out .= $this->_View->element('Dane.filters/date', array(
                            'conditions' => $conditions,
                            'filter' => $filter,
                            'facet' => $facet
                        ));
                        break;
                    case 5:
                        $out .= $this->_View->element('Dane.filters/dataset', array(
                            'conditions' => $conditions,
                            'filter' => $filter,
                            'facet' => $facet
                        ));
                        break;
                }
                $out .= '</li>';

            }
        }

        $out .= '</ul>';
        $out .= $this->Form->submit(__d('dane', 'LC_DANE_FILTER'), array(
            'name' => 'search',
            'class' => 'submitButton btn btn-primary',
            'style' => 'visibility: hidden;'
        ));
        $out .= $this->Form->end();

        return $out;
    }

    protected function getFacets($filter_field = null)
    {
        foreach ($this->facets as $facet) {
            if ($facet['field'] == $filter_field) {
                return $facet;
            }
        }
    }

    public function normalizeOptions($options = array(), $radio = false)
    {
        $out = array();
        if (!is_array($options)) {
            return array();
        }
        foreach ($options as $option) {
            $out[$option['id']] = $option['label'] . ' <span class="filterCount small">(' . $this->Number->currency($option['count'], '', array('places' => 0)) . ')</span>';
        }

        return $out;
    }
}