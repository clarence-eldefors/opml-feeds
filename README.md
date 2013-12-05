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
$importer = new Importer();
$feedList = $importer->getFeedList();
foreach ($feedList->items as $item) {
  if ($this->getType=='category') {
    echo $item->getTitle(); // Category title
    foreach($this->getFeeds() as $feed) {
      echo $feed->getTitle() . "\n";
    }
  }
  echo $item->getTitle(); /Root feed title
}

// Properties of Model/Feed are:
// title, xmlUrl, htmlUrl, type (rss/atom/etc)
```

Exporting OPML file
--------------------
```php
<?php
use Celd\Opml\Importer;
$importer = new Importer();
echo $importer->export(file_get_contents(FEED_URL));
```
