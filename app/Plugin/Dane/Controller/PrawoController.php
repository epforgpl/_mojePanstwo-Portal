<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PrawoController extends DataobjectsController
{

    public $initLayers = array('docs', 'counters', 'files', 'tags');
    public $helpers = array('Document');

    // public $uses = array('Dane.Dataliner');

    public $headerObject = array('url' => '/dane/img/headers/ustawa.jpg', 'height' => '250px');

    public $objectOptions = array(
        // 'hlFields' => array('isap_status_str', 'sygnatura', 'data_wydania', 'data_publikacji', 'data_wejscia_w_zycie'),
        'hlFields' => array(),
        'routes' => array(
            'description' => false,
        ),
    );

    public function hasla()
    {

        $this->_prepareView();

    }

    public function view($package = 1)
    {

        $this->_prepareView();
				
        if ($projekt_id = $this->object->getData('projekt_id')) {

            $projekt = $this->API->getObject('prawo_projekty', $projekt_id);
            $this->set('projekt', $projekt);

        }
		
		$this->prepareFeed();
		
		/*
        $dokument_id = false;
		
        if ($files = $this->object->getLayer('files')) {
            foreach ($files as $file) {
                if ($file['slug'] == 'tekst_aktualny') {
                    $dokument_id = $file['dokument_id'];
                    break;
                }
            }
        }

        // debug( $dokument_id ); die();
        $this->set('document', $this->API->document($files[0]['dokument_id']));
		*/

        /*
        $datalinerParams = array(
            'requestData' => array(
                'conditions' => array(
                    '_source' => 'prawo.historia:' . $this->object->getId(),
                ),
            ),
        );

        $data = $this->Dataliner->index( array(
            'conditions' => $datalinerParams['requestData']['conditions'],
        ) );

        $datalinerParams['initData'] = $data;
        */

        /*
        'type' => 'blog_post',
                                        'date' => $object->getDate(),
                                        'title' => 'Opublikowanie pierwotnej wersji aktu',
                                        'content' => '<div class="row"><div class="col-md-2"><img style="max-width: 56px;" src="' . $object->getThumbnailUrl(3) . '" /></div><div class="col-md-10"><a href="/dane/prawo/' . $object->getId() . '">' . $object->getTitle() . '</a></div></div>'
        */

        // $this->set( 'datalinerParams', $datalinerParams );


        // $this->set('document', $this->API->document( $this->object->getData('dokument_id') ));


        /*
        $docs = $this->object->getLayer('docs');
        $selected_doc_id = $this->object->getData('dokument_id');

        if (@$this->request->query['f'])
            foreach ($docs as $category)
                foreach ($category['files'] as $file)
                    if ($file['files']['dokument_id'] == $this->request->query['f']) {
                        $selected_doc_id = $file['files']['dokument_id'];
                        break;
                    }

        $document = $this->API->document($selected_doc_id);
        if ($this->request->isAjax()) {
            $this->set('html', $document->loadHtml($package));
            $this->set('_serialize', 'html');
        } else {
            $this->set(array(
                'docs' => $docs,
                'document' => $document,
                'documentPackage' => $package,
            ));

        }
        */

    }

    public function tekst_aktualny()
    {

        $this->_prepareView();

        $dokument_id = false;

        if ($files = $this->object->getLayer('files')) {
            foreach ($files as $file) {
                if ($file['slug'] == 'tekst_aktualny') {
                    $dokument_id = $file['dokument_id'];
                    break;
                }
            }
        }

        $this->set('document', $this->API->document($dokument_id));

    }
    
    public function tresc()
    {

        $this->_prepareView();

        $dokument_id = false;

        if ($files = $this->object->getLayer('files')) {
            foreach ($files as $file) {
                if ($file['slug'] == 'tekst_aktualny') {
                    $dokument_id = $file['dokument_id'];
                    break;
                }
            }
        }
		
		if( !$dokument_id )
			$dokument_id = $files[0]['dokument_id'];
				
        $this->set('document', $this->API->document($dokument_id));

    }

    public function tekst()
    {

        $this->_prepareView();

        $dokument_id = false;

        if ($files = $this->object->getLayer('files')) {
            foreach ($files as $file) {
                if ($file['slug'] == 'tekst') {
                    $dokument_id = $file['dokument_id'];
                    break;
                }
            }
        }

        $this->set('document', $this->API->document($dokument_id));

    }

    public function podstawa_prawna()
    {
        return $this->connections_view('podstawa_prawna', 'Podstawa prawna');
    }

    private function connections_view($id, $title)
    {

        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            // 'source' => 'poslowie.wspolpracownicy:' . $this->object->getId(),
            'dataset' => 'prawo',
            'noResultsTitle' => 'Brak aktów',
            'title' => $title,
            'conditions' => array(
                $id => $this->object->getId(),
            ),
        ));

        $this->request->params['action'] = $id;
        $this->set('title_for_layout', $title . ': ' . $this->object->getTitle());

    }

    public function podstawa_prawna_z_artykulem()
    {
        return $this->connections_view('podstawa_prawna_z_artykulem', 'Podstawa prawna z artykułem');
    }

    public function akty_zmienione()
    {
        return $this->connections_view('akty_zmienione', 'Akty zmienione');
    }

    public function akty_wykonawcze()
    {
        return $this->connections_view('akty_wykonawcze', 'Akty wykonawcze');
    }

    public function akty_uchylone()
    {
        return $this->connections_view('akty_uchylone', 'Akty uchylone');
    }

    public function akty_uznane_za_uchylone()
    {
        return $this->connections_view('akty_uznane_za_uchylone', 'Akty uznane za uchylone');
    }

    public function orzeczenie_do_aktu()
    {
        return $this->connections_view('orzeczenie_do_aktu', 'Orzeczenia do aktu');
    }

    public function tekst_jednolity_do_aktu()
    {
        return $this->connections_view('tekst_jednolity_do_aktu', 'Tekst jednolity do aktu');
    }

    public function orzeczenie_tk()
    {
        return $this->connections_view('orzeczenie_tk', 'Orzeczenia TK');
    }

    public function informacja_o_tekscie_jednolitym()
    {
        return $this->connections_view('informacja_o_tekscie_jednolitym', 'Informacje o tekście jednolitym');
    }

    public function akty_zmieniajace()
    {
        return $this->connections_view('akty_zmieniajace', 'Akty zmieniające');
    }

    public function akty_uchylajace()
    {
        return $this->connections_view('akty_uchylajace', 'Akty uchylające');
    }

    public function uchylenia_wynikajace_z()
    {
        return $this->connections_view('uchylenia_wynikajace_z', 'Uchylenia wynikające z');
    }

    public function dyrektywy_europejskie()
    {
        return $this->connections_view('dyrektywy_europejskie', 'Dyrektywy europejskie');
    }

    public function odeslania()
    {
        return $this->connections_view('odeslania', 'Odesłania');
    }


    public function beforeRender()
    {

		parent::beforeRender();
		
        $counters_dictionary = array();


        // PREPARE MENU
        $href_base = '/dane/prawo/' . $this->request->params['id'];

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Aktualności',
                    'icon' => 'glyphicon glyphicon-feed',
                ),
                array(
                    'id' => 'tresc',
                    'href' => $href_base . '/tresc',
                    'label' => 'Treść',
                    'icon' => 'glyphicon glyphicon-align-left',
                ),
            )
        );


        if ($items = $this->object->getLayer('counters')) {

            $dropdowns = array();

            foreach ($items as $item) {

                $counters_dictionary[$item['slug']] = $item['count'];

                if ($item['count']) {

                    $dropdowns[] = array(
                        'id' => $item['slug'],
                        'href' => $href_base . '/' . $item['slug'],
                        'label' => $item['nazwa'],
                        'count' => $item['count'],
                    );

                }

            }

            if (!empty($dropdowns)) {

                $menu['items'][] = array(
                    'id' => 'more',
                    'label' => 'Powiązane akty',
                    'dropdown' => array(
                        'items' => $dropdowns,
                    ),
                );

            }
            

        }

        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];

        $this->set('counters_dictionary', $counters_dictionary);
        $this->set('_menu', $menu);

    }

} 