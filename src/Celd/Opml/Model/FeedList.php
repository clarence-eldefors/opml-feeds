<?php
namespace Celd\Opml\Model;

/**
 * Representation of the base of the OPML. Holds feeds or categories at the root.
 * @package Celd\Opml\Model
 */

class FeedList {
    protected $title = '';
    protected $items = array();

    public function addItem($item) {
        $this->items[] = $item;
    }

    /**
     * Gets all items in the list.
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


}