<?php
namespace Celd\Opml\Model;

/**
 * Representation of an outline with a type (ie Atom or RSS)
 *
 * @package Celd\Opml\Model
 */
class Feed {
    protected $type = 'feed';
    protected $title;
    protected $xmlUrl;
    protected $htmlUrl;

    /**
     * @param mixed $htmlUrl
     */
    public function setHtmlUrl($htmlUrl)
    {
        $this->htmlUrl = $htmlUrl;
    }

    /**
     * @return mixed
     */
    public function getHtmlUrl()
    {
        return $this->htmlUrl;
    }

    /**
     * @param mixed $title
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
     * @param mixed $xmlUrl
     */
    public function setXmlUrl($xmlUrl)
    {
        $this->xmlUrl = $xmlUrl;
    }

    /**
     * @return mixed
     */
    public function getXmlUrl()
    {
        return $this->xmlUrl;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Loads a symfony2 decoded opml feed into the model.
     *
     * @param $item
     */
    public function fromArray($item) {
        $this->setTitle($item['@title']);
        $this->setXmlUrl($item['@xmlUrl']);
        $this->setHtmlUrl($item['@htmlUrl']);
        $this->setType($item['@type']);
    }
}