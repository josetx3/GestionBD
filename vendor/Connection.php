<?php
require_once "vendor/autoload.php";

use MongoDB\Client;

class Connection {
    private $client;
    private $database;

    public function __construct() {
        $this->client = new MongoDB\Client("mongodb+srv://leon:leon@leondistribuciones.spok4zo.mongodb.net/?retryWrites=true&w=majority");
        $this->database = $this->client->leon;
    }

    public function query($collectionName, $filter = []) {
        $collection = $this->database->$collectionName;
        return $collection->find($filter);
    }

    public function queryCreate($collectionName,$json) {
        $collection = $this->database->$collectionName;
        return $collection->insertOne($json);
    }

    public function queryUpdate($collectionName,$documento,$actualizar) {
        $collection = $this->database->$collectionName;
        return $collection->updateOne($documento,$actualizar);
    }

    public function queryDelete($collectionName,$primary) {
        $collection = $this->database->$collectionName;
        return $collection->deleteOne($primary);
    }

}
