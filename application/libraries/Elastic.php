<?php 
use Elasticsearch\ClientBuilder;

class Elastic{

    public $client;
    public $cluster;
    public $status;
    public $indexes;

    public function __construct(){

        $hosts = [
            'localhost:9200', // Domain + Port
            'localhost',     // Just Domain
            'https://localhost',        // SSL to localhost
            'https://localhost:9200'  // SSL to IP + Port
        ];

        $this->client = ClientBuilder::create()
                                ->setHosts($hosts)
                                ->build();

        // $nodes = $this->client->nodes()->info(['node_id' => '_local', 'metric' => '_nodes']);

        try{
            $this->cluster = $this->client->cluster()->health(['local' => true]);
        }catch (Exception $e){
            $this->cluster = array(
                        'cluster_name' => 'unknown',
                        'status' => 'offline',
                        'timed_out' => true,
                        'number_of_nodes' => 0,
                        'number_of_data_nodes' => 0
                    );
        }
    }

    public function status(){
        return $this->cluster['status'] != 'offline';
    }


}   