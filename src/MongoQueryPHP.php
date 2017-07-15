<?php

namespace MongoQueryPHP;

class MongoQueryPHP
{
  public function __construct()
  {
    return $this->createConnection();
  }

  public function setDatabase($database)
  {
    $this->database = $database;
    return $this;
  }

  public function setCollection($collection)
  {
    $this->collection = $collection;
    return $this;
  }

  private function getDatabase() {
    if (!empty($this->database)) {
      return $this->database;
    } else {
      echo 'Error: database is not defined' . PHP_EOL;
      return false;
    }
  }

  private function getCollection() {
    if (!empty($this->collection)) {
      return $this->collection;
    } else {
      echo 'Error: collection is not defined' . PHP_EOL;
      return false;
    }
  }

  private function getDbCollection() {
    $result = false;

    if (empty($this->database)) {
      echo 'Error: database is not defined' . PHP_EOL;
    } else if (empty($this->collection)) {
      echo 'Error: collection is not defined' . PHP_EOL;
    } else {
      $result = $this->database . "." . $this->collection;
    }

    return $result;
  }

  public function createConnection($config = ['host' => 'localhost', 'port' => '27017'])
  {
    if (!empty($config['url'])) {
      $url = $config['url'];
    } else {
      $user_pass = '';

      if (!empty($config['user']) && !empty($config['pass'])) {
        $user_pass = $config['user'] . ':' . $config['pass'] . '@';
      }

      $url = 'mongodb://' . $user_pass . $config['host'] . ':' . $config['port'];
    }

    $this->client = new \MongoDB\Driver\Manager($url);
    return $this->client;
  }

  public function query($filter)
  {
    $cursor = false;
    $db_collection = $this->getDbCollection();

    if ($db_collection !== false) {
      $query = new \MongoDB\Driver\Query($filter);
      $cursor = $this->client->executeQuery($db_collection, $query);
    }

    return $cursor;
  }

  public function aggregate($filter)
  {
    $cursor = false;
    $database = $this->getDatabase();
    $collection = $this->getCollection();

    if (empty($filter[0])) {
      $filter = array($filter);
    }

    if ($database !== false && $collection !== false) {
      $filter = [
        'aggregate' => $collection,
        'pipeline' => $filter,
        'cursor' => [
          'batchSize' => 1
        ]
      ];

      $command = new \MongoDB\Driver\Command($filter);
      $cursor = $this->client->executeCommand($database, $command);
    }

    return $cursor;
  }
}
