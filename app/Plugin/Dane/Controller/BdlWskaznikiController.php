<?php

App::uses('DataobjectsController', 'Dane.Controller');

class BdlWskaznikiController extends DataobjectsController
{

    public $menu = array();
    public $components = array('RequestHandler');
    public $objectOptions = array(
        'bigTitle' => true,
    );

    public $initLayers = array('dimennsions');

    public function view()
    {

        parent::load();

        $expand_dimension = isset($this->request->query['i']) ? (int)$this->request->query['i'] : $this->object->getData('i');
        $dims = $this->object->getLayer('dimennsions');
        $expanded_dimension = array();


        // building dimmensions array (it will be usefull as a parameter for future API calls

        $dimmensions_array = array();

        if (isset($dimension['dim_str'])) {

            $dimmensions_array = explode(',', $dimension['dim_str']);

        } else {

            for ($d = 0; $d < 5; $d++) {

                $dvalue = 0;

                if ($d != $expand_dimension) {
                    $dvalue = isset($this->request->query['d' . $d]) ?
                        (int)$this->request->query['d' . $d] :
                        (int)@$dims[$d]['options'][0]['id'];
                }

                $dimmensions_array[] = $dvalue;

            }

        }


        // Setting selected dimmension

        $i = 0;
        foreach ($dims as &$dim) {

            foreach ($dim['options'] as &$option) {
                $option['selected'] = ($option['id'] == $dimmensions_array[$i]);
            }

            if ($expand_dimension == $i) {


                $expanded_dimension = $dim;
                $params_dimmensions = array();

                foreach ($expanded_dimension['options'] as &$option) {

                    $temp_dimmensions_array = $dimmensions_array;
                    $temp_dimmensions_array[$i] = (int)$option['id'];
                    $params_dimmensions[] = $temp_dimmensions_array;
                    $option['dim_str'] = implode(',', $temp_dimmensions_array);

                    if (isset($dimension['dim_str'])) {
                        if ($dimension['dim_str'] == $option['dim_str']) {
                            $option['data'] = $dimension;
                        } else {
                            $option = null;
                        }
                    }

                }

                if (isset($dimension['dim_str'])) {
                    $expanded_dimension['options'] = array_filter($expanded_dimension['options']);
                }
				
				
                if (empty($dimension)) {
					
					$this->loadModel('Statystyka.BDL');
                    $data_for_dimmensions = $this->BDL->getDataForDimmesions($params_dimmensions, $this->object->getId());
                    if (!empty($data_for_dimmensions)) {
                        foreach ($data_for_dimmensions as $data) {
                            foreach ($expanded_dimension['options'] as &$option) {
                                if ($data['dim_str'] == $option['dim_str']) {

                                    $option['data'] = $data;
                                    break;

                                }
                            }
                        }
                    }

                }

            }

            $i++;
        }


        $this->set('dims', $dims);
        $this->set('expand_dimension', $expand_dimension);
        $this->set('expanded_dimension', $expanded_dimension);
        $this->set('dimmensions_array', $dimmensions_array);


    }

    public function kombinacje()
    {
		
		$this->view();
		$this->loadModel('Statystyka.BDL');
		
        if (isset($this->request->query['d']) && $this->request->query['d']) {

            $dimmensions_array = array();
            for ($d = 0; $d < 5; $d++) {
                $dimmensions_array[] = isset($this->request->query['d' . $d]) ?
                    (int)$this->request->query['d' . $d] :
                    0;
            }

            $data_for_dimmensions = $this->BDL->getDataForDimmesions(array($dimmensions_array), $this->request->params['id']);
            if ($data_for_dimmensions) {
                $url = '/dane/bdl_wskazniki/' . $this->request->params['id'] . '/' . $data_for_dimmensions[0]['id'];
                $this->redirect($url);
                die();
            }

        }
				
        $dimension = $this->BDL->getDataForDimension($this->request->params['subid']);
        

        $level_selected = false;
        $selected_level_id = false;

        if (!empty($dimension['levels'])) {

            if (isset($this->request->params['level']) && in_array($this->request->params['level'], array(
                    'gminy',
                    'powiaty',
                    'wojewodztwa'
                ))
            ) {

                foreach ($dimension['levels'] as &$level) {
                    if ($level['id'] == $this->request->params['level']) {

                        $selected_level_id = $level['id'];
                        $level['selected'] = true;
                        $level_selected = true;

                    }
                }

            }

            if (!$level_selected) {
                $dimension['levels'][0]['selected'] = true;
                $selected_level_id = $dimension['levels'][0]['id'];
            }

        }

        if ($selected_level_id) {

            $local_data = $this->BDL->getLocalDataForDimension($dimension['id'], $selected_level_id);
            $this->set('local_data', $local_data);

        }

        $this->set('dimension', $dimension);
    }


    public function chart_data_for_dimmensions()
    {

        $dims = isset($this->request->query['dims']) ? explode(',', $this->request->query['dims']) : array();
        
        $this->loadModel('Statystyka.BDL');
        $data = $this->BDL->getChartDataForDimmesions($dims);

        $this->set('data', $data);
        $this->set('_serialize', array('data'));

    }
    
    public function legacy_redirect()
    {
	    
	    return $this->redirect('/dane/bdl_wskazniki/' . $this->request->params['id'] . ',' . $this->request->params['slug'] . '/kombinacje/' . $this->request->params['subid']);
	    
    }
    
} 