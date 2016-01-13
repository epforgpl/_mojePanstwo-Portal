<?php

namespace MP\Lib;

class Webpages extends DataObject {

	public $force_hl_fields = true;
    protected $tiny_label = 'Webpages';

    protected $routes = array(
        'title' => 'webpages',
        'shortTitle' => 'webpages',
    );

    public function getLabel() {
        return $this->getData('websites.name');
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

    public function getSlug() {
        return '';
    }

    public function getShortTitle() {
        return $this->getData('webpages.title');
    }
    
    public function getMetaDescriptionParts($preset = false)
	{
				
		$output = array();
		
		$output[] = getDiff( $this->getData('cts'), false );
				
        return $output;

    }

}
