<?php
namespace Celd\Opml\Model;

/**
 * Representation of an OPML outline without type (category or label)
 * Contains all feeds in given category.
 *
 * @package Celd\Opml\Model
 */
class Category {
    protected $type = 'category';

    protected $title;

    protected $feeds = array();

    /**
     * @param Feed $feed
     */
    public function addFeed(Feed $feed)
    {
        $this->feeds[] = $feed;
    }

    /**
     * @return array
     */
    public function getFeeds()
    {
        return $this->feeds;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}