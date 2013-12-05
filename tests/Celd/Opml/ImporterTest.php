<?php

namespace Celd\Opml\Tests;

use Celd\Opml\Importer;

class ImporterTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyConstructorArgumentGivesEmptyFeedlist() {
       $importer = new Importer();
       $feedList = $importer->getFeedList();
       $this->assertEquals(array(), $feedList->getItems());
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testInvalidOpmlGivesException() {
        $importer = new Importer('<dummie>data</dummie>');
    }

    public function testImportRootLevelFeedException() {
        $importer = new Importer($this->getSampleFixture());
        $feedList = $importer->getFeedList();
        $items = $feedList->getItems();
        $feed = $items[0];
        $this->assertEquals('Planet PHP', $feed->getTitle());
        $this->assertEquals('http://www.planet-php.org/rss/', $feed->getXmlUrl());
        $this->assertEquals('http://planet-php.net', $feed->getHtmlUrl());
    }

    public function testImportCategory() {
        $importer = new Importer($this->getSampleFixture());
        $feedList = $importer->getFeedList();
        $items = $feedList->getItems();
        $category = $items[1];
        $this->assertEquals('Companies', $category->getTitle());
    }

    public function testImportCategoryFeeds() {
        $importer = new Importer($this->getSampleFixture());
        $feedList = $importer->getFeedList();
        $items = $feedList->getItems();
        $category = $items[1];
        $feeds = $category->getFeeds();
        $feed = $feeds[0];
        $this->assertEquals('Official Google Blog', $feed->getTitle());
        $this->assertEquals('http://googleblog.blogspot.com/feeds/posts/default', $feed->getXmlUrl());
        $this->assertEquals('http://googleblog.blogspot.com/', $feed->getHtmlUrl());
    }

    public function testImportCategorySoloFeed() {
        $importer = new Importer($this->getSampleFixture());
        $feedList = $importer->getFeedList();
        $items = $feedList->getItems();
        $category = $items[2];
        $feeds = $category->getFeeds();
        $feed = $feeds[0];
        $this->assertEquals('Android Developers Blog', $feed->getTitle());
        $this->assertEquals('http://android-developers.blogspot.com/feeds/posts/default', $feed->getXmlUrl());
        $this->assertEquals('http://android-developers.blogspot.com/', $feed->getHtmlUrl());
    }

    public function testImportOpmlTitle() {
        $importer = new Importer($this->getSampleFixture());
        $feedList = $importer->getFeedList();
        $this->assertEquals('Fixture opml sample1', $feedList->getTitle());
    }

    public function testImportOpmlWithOneFeed() {
        $importer = new Importer($this->getSampleFixture('sample2.opml'));
        $feedList = $importer->getFeedList();
        $items = $feedList->getItems();
        $feed = $items[0];
        $this->assertEquals('Planet PHP', $feed->getTitle());
        $this->assertEquals('http://www.planet-php.org/rss/', $feed->getXmlUrl());
        $this->assertEquals('http://planet-php.net', $feed->getHtmlUrl());
    }

    public function testImportExportFlowGeneratesSameOpml() {
        $importer = new Importer($this->getSampleFixture());
        $originalFeedList = $importer->getFeedList();
        $data = $importer->export($originalFeedList);

        $importer = new Importer($data);
        $this->assertEquals($originalFeedList, $importer->getFeedList());
    }


    protected function getSampleFixture($fileName = 'sample1.opml') {
        return file_get_contents(__DIR__ . '/Fixtures/' . $fileName);
    }

}