<?php

App::uses('DataobjectsController', 'Dane.Controller');

class InstytucjeController extends DataobjectsController
{
    public $menu = array();
    public $initLayers = array('instytucja_nadrzedna', 'tree', 'menu', 'info');

    public function view()
    {

        parent::_prepareView();

        if ($this->object->getData('file') == '1')
            $this->prepareFeed();

    }

    public function instytucje()
    {

        parent::_prepareView();
        $this->request->params['action'] = 'instytucje';

    }

    public function prawo()
    {
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.prawo:' . $this->object->getId(),
            'dataset' => 'prawo',
            'noResultsTitle' => 'Brak aktów prawnych',
            'excludeFilters' => array(
                'autor_id',
            ),
            'title' => 'Akty prawne',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
        ));

        $this->set('title_for_layout', "Akty prawne wydane przez " . $this->object->getTitle());

    }

    public function tweety()
    {
        parent::_prepareView();
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
        parent::_prepareView();
        $this->dataobjectsBrowserView(array(
            'source' => 'instytucje.zamowienia_udzielone:' . $this->object->getId(),
            'dataset' => 'zamowienia_publiczne',
            'noResultsTitle' => 'Brak zamówień',
            'title' => 'Zamówienia publiczne',
            'back' => $this->object->getUrl(),
            'backTitle' => $this->object->getTitle(),
            'hiddenFilters' => array('zamowienia_publiczne.zamawiajacy_id', 'zamowienia_publiczne.data_publikacji'),
            'excludeFilters' => array('zamowienia_publiczne.gmina_id'),
        ));

        $this->set('title_for_layout', "Zamówienia publiczne udzielone przez " . $this->object->getTitle());
    }

    public function budzet()
    {

        $this->addInitLayers(array('budzet'));

        parent::_prepareView();
        $this->set('title_for_layout', "Budżet " . $this->object->getTitle());

        $this->render('budzet');
    }

    public function beforeRender()
    {

        // debug( $this->object->getLayer('menu') ); die();

        $_menu = $this->object->getLayer('menu');

        // PREPARE MENU
        $href_base = '/dane/instytucje/' . $this->request->params['id'];

        $menu = array(
            'items' => array(
                array(
                    'id' => '',
                    'href' => $href_base,
                    'label' => 'Aktualności',
                    'icon' => 'glyphicon glyphicon-feed',
                ),
            )
        );

        if (isset($_menu['budzet_czesci']) && !empty($_menu['budzet_czesci'])) {
            $menu['items'][] = array(
                'id' => 'budzet',
                'href' => $href_base . '/budzet',
                'label' => 'Budżet',
            );
        }

        if ($this->object->getData('liczba_instytucji')) {

            $menu['items'][] = array(
                'id' => 'instytucje',
                'href' => $href_base . '/instytucje',
                'label' => 'Instytucje nadzorowane',
            );

        }

        $items = array();

        if (isset($_menu['zamowienia_udzielone']) && !empty($_menu['zamowienia_udzielone'])) {
            $items['items'][] = array(
                'id' => 'zamowienia',
                'href' => $href_base . '/zamowienia',
                'label' => 'Zamówienia publiczne',
            );
        }

        if (isset($_menu['prawo']) && $_menu['prawo']) {
            $items['items'][] = array(
                'id' => 'prawo',
                'href' => $href_base . '/prawo',
                'label' => 'Akty prawne',
            );
        }

        if ($this->object->getData('twitter_account_id')) {
            $items['items'][] = array(
                'id' => 'tweety',
                'href' => $href_base . '/tweety',
                'label' => 'Tweety',
            );
        }

        if (!empty($items)) {
            $menu['items'][] = array(
                'id' => 'dane',
                'label' => 'Dane',
                'dropdown' => $items,
            );
        }


        $menu['selected'] = ($this->request->params['action'] == 'view') ? '' : $this->request->params['action'];

        $this->set('_menu', $menu);


    }

} 