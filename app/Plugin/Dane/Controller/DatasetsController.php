<?php
App::uses('CakeTime', 'Utility');
App::uses('DataobjectsController', 'Dane.Controller');

class DatasetsController extends DataobjectsController
{

    public $uses = array('Dane.Dataobject');
	
    public $components = array(
        // 'RequestHandler',
        'Paginator'
    );
    
    private $redirects_map = array(
	    'prawo' => 'prawo',
	    'prawo_hasla' => 'prawo/tematy',
	    'prawo_urzedowe' => 'prawo/urzedowe',
	    'prawo_wojewodztwa' => 'prawo/lokalne',
        'prawo_projekty' => 'prawo/projekty',
	    'instytucje' => 'kto_tu_rzadzi',
	    'urzednicy' => 'kto_tu_rzadzi/urzednicy',
        'bdl_wskazniki' => 'statystyka',
        'bdl_wskazniki_grupy' => 'statystyka/bdl_grupy',
        'bdl_wskazniki_kategorie' => 'statystyka/bdl_kategorie',
        'twitter' => 'media/tweets',
        'twitter_accounts' => 'media/twitter_accounts',
        'krs_podmioty' => 'krs',
        'krs_osoby' => 'krs/osoby',
        'msig' => 'krs/msig',
        'gminy' => 'moja_gmina/gminy',
        'kody_pocztowe' => 'moja_gmina/kody_pocztowe',
        'miejscowosci' => 'moja_gmina/miejscowosci',
        'powiaty' => 'moja_gmina/powiaty',
        'wojewodztwa' => 'moja_gmina/wojewodztwa',
        'radni_gmin' => 'moja_gmina/radni',
        'sa_orzeczenia' => 'sadometr',
        'sedziowie' => 'sadometr/sedziowie',
        'sn_orzeczenia' => 'sadometr/sn_orzeczenia',
        'sp_orzeczenia' => 'sadometr/sp_orzeczenia',
        'kolej_stacje' => 'koleje',
        'kolej_linie' => 'koleje/linie',
        'zamowienia_publiczne' => 'zamowienia_publiczne',
        'zamowienia_publiczne_wykonawcy' => 'zamowienia_publiczne/wykonawcy',
        'dotacje_ue' => 'zamowienia_publiczne/dotacje_unijne',
        'patenty' => 'patenty',
        'poslowie' => 'sejmometr/poslowie',
        'sejm' => 'sejmometr/sejm',
        'sejm_debaty' => 'sejmometr/sejm_debaty',
        'sejm_dezyderaty' => 'sejmometr/sejm_dezyderaty',
        'sejm_druki' => 'sejmometr/sejm_druki',
        'sejm_glosowania' => 'sejmometr/sejm_glosowania',
        'sejm_interpelacje' => 'sejmometr/sejm_interpelacje',
        'sejm_kluby' => 'sejmometr/sejm_kluby',
        'sejm_komisje' => 'sejmometr/sejm_komisje',
        'sejm_komunikaty' => 'sejmometr/sejm_komunikaty',
        'sejm_posiedzenia' => 'sejmometr/sejm_posiedzenia',
        'sejm_posiedzenia_punkty' => 'sejmometr/sejm_posiedzenia_punkty',
        'sejm_wystapienia' => 'sejmometr/sejm_wystapienia',
        'sejm_komisje_opinie' => 'sejmometr/sejm_komisje_opinie',
        'sejm_komisje_uchwaly' => 'sejmometr/sejm_komisje_uchwaly',
        'poslowie_oswiadczenia_majatkowe' => 'sejmometr/poslowie_oswiadczenia_majatkowe',
        'poslowie_rejestr_korzysci' => 'sejmometr/poslowie_rejestr_korzysci',
        'poslowie_wspolpracownicy' => 'sejmometr/poslowie_wspolpracownicy',
    );

    public function index()
    {
		
		/*
		return $this->redirect('/dane/zbiory');
        
        $datasets = $this->API->getDatasets();
        $this->set('datasets', $datasets);

        $this->set('title_for_layout', 'Zbiory danych publicznych');
        */

    }

    public function view($slug = false) {
	    	    
	    if( array_key_exists($slug, $this->redirects_map) ) {
		    
		    $url = '/' . $this->redirects_map[$slug];
		    
		    if( !empty( $this->request->query ) )
		    	$url .= '?' . http_build_query( $this->request->query );
		    		    
		    return $this->redirect($url);
		    
	    } else {
	     
		    if( $slug ) {
		    	
		    	$layers = $this->initLayers;
	   
			    if( $this->object = $this->Dataobject->find('first', array(
				    'conditions' => array(
					    'dataset' => 'zbiory',
					    'zbiory.slug' => $slug,
				    ),
				    'layers' => $layers,
			    )) ) {
				    								
		            $this->set('object', $this->object);
		            $this->set('objectOptions', $this->objectOptions);
		            $this->set('microdata', $this->microdata);	
		            $this->set('title_for_layout', $this->object->getTitle());
		
		            if ($desc = $this->object->getDescription())
		                $this->setMetaDescription($desc);
		                
		                
		            $this->Components->load('Dane.DataBrowser', array(
			            'conditions' => array(
				            'dataset' => $this->object->getData('slug'),
			            ),
			            'aggsPreset' => $this->object->getData('slug'),
		            ));
				    
			    }
		    
		    } else {
			    throw new BadRequestException();
		    }
	    
	    }
	    
    }
	
	/*
    public function beforeRender()
    {

        if ($this->request->params['action'] == 'view') {

            $data = $this->dataBrowser->dataset;

            if (!$data) {
                throw new NotFoundException('Could not find that post');
            }

            $dataset = $data['Dataset'];
            $datachannel = $data['Datachannel'];

            $this->set('_APPLICATION', $data['App']);

            $this->addStatusbarCrumb(array(
                'text' => $datachannel['nazwa'],
                'href' => '/dane/kanal/' . $datachannel['slug'],
            ));


            $title_for_layout = $dataset['name'];
            $this->set('title_for_layout', $title_for_layout);

        }

    }
    */

}