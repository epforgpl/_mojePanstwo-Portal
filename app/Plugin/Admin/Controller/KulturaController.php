<?php

App::uses('AdminAppController', 'Admin.Controller');

class KulturaController extends AdminAppController {

    public $components = array('RequestHandler', 'S3');
    public $uses = array('Admin.Kultura');
	
	public function plik() {
		
	    $plik = $this->Kultura->query("SELECT culture_reports.id, culture_reports.name, culture_files.report_id, culture_files.id, culture_files.name, section, culture_tabs.id, culture_tabs.name, culture_tabs.html, culture_tabs.saved FROM culture_files JOIN culture_tabs ON culture_tabs.file_id=culture_files.id JOIN culture_reports ON culture_files.report_id=culture_reports.id WHERE culture_tabs.id='" . $this->request->params['id'] . "' ORDER BY culture_files.report_id ASC, culture_files.section ASC, culture_tabs.tab ASC LIMIT 1");
	    
	    $plik = $plik[0];
	    
	    
	    if( $plik && !$plik['culture_tabs']['saved'] && $this->request->is('post') ) {
		    		    
		    $this->Kultura->saveTab(array_merge($this->request->data, array(
			    'tab_id' => $plik['culture_tabs']['id'],
			    'file_id' => $plik['culture_files']['id'],
			    'report_id' => $plik['culture_reports']['id'],
		    )));
		    
		    $this->set('status', true);
		    $this->set('_serialize', array('status'));
		    
	    } else {
	    
		    $this->set('plik', $plik);
		    $this->set('title_for_layout', $plik['culture_tabs']['name'] . ' - ' . $plik['culture_files']['name']);

	    }
	    
	}
	
	public function survey() {
				
	    $survey = $this->Kultura->query("SELECT id, title, html FROM culture_surveys WHERE id='" . $this->request->params['pass'][0] . "'");
	    
	    $survey = $survey[0];
	    
	    $this->set('survey', $survey);
	    
	}
	
    public function pliki() {
	    
	    $_data = $this->Kultura->query("SELECT culture_reports.id, culture_reports.name, culture_files.report_id, culture_files.id, culture_files.name, section, culture_tabs.id, culture_tabs.name, culture_tabs.saved, culture_tabs.saved_ts, culture_surveys.id, culture_surveys.title FROM culture_files JOIN culture_tabs ON culture_tabs.file_id=culture_files.id JOIN culture_reports ON culture_files.report_id=culture_reports.id LEFT JOIN culture_surveys ON culture_surveys.tab_id=culture_tabs.id WHERE culture_reports.id=1 ORDER BY culture_files.report_id ASC, culture_files.section ASC, culture_tabs.tab ASC, culture_surveys.id ASC");
	    
	    
	    $data = array();
	    foreach( $_data as $_d ) {
		    
		    // debug( $_d );
		    
		    $data['reports'][ $_d['culture_reports']['id'] ]['data']['id'] = $_d['culture_reports']['id'];
		    $data['reports'][ $_d['culture_reports']['id'] ]['data']['name'] = $_d['culture_reports']['name'];
		    
		    
		    $data['reports'][ $_d['culture_reports']['id'] ]['files'][ $_d['culture_files']['id'] ]['data']['id'] = $_d['culture_files']['id'];
		    $data['reports'][ $_d['culture_reports']['id'] ]['files'][ $_d['culture_files']['id'] ]['data']['name'] = $_d['culture_files']['name'];
		    
		    
		    $data['reports'][ $_d['culture_reports']['id'] ]['files'][ $_d['culture_files']['id'] ]['tabs'][ $_d['culture_tabs']['id'] ]['data'] = array(
			    'id' => $_d['culture_tabs']['id'],
			    'name' => $_d['culture_tabs']['name'],
			    'saved' => $_d['culture_tabs']['saved'],
		    );
		    
		    if( $_d['culture_surveys']['id'] )
			    $data['reports'][ $_d['culture_reports']['id'] ]['files'][ $_d['culture_files']['id'] ]['tabs'][ $_d['culture_tabs']['id'] ]['surveys'][ $_d['culture_surveys']['id'] ]['data'] = array(
				    'id' => $_d['culture_surveys']['id'],
				    'title' => $_d['culture_surveys']['title'],
			    );
			    
			// debug($data);
		    
		    
	    }
	    	    
	    $this->set('reports', $data['reports']);
    }

}