<?php

App::uses('DataobjectsController', 'Dane.Controller');

class PoslowieController extends DataobjectsController
{

    public $components = array(
        'RequestHandler',
    );

    public $menu = array();
    public $breadcrumbsMode = 'app';

    public $objectOptions = array(
        'hlFields' => array(),
    );

    public $headerObject = array('url' => '/dane/img/headers/poslowie.jpg', 'height' => '250px');

    public function view()
    {
        return $this->feed();
    }


    public function twitter()
    {

        $this->load();

        if (
            $this->object->getData('twitter_account_id') &&
            ($twitter_account = $this->Dataobject->find('first', array(
                'conditions' => array(
                    'dataset' => 'twitter_accounts',
                    'id' => $this->object->getData('twitter_account_id'),
                ),
                'layers' => array('followers_chart'),
            )))
        ) {

            $this->set('twitter_account', $twitter_account);

            $this->set('twitts', $this->Dataobject->find('all', array(
                'conditions' => array(
                    'dataset' => 'twitter',
                    'twitter.twitter_account_id' => $twitter_account->getId(),
                ),
                'limit' => 12,
            )));

        } else {
            $this->redirect('/dane/poslowie/' . $this->object->getId());
        }

    }

    public function wyjazdy7()
    {

        $this->addInitLayers(array('wyjazdy7'));
        parent::view();

        $this->set('title_for_layout', "Wyjazdy zagraniczne " . $this->object->getData('dopelniacz'));

    }
    
    public function wyjazdy()
    {

        $this->addInitLayers(array('wyjazdy'));
        parent::view();

        $this->set('title_for_layout', "Wyjazdy zagraniczne " . $this->object->getData('dopelniacz'));

    }


    public function wydatki()
    {

        $this->addInitLayers(array('wydatki'));
        $this->load();

        $wydatki = $this->object->getLayer('wydatki');
        $rok = @$this->request->params['subid'];


        if ($rok && ($roczniki = $wydatki['roczniki'])) {

            $founded = false;

            foreach ($roczniki as $rocznik) {
                if ($rocznik['rok'] == $rok) {
                    $founded = true;
                    break;
                }
            }

            if (!$founded) {
                $this->redirect('/dane/poslowie/' . $this->object->getId() . '/wydatki');
            }

            $this->set(array(
                'rocznik' => $rocznik,
                'title_for_layout' => 'Wydatki biura ' . $this->object->getData('dopelniacz') . ' w ' . $rok . ' roku',
            ));
            $this->render('wydatki_rok');

        } else {

            $this->set('title_for_layout', $this->object->getData('nazwa') . ' | Informacje finansowe');

        }

    }

    public function oswiadczenia_majatkowe()
    {

        $this->load();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'poslowie_oswiadczenia_majatkowe',
                'poslowie_oswiadczenia_majatkowe.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'oswiadczenia_majatkowe',
        ));

        $this->set('title_for_layout', 'Oświadczenia majątkowe ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Oświadczenia majątkowe ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function rejestr_korzysci()
    {

        $this->load();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'poslowie_rejestr_korzysci',
                'poslowie_rejestr_korzysci.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'oswiadczenia_majatkowe',
        ));

        $this->set('title_for_layout', 'Rejestr korzyści ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Rejestr korzyści ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function wspolpracownicy()
    {

        $this->load();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'poslowie_wspolpracownicy',
                'poslowie_wspolpracownicy.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'poslowie_wspolpracownicy',
        ));

        $this->set('title_for_layout', 'Współpracownicy ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Współpracownicy ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function wystapienia()
    {

        parent::load();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sejm_wystapienia',
                'ludzie.id' => $this->object->getData('poslowie.mowca_id'),
            ),
            'aggsPreset' => 'sejm_wystapienia',
        ));

        $this->set('title_for_layout', 'Wystąpienia sejmowe ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Wystąpienia sejmowe ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function interpelacje()
    {
        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sejm_interpelacje',
                'sejm_interpelacje.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'sejm_wystapienia',
        ));

        $this->set('title_for_layout', 'Interpelacje ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Interpelacje ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function prawo_projekty()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $this->set('title_for_layout', 'Projekty podpisane przez ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Projekty podpisane przez ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function projekty_ustaw()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.posel_id' => $this->object->getId(),
                'prawo_projekty.typ_id' => '1',
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $this->set('title_for_layout', 'Projekty ustaw podpisane przez ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Projekty ustaw podpisane przez ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function projekty_uchwal()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.posel_id' => $this->object->getId(),
                'prawo_projekty.typ_id' => '2',
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $this->set('title_for_layout', 'Projekty uchwał podpisane przez ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Projekty uchwał podpisane przez ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function glosowania()
    {

        $this->load();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'poslowie_glosy',
                'poslowie_glosy.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'poslowie_glosy',
        ));

        $this->set('title_for_layout', 'Wyniki głosowań ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Wyniki głosowań ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function prawo_projekty_za()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.poslowie_za' => $this->object->getId(),
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $glosowal_str = ($this->object->getData('plec') == 'K') ? 'głosowała' : 'głosował';

        $this->set('title_for_layout', 'Projekty za którymi ' . $glosowal_str . ' ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Projekty za którymi ' . $glosowal_str . ' ' . $this->object->getData('nazwa'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function prawo_projekty_przeciw()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.poslowie_przeciw' => $this->object->getId(),
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $glosowal_str = ($this->object->getData('plec') == 'K') ? 'głosowała' : 'głosował';

        $this->set('title_for_layout', 'Projekty przeciw którym ' . $glosowal_str . ' ' . $this->object->getData('nazwa'));
        $this->set('DataBrowserTitle', 'Projekty przeciw którym ' . $glosowal_str . ' ' . $this->object->getData('nazwa'));
        $this->render('Dane.DataBrowser/browser');

    }

    public function prawo_projekty_wstrzymanie()
    {
        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.poslowie_wstrzymali' => $this->object->getId(),
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $wstrzymal_str = ($this->object->getData('plec') == 'K') ? 'wstrzymała' : 'wstrzymał';

        $this->set('title_for_layout', 'Projekty nad którymi ' . $this->object->getData('nazwa') . ' ' . $wstrzymal_str . ' się od głosu');
        $this->set('DataBrowserTitle', 'Projekty nad którymi ' . $this->object->getData('nazwa') . ' ' . $wstrzymal_str . ' się od głosu');
        $this->render('Dane.DataBrowser/browser');

    }

    public function prawo_projekty_nieobecnosc()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_projekty',
                'prawo_projekty.poslowie_nieobecni' => $this->object->getId(),
            ),
            'aggsPreset' => 'prawo_projekty',
        ));

        $wstrzymal_str = ($this->object->getData('plec') == 'K') ? 'pojawiła' : 'pojawił';

        $this->set('title_for_layout', 'Projekty dla których ' . $this->object->getData('nazwa') . ' nie ' . $wstrzymal_str . ' się na głosowaniu');
        $this->set('DataBrowserTitle', 'Projekty dla których ' . $this->object->getData('nazwa') . ' nie ' . $wstrzymal_str . ' się na głosowaniu');
        $this->render('Dane.DataBrowser/browser');

    }

    public function komisja_etyki_uchwaly()
    {

        $this->load();

        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'sejm_komisje_uchwaly',
                'sejm_komisje_uchwaly.posel_id' => $this->object->getId(),
            ),
            'aggsPreset' => 'sejm_komisje_uchwaly',
        ));

        $this->set('title_for_layout', 'Uchwały Komisji Etyki wobec ' . $this->object->getData('dopelniacz'));
        $this->set('DataBrowserTitle', 'Uchwały Komisji Etyki wobec ' . $this->object->getData('dopelniacz'));
        $this->render('Dane.DataBrowser/browser');

    }


    public function getMenu()
    {


        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'label' => 'Aktualności',
                    // 'icon' => 'glyphicon glyphicon-feed',
                ),
            ),
            'base' => $this->object->getUrl(),
        );

        /*
        $menu['items'][] = array(
            'id' => 'dane',
            'label' => 'Dane',
            'icon' => 'glyphicon glyphicon-align-justify',
            'dropdown' => array(
                'items' => array(
                    array(
                        'id' => 'wystapienia',
                        'href' => $href_base . '/wystapienia',
                        'label' => 'Wystąpienia',
                    ),
                    array(
                        'id' => 'glosowania',
                        'href' => $href_base . '/glosowania',
                        'label' => 'Wyniki głosowsań',
                    ),
                    array(
                        'id' => 'interpelacje',
                        'href' => $href_base . '/interpelacje',
                        'label' => 'Interpelacje',
                    ),
                    array(
                        'id' => 'wspolpracownicy',
                        'href' => $href_base . '/wspolpracownicy',
                        'label' => 'Współpracownicy',
                        'topborder' => true,
                    ),
                    array(
                        'id' => 'oswiadczenia_majatkowe',
                        'href' => $href_base . '/oswiadczenia_majatkowe',
                        'label' => 'Oświadczenia majątkowe',
                    ),
                    array(
                        'id' => 'rejestr_korzysci',
                        'href' => $href_base . '/rejestr_korzysci',
                        'label' => 'Rejestr korzyści',
                    ),
                ),
            ),
        );
        */

        $menu['items'][] = array(
            'id' => 'wydatki',
            'label' => 'Wydatki',
            // 'icon' => 'glyphicon glyphicon-spendings',
        );

        $menu['items'][] = array(
            'id' => 'wyjazdy',
            'label' => 'Wyjazdy zagraniczne',
            // 'icon' => 'glyphicon glyphicon-travels',
        );

        /*
        if ($this->object->getData('twitter_account_id')) {
            $menu['items'][] = array(
                'id' => 'twitter',
                'label' => 'Twitter',
            );
        }
        */

        return $menu;

    }

}