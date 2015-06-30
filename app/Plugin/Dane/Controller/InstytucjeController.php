<?php

App::uses('DataobjectsController', 'Dane.Controller');

class InstytucjeController extends DataobjectsController
{
    public $dataFeedFilters = array(
        array('title' => 'Wszystko', 'icon' => 'all', 'link' => ''),
        array('title' => 'Odpowiedzi na interpelacje', 'icon' => 'interpelacje_odpowiedzi', 'link' => '#'),
        array('title' => 'Otrzymane interpelacje', 'icon' => 'interpelacje_otrzymane', 'link' => '#'),
        array('title' => 'Zamówienia publiczne', 'icon' => 'zamowienia_otrzymane', 'link' => '#'),
        array('title' => 'Zamówienia publiczne', 'icon' => 'zamowienia_otrzymane', 'link' => '#'),
        array('title' => 'Opublikowany tweet', 'icon' => 'twitter_opublikowane', 'link' => '#'),
    );

    public $observeOptions = true;
    public $objectModerable = true;
    
    public $loadChannels = true;
    public $initLayers = array();

    public function view()
    {

        $this->_prepareView();

        $global_aggs = array(
            'prawo' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'prawo',
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 3,
                            'fielddata_fields' => array('dataset', 'id'),
                            'sort' => array(
                                'date' => array(
                                    'order' => 'desc',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'prawo_urzedowe' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'prawo_urzedowe',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.prawo_urzedowe.instytucja_id' => $this->request->params['id'],
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 3,
                            'fielddata_fields' => array('dataset', 'id'),
                            'sort' => array(
                                'date' => array(
                                    'order' => 'desc',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'zamowienia' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne',
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'top' => array(
                        'top_hits' => array(
                            'size' => 3,
                            'fielddata_fields' => array('dataset', 'id'),
                            'sort' => array(
                                'date' => 'desc',
                            ),
                        ),
                    ),
                ),
            ),
            'dokumenty' => array(
                'filter' => array(
                    'bool' => array(
                        'must' => array(
                            array(
                                'term' => array(
                                    'dataset' => 'zamowienia_publiczne_dokumenty',
                                ),
                            ),
                            array(
                                'term' => array(
                                    'data.zamowienia_publiczne_dokumenty.typ_id' => '3',
                                ),
                            ),
                            array(
                                'range' => array(
                                    'date' => array(
                                        'gt' => 'now-1y'
                                    ),
                                ),
                            ),
                            array(
                                'nested' => array(
                                    'path' => 'feeds_channels',
                                    'filter' => array(
                                        'bool' => array(
                                            'must' => array(
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.dataset' => 'instytucje',
                                                    ),
                                                ),
                                                array(
                                                    'term' => array(
                                                        'feeds_channels.object_id' => $this->request->params['id'],
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
                'aggs' => array(
                    'wykonawcy' => array(
                        'nested' => array(
                            'path' => 'zamowienia_publiczne-wykonawcy',
                        ),
                        'aggs' => array(
                            'id' => array(
                                'terms' => array(
                                    'field' => 'zamowienia_publiczne-wykonawcy.id',
                                    'order' => array(
                                        'cena' => 'desc',
                                    ),
                                    'size' => 3,
                                ),
                                'aggs' => array(
                                    'nazwa' => array(
                                        'terms' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.nazwa',
                                        ),
                                    ),
                                    'miejscowosc' => array(
                                        'terms' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.miejscowosc',
                                        ),
                                    ),
                                    'cena' => array(
                                        'sum' => array(
                                            'field' => 'zamowienia_publiczne-wykonawcy.cena',
                                        ),
                                    ),
                                    'dokumenty' => array(
                                        'reverse_nested' => '_empty',
                                        'aggs' => array(
                                            'top' => array(
                                                'top_hits' => array(
                                                    'size' => 3,
                                                    'fielddata_fields' => array('dataset', 'id'),
                                                    'sort' => array(
                                                        'zamowienia_publiczne-wykonawcy.cena' => 'desc',
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );


        $options = array(
            'searchTitle' => 'Szukaj w ' . $this->object->getTitle() . '...',
            'conditions' => array(
                '_object' => 'gminy.' . $this->object->getId(),
            ),
            'cover' => array(
                'view' => array(
                    'plugin' => 'Dane',
                    'element' => 'instytucje/cover',
                ),
                'aggs' => array(
                    'all' => array(
                        'global' => '_empty',
                        'aggs' => $global_aggs,
                    ),
                ),
            ),
            'aggs' => array(
                'dataset' => array(
                    'terms' => array(
                        'field' => 'dataset',
                    ),
                    'visual' => array(
                        'label' => 'Zbiory danych',
                        'skin' => 'datasets',
                        'class' => 'special',
                        'field' => 'dataset',
                        'dictionary' => array(
                            'prawo_wojewodztwa' => array('prawo', 'Prawo lokalne'),
                            'zamowienia_publiczne' => array('zamowienia_publiczne', 'Zamówienia publiczne'),
                        ),
                    ),
                ),
            ),
        );

        $this->Components->load('Dane.DataBrowser', $options);

    }

    public function getMenu()
    {

        $object = $this->object;

        $menu = array(
            'items' => array(),
            'base' => $this->object->getUrl(),
        );

        $menu['items'][] = array(
            'label' => 'Dane',
        );

        $menu['items'][] = array(
            'label' => 'Akty prawne',
            'id' => 'prawo',
        );

        $menu['items'][] = array(
            'label' => 'Dziennik urzędowy',
            'id' => 'dziennik',
        );

        $menu['items'][] = array(
            'label' => 'Zamówienia publiczne',
            'id' => 'zamowienia',
        );

        $menu['items'][] = array(
            'label' => 'Urzędnicy',
            'id' => 'urzednicy',
        );

        return $menu;

    }

    public function instytucje()
    {

        parent::load();
        $this->request->params['action'] = 'instytucje';

    }

    public function prawo()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo',
                '_feed' => array(
                    'dataset' => 'instytucje',
                    'object_id' => $this->object->getId(),
                ),
            ),
        ));

        $this->set('title_for_layout', "Akty prawne wydane przez " . $this->object->getTitle());

    }

    public function dziennik()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'prawo_urzedowe',
                'prawo_urzedowe.instytucja_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Dziennik urzędowy " . $this->object->getTitle());

    }

    public function tweety()
    {
        parent::load();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.twitter:' . $this->object->getId(),
            'dataset' => 'twitter',
            'noResultsTitle' => 'Brak tweetów',
            'title' => 'Tweety',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
            'excludeFilters' => array(
                'twitter_accounts.id', 'twitter_accounts.typ_id'
            ),
        ));

        $this->set('title_for_layout', "Tweety napisane przez " . $this->object->getTitle());

    }

    public function zamowienia()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'zamowienia_publiczne',
                '_feed' => array(
                    'dataset' => 'instytucje',
                    'object_id' => $this->object->getId(),
                ),
            ),
        ));

        $this->set('title_for_layout', "Zamówienia publiczne udzielone przez " . $this->object->getTitle());
    }

    public function urzednicy()
    {

        parent::load();
        $this->Components->load('Dane.DataBrowser', array(
            'conditions' => array(
                'dataset' => 'urzednicy',
                'urzednicy.instytucja_id' => $this->object->getId(),
            ),
        ));

        $this->set('title_for_layout', "Urzędnicy pracujący dla " . $this->object->getTitle());
    }

    public function budzet()
    {

        $this->addInitLayers(array('budzet'));

        parent::load();
        $this->set('title_for_layout', "Budżet " . $this->object->getTitle());

        $this->render('budzet');
    }

    public function beforeRender()
    {

        if ($this->object->getId() == 3214) {
            $this->headerObject = array('url' => '/dane/img/headers/sejmometr.jpg', 'height' => '250px');
        } else {
            $this->headerObject = array('url' => '/dane/img/headers/instytucje.jpg', 'height' => '250px');
        }


        $this->addons = array(
            'wniosek_udostepnienie' => array(
                'adresat_id' => $this->object->getDataset() . ':' . $this->object->getId(),
                'szablon_id' => 35,
                'nazwa' => 'Wyślij wniosek o udostępnienie informacji publicznej',
                'opis' => 'Masz pytania dotyczące działalności tej instytucji? Kliknij, aby wysłać odpowiedni wniosek.',
            )
        );

        if ($this->object->getData('email')) {

            $this->actions = array(
                'pismo' => array(
                    'adresat_id' => $this->object->getDataset() . ':' . $this->object->getId(),
                    'szablon_id' => 35,
                    'nazwa' => 'Wyślij wniosek o udostępnienie informacji publicznej',
                    'opis' => 'Masz pytania dotyczące działalności tej instytucji? Kliknij, aby wysłać odpowiedni wniosek.',
                ),
            );

        }

        parent::beforeRender();
    }

} 