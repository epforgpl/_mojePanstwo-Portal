<?php

namespace MP\Lib;

class Webpages extends DataObject {

    protected $tiny_label = 'Webpages';

    protected $routes = array(
        'title' => 'webpages',
        'shortTitle' => 'webpages',
    );

    public function getLabel() {
        return 'Webpage';
    }

    public function getUrl() {
        return '/admin/news/add/' . $this->getId();
    }

    public function getThumbnailUrl($size = '2') {
        return 'http://sds.tiktalik.com/crawler/thumbnails/'. $this->getData('version_id') .'.jpg';
    }

    public function getDescription() {
        return $this->getData('title');
    }

    public function getTitleAddon() {
        if($c = $this->getData('cts')) {
            return 'Aktualizowano ' . getDiff($c, false);
        }

        return false;
    }

    public function getSlug() {
        return '';
    }

    public function getTitle() {
        return $this->getData('name');
    }

}
