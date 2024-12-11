<?php
namespace App\Libraries;
use MongoDB\Client;
class MongoDB {
             
	private $dbM;
    private $client;

	function __construct() {
        $this->client = new Client('mongodb://localhost:27017/akash');
        $this->dbM = $this->client->selectDatabase('crud');
	}     
    public function getCollection($table){
        return $this->dbM->{$table};
    }  
}
?>