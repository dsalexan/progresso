<?php 
use Elasticsearch\ClientBuilder;

class Elastic{

    public $client;

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
    }

    public function Mapping(){
        $params = [
            'index' => 'veiculos',
            'body' => [
                'mappings' => [
                    'veiculo' => [
                        'properties' => [
                            'id' => [
                                'type' => 'integer' 
                            ],
                            'nome_tipo' => [
                                'type' => 'text'
                            ],
                            'nome_marca' => [
                                'type' => 'text'
                            ],
                            'nome_modelo' => [
                                'type' => 'text'
                            ],
                            'opcionais' => [
                                'type' => 'text'
                            ],
                            'combustivel' => [
                                'type' => 'text'
                            ],
                            'estado' => [
                                'type' => 'text'
                            ],
                            'cor' => [
                                'type' => 'text'
                            ],
                            'ano' => [
                                'type' => 'text'
                            ],
                            'observacoes' => [
                                'type' => 'text'
                            ],
                        ]
                    ]
                ]
            ]
        ];

       $this->client->indices()->create($params);
    }

    public function Init($reset=FALSE){ //verifica se existe o indice, se nao existir ele puxa os dados do banco
        $params = ['index' => 'veiculos'];
        $bool = $this->client->indices()->exists($params);

        if(!$bool or $reset) { // se n existe
            if($reset) $this->Reset();

            $this->InsertData();
        }
    }

    public function InsertData(){
        
        $sql = "SELECT id_veiculo, nome_tipo, nome_marca, nome_modelo, IF(opcionais IS NULL, '', opcionais) AS opcionais, combustivel, estado, cor, ano, observacoes ".
                "FROM visao_veiculos ".
                "WHERE status = 1";
                
        //require_once( BASEPATH .'database/DB.php');
        $db =& DB();
        $query = $db->query( $sql );
        $result = $query->result();

        $params = null;
        foreach ($result as $row){
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'veiculos',
                    '_type' => 'veiculo',
                    '_id' => $row->id_veiculo,
                ) ,
            );

            $params['body'][] = ['nome_tipo' => $row->nome_tipo, 
                                'nome_marca' => $row->nome_marca, 
                                'nome_modelo' => $row->nome_modelo, 
                                'opcionais' => $row->opcionais, 
                                'combustivel' => $row->combustivel, 
                                'estado' => $row->estado, 
                                'cor' => $row->cor,
                                'ano' => $row->ano, 
                                'observacoes' => $row->observacoes, ];
        }

        $this->Mapping();
        $responses = $this->client->bulk($params);

        return true;
    }

    public function Reset(){
        $params = ['index' => 'veiculos'];
        $response = $this->client->indices()->delete($params);
    }

    public function InsertNode($novo_id_veiculo){

        $sql = "SELECT id_veiculo, nome_tipo, nome_marca, nome_modelo, opcionais, combustivel, estado, cor, ano, observacoes ".
                "FROM visao_veiculos ".
                "WHERE id_veiculo = $novo_id_veiculo";
                
        //require_once( BASEPATH .'database/DB.php');
        $db =& DB();
        $query = $db->query( $sql );
        $result = $query->result();

        $params = null;
        foreach ($result as $row){
            $params = ['index' => 'veiculos',
                        'type' => 'veiculo',
                        'id' => $row->id_veiculo,
                        'body' => ['nome_tipo' => $row->nome_tipo, 
                                    'nome_marca' => $row->nome_marca, 
                                    'nome_modelo' => $row->nome_modelo, 
                                    'opcionais' => $row->opcionais, 
                                    'combustivel' => $row->combustivel, 
                                    'estado' => $row->estado, 
                                    'cor' => $row->cor,
                                    'ano' => $row->ano, 
                                    'observacoes' => $row->observacoes, ],];
        }

        $responses = $this->client->index($params);
        
        return true;
    }

    public function UpdateNode($_id_veiculo){

        $sql = "SELECT id_veiculo, nome_tipo, nome_marca, nome_modelo, opcionais, combustivel, estado, cor, ano, observacoes ".
                "FROM visao_veiculos ".
                "WHERE id_veiculo = $_id_veiculo";
                
        //require_once( BASEPATH .'database/DB.php');
        $db =& DB();
        $query = $db->query( $sql );
        $result = $query->result();

        $params = null;
        foreach ($result as $row){
            $params = ['index' => 'veiculos',
                        'type' => 'veiculo',
                        'id' => $row->id_veiculo,
                        'body' => ['nome_tipo' => $row->nome_tipo, 
                                    'nome_marca' => $row->nome_marca, 
                                    'nome_modelo' => $row->nome_modelo, 
                                    'opcionais' => $row->opcionais, 
                                    'combustivel' => $row->combustivel, 
                                    'estado' => $row->estado, 
                                    'cor' => $row->cor,
                                    'ano' => $row->ano, 
                                    'observacoes' => $row->observacoes, ],];
        }

        $responses = $this->client->update($params);
        
        return true;
    }

    public function DeleteNode($_id_veiculo){

        $params = ['index' => 'veiculos',
                    'type' => 'veiculo',
                    'id' => $_id_veiculo, ];

        $responses = $this->client->delete($params);
        
        return true;
    }

    public function Search($query){

        $result = array();

        $i = 0;
        $params = ['index' => 'veiculos',
                    'type' => 'veiculo',
                    'body' => [
                        'query' => [
                            'match' => [
                                'nome_tipo' => $query ],],], ];
        
        $query = $this->client->search($params);

        $hits = sizeof($query['hits']['hits']);
        $hit = $query['hits']['hits'];
        $result['searchfound'] = $hits;

        while($i < $hits){
            $result['result'][$i] = $query['hits']['hits'][$i]['_source'];
            $i++;
        }

        return $result;
    }
}