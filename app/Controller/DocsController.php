<?php

class DocsController extends AppController
{

    public $components = array('RequestHandler', 'S3');

    public function view()
    {

        App::import("Model", "Document");
        $Document = new Document();

        $doc = $Document->load($this->request->params['id'], false);
        $this->set('doc', $doc);
        $this->set('_serialize', 'doc');

        $this->set('title_for_layout', $doc['Document']['filename']);

        if ($this->hasUserRole('2')) {
            $isAdmin = true;
        } else {
            $isAdmin = false;
        }

        $this->set('isAdmin', $isAdmin);
        if (isset($this->request->params['ext']) && in_array($this->request->params['ext'], array('html', 'htm'))) {
            $this->layout = 'doc';
            $this->render('view-html');
        }

    }

    public function edit()
    {

        App::import("Model", "Document");
        $Document = new Document();

        $doc = $Document->load($this->request->params['id'], false);

        $this->set('doc', $doc);
        $this->set('_serialize', 'doc');

        $bookmarks = $Document->loadBookmarks($this->request->params['id']);
        $book = array();
        foreach ($bookmarks['bookmarks'] as $bookmark) {
            $book[$bookmark['Bookmark']['strona_numer_hex']] = array(
                'id' => $bookmark['Bookmark']['id'],
                'tytul' => $bookmark['Bookmark']['tytul'],
                'opis' => $bookmark['Bookmark']['opis'],
            );
        }
        $this->set('bookmarks', $book);

        $this->set('title_for_layout', $doc['Document']['filename']);

        if (!$this->hasUserRole('2')) {
            $this->redirect('' . $this->request->params['id']);
        }

        if (isset($this->request->params['ext']) && in_array($this->request->params['ext'], array('html', 'htm'))) {
            $this->layout = 'doc';
            $this->render('view-html');
        }

    }

    public function download()
    {

        $this->loadModel('Document');
        $doc = $this->Document->load($this->request->params['id']);
        $this->redirect($doc['Document']['url']);

    }
    
    public function stream()
    {
	    $id = $this->request->params['id'];
	    $url = 'http://docs.sejmometr.pl/pdf/' . $id . '.pdf';
	    if(
	    	( $headers = get_headers($url) ) && 
	    	isset($headers[0]) && 
	    	( stripos($headers[0], '200 Ok') )
	    ) {
			// do nothing		    
	    } else {
		    $url = 'http://docs.sejmometr.pl/originals/' . $id;
	    }
	    
        header('Content-Type: application/pdf');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {
            echo $data;
            return strlen($data);
        });
        curl_exec($ch);
        curl_close($ch);
    }

    public function viewPackage()
    {

        $doc_id = $this->request->params['doc_id'];
        $package_id = $this->request->params['package_id'];

        $doc = new MP\Document($doc_id);
        $html = $doc->loadHTML($package_id);

        $ext = strtolower($this->request->params['ext']);

        if ($ext == 'html') {

            echo $html;
            die();

        } elseif ($ext == 'json') {

            $this->set('doc', $doc->getData());
            $this->set('html', $html);
            $this->set('_serialize', array('doc', 'html'));

        }

    }

    public function save_doc()
    {
        $this->loadModel('Document');

        $data = array(
            'pages' => array(),
            'bookmarks' => array()
        );

        $dane = json_decode($this->request->data['dane']);
        $dane = (array)$dane;
        $id = $dane['document_id'];
/*
        if (isset($dane['pages'])) {
            $pages = (array)$dane['pages'];
            foreach ($pages as $page) {
                $page = (array)$page;
                $page['dokument_id'] = $id;
                $data['pages'][] = $page;
            }
        }*/
        if (isset($dane['bookmarks'])) {
            $bookmarks = (array)$dane['bookmarks'];
            foreach ($bookmarks as $bookmark) {
                $bookmark = (array)$bookmark;
                $bookmark['source_dokument_id'] = $id;
                $bookmark['strona_start'] = hexdec($bookmark['strona_numer_hex']);
                $data['bookmarks'][] = $bookmark;
            }
        }
        $msg = $this->Document->save_document($data, $id);


        $this->set(
            array('message' => $msg,
                '_serialize' => array('message')
            ));
    }

    public function extract_budget_spendings()
    {


        App::import("Model", "Document");
        $Document = new Document();

        $id = $Document->doc_id_from_attach($this->request->params['id']);
        $doc = $Document->load($id['doc_id'], false);

        $xml = $this->S3->getObject('docs.sejmometr.pl', 'xml/' . $id['doc_id'] . '.xml');

        $xml = strip_tags($xml->body, '<page><text>');
        $xml = str_ireplace(array(
            '<page', '<text', '/text>', '/page>'
        ), array(
            '<div class="page"', '<p', '/p>', '/div>'
        ), $xml);

        $this->set('doc', $doc);
        $this->set('xml', $xml);
        $this->set('_serialize', 'doc');

        $this->set('title_for_layout', $doc['Document']['filename']);


        if ($this->hasUserRole('2')) {
            $isAdmin = true;
        } else {
            $this->redirect('' . $this->request->params['id']);
        }

        $this->set('isAdmin', $isAdmin);

        if (isset($this->request->params['ext']) && in_array($this->request->params['ext'], array('html', 'htm'))) {
            $this->layout = 'doc';
            $this->render('view-html');
        } else {
            $this->render('attachment');
        }
    }

    public function save_budget_spendigns()
    {
        $this->autoRender = false;
        $dane = json_decode($this->request->data['dane']);

        $data = array();
        foreach ($dane as $page) {
            $strona = array();
            foreach ($page as $nr_strony => $pole) {
                    if (!isset($strona[$pole[1]])) {
                        $strona[$pole[1]] = array();
                    }
                    $strona[$pole[1]]['rocznik'] = '2012';

                    switch ($pole[0]) {
                        case 1:
                            //czesc_str
                            $strona[$pole[1]]['czesc_str'] = $pole[2];
                            $strona[$pole[1]]['type'] = 'czesc';
                            break;
                        case 2:
                            //dzial_str
                            $strona[$pole[1]]['dzial_str'] = $pole[2];
                            $strona[$pole[1]]['type'] = 'dzial';
                            break;
                        case 3:
                            //tresc
                            if (isset($strona[$pole[1]]['tresc'])) {
                                $strona[$pole[1]]['tresc'] .= $pole[2];
                            } else {
                                $strona[$pole[1]]['tresc'] = $pole[2];
                            }
                            break;
                        case 4:
                            //pozycja
                            $strona[$pole[1]]['pozycja'] = $pole[2];
                            break;
                        case 5:
                            //plan
                            if (isset($strona[$pole[1]]['plan'])) {
                                $strona[$pole[1]]['plan'] .= $pole[2];
                            } else {
                                $strona[$pole[1]]['plan'] = $pole[2];
                            }
                            $strona[$pole[1]]['plan'] = str_replace(' ', '', $strona[$pole[1]]['plan']);
                            break;
                    }
            }
            $data = array_merge($data, $strona);
        }

        $this->loadModel('Document');
        $aa = $this->Document->save_budget(json_encode($data));


        echo '<pre>';
        var_export($aa);
        echo '</pre>';

        /*
                $data = array();
                foreach ($dane as $page) {
                    $strona = array();
                    foreach ($page as $nr_strony => $pole) {
                        if ($pole[1] == 1) {
                            continue;
                        } else {
                            if (!isset($strona[$pole[1]])) {
                                $strona[$pole[1]] = array();
                            }
                            $strona[$pole[1]]['rocznik'] = '2012';

                            switch ($pole[0]) {
                                case 1:
                                    //czesc_str
                                    $strona[$pole[1]]['czesc_str'] = $pole[2];
                                    $strona[$pole[1]]['type'] = 'czesc';
                                    break;
                                case 2:
                                    //dzial_str
                                    $strona[$pole[1]]['dzial_str'] = $pole[2];
                                    $strona[$pole[1]]['type'] = 'dzial';
                                    break;
                                case 3:
                                    //rozdzial_str
                                    $strona[$pole[1]]['rozdzial_str'] = $pole[2];
                                    $strona[$pole[1]]['type'] = 'rozdzial';
                                    break;
                                case 4:
                                    //tresc
                                    if (isset($strona[$pole[1]]['tresc'])) {
                                        $strona[$pole[1]]['tresc'] .= $pole[2];
                                    } else {
                                        $strona[$pole[1]]['tresc'] = $pole[2];
                                    }
                                    break;
                                case 5:
                                    //pozycja
                                    $strona[$pole[1]]['pozycja'] = $pole[2];
                                    break;
                                case 6:
                                    //plan
                                    if (isset($strona[$pole[1]]['plan'])) {
                                        $strona[$pole[1]]['plan'] .= $pole[2];
                                    } else {
                                        $strona[$pole[1]]['plan'] = $pole[2];
                                    }
                                    $strona[$pole[1]]['plan'] = str_replace(' ', '', $strona[$pole[1]]['plan']);
                                    break;
                                case 7:
                                    if (isset($strona[$pole[1]]['dotacje_i_subwencje'])) {
                                        $strona[$pole[1]]['dotacje_i_subwencje'] .= $pole[2];
                                    } else {
                                        $strona[$pole[1]]['dotacje_i_subwencje'] = $pole[2];
                                    }
                                    //dotacje i subwencje
                                    $strona[$pole[1]]['dotacje_i_subwencje'] = str_replace(' ', '', $strona[$pole[1]]['dotacje_i_subwencje']);
                                    break;
                                case 8:
                                    if (isset($strona[$pole[1]]['swiadczenia_na_rzecz_osob_fizycznych'])) {
                                        $strona[$pole[1]]['swiadczenia_na_rzecz_osob_fizycznych'] .= $pole[2];
                                    } else {
                                        $strona[$pole[1]]['swiadczenia_na_rzecz_osob_fizycznych'] = $pole[2];
                                    }
                                    //swiadczenia na rzecz osob fizycznych
                                    $strona[$pole[1]]['swiadczenia_na_rzecz_osob_fizycznych'] = str_replace(' ', '', $strona[$pole[1]]['swiadczenia_na_rzecz_osob_fizycznych']);
                                    break;
                                case 9:
                                    if (isset($strona[$pole[1]]['wydatki_biezace_jednostek_budzetowych'])) {
                                        $strona[$pole[1]]['wydatki_biezace_jednostek_budzetowych'] .= $pole[2];
                                    } else {
                                        $strona[$pole[1]]['wydatki_biezace_jednostek_budzetowych'] = $pole[2];
                                    }
                                    //wydatki biezace jednostek budzetowych
                                    $strona[$pole[1]]['wydatki_biezace_jednostek_budzetowych'] = str_replace(' ', '', $strona[$pole[1]]['wydatki_biezace_jednostek_budzetowych']);
                                    break;
                                case 10:
                                    if (isset($strona[$pole[1]]['wydatki_majatkowe'])) {
                                        $strona[$pole[1]]['wydatki_majatkowe'] .= $pole[2];
                                    } else {
                                        $strona[$pole[1]]['wydatki_majatkowe'] = $pole[2];
                                    }
                                    //wydatki majatkowe
                                    $strona[$pole[1]]['wydatki_majatkowe'] = str_replace(' ', '', $strona[$pole[1]]['wydatki_majatkowe']);
                                    break;
                                case 11:
                                    //wydatki na osbluge dlugu
                                    $strona[$pole[1]]['wydatki_na_obsluge_dlugu'] = str_replace(' ', '', $pole[2]);
                                    break;
                                case 12:
                                    //srodki wlasne ue
                                    $strona[$pole[1]]['srodki_wlasne_ue'] = str_replace(' ', '', $pole[2]);
                                    break;
                                case 13:
                                    //wspolfinansowanie ue
                                    $strona[$pole[1]]['wspolfinansowanie_ue'] = str_replace(' ', '', $pole[2]);
                                    break;
                            }
                        }
                    }
                    $data = array_merge($data, $strona);
                }

                $this->loadModel('Document');
                $aa = $this->Document->save_budget(json_encode($data));


                echo '<pre>';
                 //var_export($data);
                var_export($aa['data']);
                // var_export(json_encode($data));
                echo '</pre>';
            */
    }
}
