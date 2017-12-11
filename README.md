# Mongo-query-php
for Query data from MongoDB

#Usage

##Initial setup

1. Install composer. `curl -s http://getcomposer.org/installer | php`

2. Create composer.json containing:
  ```json
  {
      "require" : {
          "salamtam/mongo-query-php" : "^1.0"
      }
  }
  ```
3. Run `./composer.phar install`

4. Keep up-to-date: `./composer.phar update`

##Example 1

**Query with URL**
```php
require_once __DIR__ . '/vendor/autoload.php';

use MongoQueryPHP\MongoQueryPHP;

/* set config */
$config = [
  'url' => 'mongodb://localhost:27017',
  'database' => 'test',
  'collection' => 'member'
];

/* set query (filter) */
$filter = [
  'name' => 'salamtam'
];

/* connect database */
$db = new MongoQueryPHP($config);
$db->setDatabase($config['database'])->setCollection($config['collection']);

/* query database */
$cursor = $db->query($filter);

/* result */
foreach ($cursor as $doc) {
  echo json_encode($doc) . PHP_EOL;
  break;
}
```

##Example 2

**Query with basic authentication**
```php
require_once __DIR__ . '/vendor/autoload.php';

use MongoQueryPHP\MongoQueryPHP;

/* set config */
$config = [
  'host' => 'localhost',
  'port' => '27017',
  'user' => 'root',
  'pass' => '',
  'database' => 'test',
  'collection' => 'member'
];

/* set query (filter) */
$filter = [
  'name' => 'salamtam'
];

/* connect database */
$db = new MongoQueryPHP($config);
$db->setDatabase($config['database'])->setCollection($config['collection']);

/* query database */
$cursor = $db->query($filter);

/* result */
foreach ($cursor as $doc) {
  echo json_encode($doc) . PHP_EOL;
  break;
}
```

##Example 3

**Query with multi filter**
```php
require_once __DIR__ . '/vendor/autoload.php';

use MongoQueryPHP\MongoQueryPHP;

/* set config */
$config = [
  'url' => 'mongodb://localhost:27017',
  'database' => 'test',
  'collection' => 'member'
];

/* set query (filter) */
$filter = json_decode('{"name":"salamtam","created_at":{"$gte":1499533200000}}', true);

/* connect database */
$db = new MongoQueryPHP($config);
$db->setDatabase($config['database'])->setCollection($config['collection']);

/* query database */
$cursor = $db->query($filter);

/* result */
foreach ($cursor as $doc) {
  echo json_encode($doc) . PHP_EOL;
  break;
}
```

##Example 4

**Query with multi filter and sort**
```php
require_once __DIR__ . '/vendor/autoload.php';

use MongoQueryPHP\MongoQueryPHP;

/* set config */
$config = [
  'url' => 'mongodb://localhost:27017',
  'database' => 'test',
  'collection' => 'member'
];

/* set query (filter) */
$filter = [
    'name' => 'salamtam',
    'created_at' => [
        '$gte' => 1499533200000,
    ],
];

$sort = [
    'sort' => [
        'created_at' => -1
    ],
];


/* connect database */
$db = new MongoQueryPHP($config);
$db->setDatabase($config['database'])->setCollection($config['collection']);

/* query database */
$cursor = $db->query($filter, $sort);

/* result */
foreach ($cursor as $doc) {
  echo json_encode($doc) . PHP_EOL;
  break;
}
```

##Example 5

**Aggregate with URL**
```php
require_once __DIR__ . '/vendor/autoload.php';

use MongoQueryPHP\MongoQueryPHP;

/* set config */
$config = [
  'url' => 'mongodb://localhost:27017',
  'database' => 'test',
  'collection' => 'member'
];

/* set query (filter) */
$filter = [
  '$match' => [
    'name' => 'salamtam'
  ]
];

/* connect database */
$db = new MongoQueryPHP($config);
$db->setDatabase($config['database'])->setCollection($config['collection']);

/* aggregate database */
$cursor = $db->aggregate($filter);

/* result */
foreach ($cursor as $doc) {
  echo json_encode($doc) . PHP_EOL;
  break;
}
```

##Example 6

**Aggregate with filter**
```php
require_once __DIR__ . '/vendor/autoload.php';

use MongoQueryPHP\MongoQueryPHP;

/* set config */
$config = [
  'url' => 'mongodb://localhost:27017',
  'database' => 'test',
  'collection' => 'member'
];

/* set query (filter) */
$filter = json_decode('[{"$match":{"name":"salamtam","created_at":{"$gte":1499533200000}}}]', true);

/* connect database */
$db = new MongoQueryPHP($config);
$db->setDatabase($config['database'])->setCollection($config['collection']);

/* aggregate database */
$cursor = $db->aggregate($filter);

/* result */
foreach ($cursor as $doc) {
  echo json_encode($doc) . PHP_EOL;
  break;
}
```

