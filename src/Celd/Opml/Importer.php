<?php
namespace Celd\Opml;

use \Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * Importer handles all the encoding and decoding of OPML feed lists.
 *
 * @package Celd\Opml
 */
class Importer {
    protected $feedList;

    /**
     * Initializes the Importer. Does an import if a string is recieved.
     *
     * @param optional string $data
     */
    public function __construct($data = '') {
        $this->feedList = new Model\FeedList;
        if($data != '') {
            $this->import($data);
        }
    }

    /**
     * Gets the list of feeds.
     * @return Model\FeedList
     */
    public function getFeedList() {
        return $this->feedList;
    }

    /**
     * @param $data String opml data.
     *
     * @throws \UnexpectedValueException
     */
    public function import($data)
    {
        $encoder = new XmlEncoder();
        $data = $encoder->decode($data, 'xml'); // Symfony2 serializer decode function wants a format that is never used ;)

        if(!isset($data['head']['title'])) {
            throw new \UnexpectedValueException('No head->title in data.');
        }

        $this->feedList->setTitle($data['head']['title']);

        if(!isset($data['body']['outline']) || !is_array($data['body']['outline'])) {
            throw new \UnexpectedValueException('No outlines.');
        }

        // If we only have one outline the serializer will put it at the root.
        // We put that outline into an array to handle it the same way.
        if(!isset($data['body']['outline'][0]['@title'])) {
            $data['body']['outline'] = array($data['body']['outline']);
        }

        foreach($data['body']['outline'] as $item) {
            // If the object has an empty type it's a category.
            if(!isset($item['@type']) || $item['@type'] == '') {
                $category = new Model\Category();
                $category->setTitle($item['@title']);

                // If we have only one feed it will be in the root.
                // Put it into to an array so we can handle it the same way.
                if(isset($item['outline']['@title'])) {
                    $item['outline'] = array($item['outline']);
                }

                foreach($item['outline'] as $feedData) {
                    $feed = new Model\Feed();
                    $feed->fromArray($feedData);
                    $category->addFeed($feed);
                }

                $this->feedList->addItem($category);

            } else {
                $feed = new Model\Feed();
                $feed->fromArray($item);
                $this->feedList->addItem($feed);
            }
        }
    }

    protected function createFeedFromArray($array)
    {

    }

    /**
     * Generates an OPMXL document from a given FeedList
     *
     * @TODO : implement a proper template.
     *
     * @param Model\FeedList $feedList
     * @return string opxml document.
     */
    public function export(Model\FeedList $feedList)
    {
        $tab = '    ';
        $return = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL
                . '<opml version="1.0">' . PHP_EOL
                . $tab . '<head>' . PHP_EOL
                . $tab . $tab . '<title>' . $feedList->getTitle() . '</title>' . PHP_EOL
                . $tab . '</head>' . PHP_EOL
                . $tab . '<body>'. PHP_EOL;

        foreach($feedList->getItems() as $item) {
            if ($item->getType() == 'category') {
                $return .= $tab . $tab . '<outline text="'.$item->getTitle().'" title="' . $item->getTitle() .
                    '">' . PHP_EOL;
                foreach($item->getFeeds() as $feed) {
                    $return .= $this->outlineStringFromFeed($feed, 3);
                }
                $return .= $tab . $tab . '</outline>' . PHP_EOL;
            }
            else {
                $return .= $this->outlineStringFromFeed($item);
            }
        }

        $return .= '    </body>'  . PHP_EOL
                 . '</opml>';

        return $return;
    }

    protected function outlineStringFromFeed(Model\Feed $feed, $tabs = 2)
    {
        $tab = '    ';

        $outline =
                 $tab . $tab . '<outline text="'.$feed->getTitle().'" title="' . $feed->getTitle() .
                 '" type="' . $feed->getType() . '" xmlUrl="' . $feed->getXmlUrl() . '" htmlUrl="' .
                 $feed->getHtmlUrl().'"></outline>' . PHP_EOL;

        return $outline;
    }
}