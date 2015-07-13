<?php
/**
 * Created by PhpStorm.
 * User: adamciezkowski
 * Date: 03/12/13
 * Time: 13:21
 */

namespace MP\Lib;


class Twitter_tags extends DataObject
{
	
	protected $tiny_label = 'Twitter Tag';
	
    public function getLabel()
    {
        return 'Hashtag w tweetach posłów';
    }

    public function getTitle()
    {
        return $this->getShortTitle();
    }

    public function getShortTitle()
    {
        return $this->getData('tag');
    }
    
    public function hasHighlights()
    {
        return false;
    }
} 