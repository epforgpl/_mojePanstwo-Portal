<?php

namespace MP\Lib;

class News extends DataObject {

    protected $tiny_label = 'Aktualności';

    protected $routes = array(
        'title' => 'news',
        'shortTitle' => 'news',
    );

    public function getLabel() {
        return 'Aktualność';
    }

    public function getUrl() {
        return '/dane/news/' . $this->getId();
    }

    public function getDescription() {
        return $this->getData('description');
    }

    public function getTitleAddon() {
        if($c = $this->getData('created_at')) {
            return 'Dodano ' . getDiff($c, false);
        }

        return false;
    }

    public function getSlug() {
        return '';
    }

    public function getTitle() {
        return $this->getData('name');
    }

    public function getShortTitle() {
        return $this->getData('name');
    }

}
