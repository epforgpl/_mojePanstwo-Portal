<?php

App::uses('AdminAppController', 'Admin.Controller');

class NewsController extends AdminAppController {

    public $components = array('Admin.NewsImage');
    private static $perPage = 20;
    private static $areas = array(
        'działalność charytatywna',
        'pomoc społeczna',
        'ochrona praw obywatelskich i praw człowieka',
        'rozwój przedsiębiorczości',
        'nauka, kultura, edukacja',
        'ekologia',
        'działalność międzynarodowa',
        'aktywność społeczna',
        'sport, turystyka',
        'bezpieczeństwo publiczne',
        'inne',
        'uchodźcy'
    );

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

        $this->set('areas', self::$areas);
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
                $this->redirect('/admin/news/edit/' . $id);
            }
        } elseif(isset($this->request->data['image_source'])) {

            $data = array(
                'id' => $id,
                'is_image' => '0',
                'image_source' => $this->request->data['image_source']
            );

            try {
                if(isset($this->request->data['remove_image']) && $this->request->data['remove_image'] == '1') {
                    $this->NewsImage->remove($id);
                    $data['is_image'] = '0';
                } elseif(isset($this->request->params['form']['image'])) {
                    $this->NewsImage->upload($this->request->params['form']['image'], $id);
                    $data['is_image'] = '1';
                }
            } catch(NewsImageComponentException $e) {
                $this->Session->setFlash($e->getMessage(), 'default');
                $this->redirect('/admin/news/edit/' . $id);
            }

            $news = $this->News->save($data);

            $this->Session->setFlash(
                $news ?
                    'Obrazek został poprawnie ' . ($data['is_image'] == '0' ? 'usunięty' : 'zapisany') :
                    'Wystąpił błąd podczas zapisywania obrazka',
                'default'
            );

            $this->redirect('/admin/news/edit/' . $id);
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
                    ),
                ),
                'fields' => array('CrawlerPage.*', 'CrawlerSite.*'),
            ));

            if(!$crawlerPage)
                throw new NotFoundException;

            $this->set('crawlerPage', $crawlerPage);
        }

        $this->set('newsAreas', array_column(array_column(
            $this->News->query("SELECT * FROM news_areas WHERE news_id = " . (int) $id)
            , 'news_areas'), 'area_id'));

        $this->set('tags', array_column(array_column(
            $this->News->query("SELECT tematy.q FROM news_tags INNER JOIN tematy ON tematy.id = news_tags.tag_id WHERE news_tags.news_id = " . (int) $id)
            , 'tematy'), 'q'));

        $this->set('news', $news);
        $this->set('areas', self::$areas);
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

    public function iframe($crawler_page_id = 0) {
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
        $this->layout = false;
        $this->render = false;

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $crawlerPage['CrawlerPage']['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        echo $data;
    }

    private function uploadImage($image, $id) {
        $this->S3 = $this->Components->load('S3');
    }

}