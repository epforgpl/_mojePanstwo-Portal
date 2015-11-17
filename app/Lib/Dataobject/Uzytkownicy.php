<?php

namespace MP\Lib;

class Uzytkownicy extends DataObject {

    protected $tiny_label = 'Użytkownicy';

    protected $routes = array(
        'title' => 'username',
        'shortTitle' => 'username',
    );

    public function getLabel() {
        return 'Użytkownik';
    }

    public function getUrl() {
        return '/dane/uzytkownicy/' . $this->getId();
    }

    public function getThumbnailUrl($size = '2') {
        return false;
    }

    public function getDescription() {
        return '';
    }

    public function getMetaDescriptionParts($preset = false) {
        return array();
    }

    public function getDefaultColumnsSizes() {
        return array(4, 8);
    }

    public function getSlug() {
        return '';
    }

}