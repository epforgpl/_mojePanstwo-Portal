<?php

App::uses('AdminAppController', 'Admin.Controller');

class NewsController extends AdminAppController {

    private static $perPage = 20;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('action', 'news');
    }

    public function index() {
        $page = isset($this->request->query['page']) ?
            (int) $this->request->query['page'] : 0;

        $q = isset($this->request->query['q']) ?
            $this->request->query['q'] : false;

        $conditions = array();
        if($q) {
            $conditions['or'] = array(
                array('id LIKE' => "%$q%"),
                array('name LIKE' => "%$q%"),
            );
            $this->set('q', $q);
        }

        $this->loadModel('Admin.News');
        $count = $this->News->find('count', array(
                'conditions' => $conditions
            )
        );

        $this->set('page', $page);
        $this->set('pages', ceil($count / self::$perPage));
        $this->set('rows', $this->News->find('all', array(
            'fields' => 'id, crawler_page_id, name, user_id, created_at, updated_at',
            'conditions' => $conditions,
            'order' => 'created_at DESC',
            'limit' => self::$perPage,
            'offset' => $page * self::$perPage
        )));
    }

    public function add($crawler_page_id = 0) {
        if(isset($this->request->data['name'])) {
            $this->loadModel('Admin.News');
            $news = $this->News->save($this->request->data);
            if($news) {
                $this->Session->setFlash('Aktualność została poprawnie zapisana', 'default');
                $this->redirect('/admin/news');
            }
        }

        if($crawler_page_id > 0) {
            $this->loadModel('Admin.CrawlerPage');
            $crawlerPage = $this->CrawlerPage->find('first', array(
                'conditions' => array(
                    'CrawlerPage.id' => (int) $crawler_page_id
                ),
                'joins' => array(
                    array(
                        'table' => 'crawler_sites',
                        'alias' => 'CrawlerSite',
                        'type' => 'INNER',
                        'conditions' => array(
                            'CrawlerSite.id = CrawlerPage.site_id'
                        )
                    )
                ),
                'fields' => array('CrawlerPage.*', 'CrawlerSite.*'),
            ));

            if(!$crawlerPage)
                throw new NotFoundException;

            $this->set('crawlerPage', $crawlerPage);
        }
    }

    public function edit($id = 0) {
        $this->loadModel('Admin.News');
        $news = $this->News->find('first', array(
            'conditions' => array(
                'id' => (int) $id
            )
        ));

        if(!$news)
            throw new NotFoundException;

        if(isset($this->request->data['name'])) {
            $news = $this->News->save($this->request->data);
            if($news) {
                $this->Session->setFlash('Aktualność została poprawnie zapisana', 'default');
                $this->redirect('/admin/news');
            }
        }

        if($news['News']['crawler_page_id'] > 0) {
            $this->loadModel('Admin.CrawlerPage');
            $crawlerPage = $this->CrawlerPage->find('first', array(
                'conditions' => array(
                    'CrawlerPage.id' => (int) $news['News']['crawler_page_id']
                ),
                'joins' => array(
                    array(
                        'table' => 'crawler_sites',
                        'alias' => 'CrawlerSite',
                        'type' => 'INNER',
                        'conditions' => array(
                            'CrawlerSite.id = CrawlerPage.site_id'
                        )
                    )
                ),
                'fields' => array('CrawlerPage.*', 'CrawlerSite.*'),
            ));

            if(!$crawlerPage)
                throw new NotFoundException;

            $this->set('crawlerPage', $crawlerPage);
        }

        $this->set('news', $news);
    }

    public function delete($id = 0) {
        $this->loadModel('Admin.News');
        $news = $this->News->find('first', array(
            'conditions' => array(
                'id' => (int) $id
            )
        ));

        if(!$news)
            throw new NotFoundException;

        $this->News->delete($id);
        $this->Session->setFlash('Aktualność została poprawnie usunięta', 'default');
        $this->redirect('/admin/news');
    }

}