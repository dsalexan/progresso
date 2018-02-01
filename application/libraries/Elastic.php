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

    /*
        MODIFICAÇÕES
            - mapping, insertData, insertNode, updateNode, deleteNode, Search deveriam ir tudo pra uma
                classe node, que deveria estar numa pasta nodes e que eu deveria dar um jeito de carregar
                no autoload.php como um model
    
    */

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
        try{
            $bool = $this->client->indices()->exists($params);
        }catch (Exception $e){
            return false;
        }

        if(!$bool or $reset) { // se n existe
            if($reset) $this->Reset();

            $this->InsertData();
        }

        return true;
    }

    public function InsertData(){
        
        $sql = "SELECT id_veiculo, ".
                    "nome_tipo, ".
                    "nome_marca, ".
                    "nome_modelo, ".
                    "IF(opcionais IS NULL, '', opcionais) AS opcionais, ".
                    "combustivel, ".
                    "IF(estado = 'Novo', 'novo, nova', 'usado, usada') AS estado, ".
                    "cor, ".
                    "ano, ".
                    "observacoes ".
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

        $sql = "SELECT id_veiculo, ".
                    "nome_tipo, ".
                    "nome_marca, ".
                    "nome_modelo, ".
                    "IF(opcionais IS NULL, '', opcionais) AS opcionais, ".
                    "combustivel, ".
                    "IF(estado = 'Novo', 'novo, nova', 'usado, usada') AS estado, ".
                    "cor, ".
                    "ano, ".
                    "observacoes ".
                "FROM visao_veiculos ".
                "WHERE status = 1";
                
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

        $sql = "SELECT id_veiculo, ".
                    "nome_tipo, ".
                    "nome_marca, ".
                    "nome_modelo, ".
                    "IF(opcionais IS NULL, '', opcionais) AS opcionais, ".
                    "combustivel, ".
                    "IF(estado = 'Novo', 'novo, nova', 'usado, usada') AS estado, ".
                    "cor, ".
                    "ano, ".
                    "observacoes ".
                "FROM visao_veiculos ".
                "WHERE status = 1";
                
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

    public function Search($query, $params=false){

        $result = array();

        $i = 0;
        if(!$params){
            $params = ['index' => 'veiculos',
                        'type' => 'veiculo',
                        'body' => [
                            'query' => $query,], ];
        }
            
        $query = $this->client->search($params);

        $hits = sizeof($query['hits']['hits']);
        $hit = $query['hits']['hits'];

        $result['searchfound'] = $hits;

        while($i < $hits){
            $result['result'][$i] = $query['hits']['hits'][$i]['_source'];
            $result['result'][$i]['_id'] = $query['hits']['hits'][$i]['_id'];
            $result['result'][$i]['_score'] = $query['hits']['hits'][$i]['_score'];
            $result['ids'][$i]['_id'] = $query['hits']['hits'][$i]['_id'];
            $result['ids'][$i]['_score'] = $query['hits']['hits'][$i]['_score'];

            $i++;
        }

        return $result;
    }
}   