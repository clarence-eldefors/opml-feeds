opml-feeds
==========

Import/export feed lists in OPML format.

Install
-------
Install using composer.

Import OPML file:
--------------
```php
<?php
use Celd\Opml\Importer;
$importer = new Importer(file_get_contents('http://opml-url'));
$feedList = $importer->getFeedList();
foreach ($feedList->getItems() as $item) {
  if ($item->getType() == 'category') {
    echo $item->getTitle(); // Category title
    foreach($item->getFeeds() as $feed) {
      echo $feed->getTitle() . "\n";
    }
  }
  echo $item->getTitle(); //Root feed title
}

// Properties of Model/Feed are:
// title, xmlUrl, htmlUrl, type (rss/atom/etc)
```

Exporting OPML file
--------------------
```php
<?php
use Celd\Opml\Importer;
use Celd\Opml\Model\FeedList;
use Celd\Opml\Model\Feeed;

$feedList = new FeedList();

$feed = new Feed();
$feed->setTitle('Feed title');
$feed->setXmlUrl('http://rss-feed-url');
$feed->setType('rss');
$feed->setHtmlUrl('http://html-url');

$feedList->addItem($feed);

$importer = new Importer();
echo $importer->export($feedList);
```
