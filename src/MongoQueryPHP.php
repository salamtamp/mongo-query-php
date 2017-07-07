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

  private function getDbCollection() {
    $result = false;

    if (empty($this->database)) {
      echo 'Error: database not set' . PHP_EOL;
    } else if (empty($this->collection)) {
      echo 'Error: collection not set' . PHP_EOL;
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
    $query = new \MongoDB\Driver\Query($filter);
    $db_collection = $this->getDbCollection();

    if ($db_collection !== false) {
      $cursor = $this->client->executeQuery($db_collection, $query);
    }

    return $cursor;
  }
}
