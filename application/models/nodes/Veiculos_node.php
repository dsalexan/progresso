<?php
    class Veiculos_node extends CI_Model{

        public $name;
        public $type;
        public $status;

        public $online;

        public function __construct(){
            $this->name = 'veiculos';
            $this->type = 'veiculo';

            if(!$this->elastic->status())  {
                $this->online = false;
            }else{
                $this->online = true;

                $this->status = $this->exists();

                if(!$this->status) create();
            }
        }

        //GENERALIZED FUNCTIONS
        public function exists($params=false){
            if(!$params) $params = ['index' => $this->name, 'type' => $this->type];

            $function ='exists';
            if(array_key_exists('index', $params) && array_key_exists('type', $params)) $function = 'getMapping';

            return $this->elastic->client->indices()->$function($params);
        }

        public function create(){
            if(!$this->exists(['index' => $this->name]))
                $this->client->indices()->create(['index' => $this->name]);

            $this->client->indices()->putMapping($this->mapping());

            $this->fetch_data();

            $this->status = true;
        }

        public function delete(){
            $params = ['index' => $this->name];
            $response = $this->elastic->client->indices()->delete($params);
            $this->status = false;
        }

        public function insert($novo_id){
            $this->entry('index', $novo_id);
        }

        public function update($id){
            $this->entry('update', $id);
        }

        public function remove($id){
            $params = ['index' => $this->name,
                    'type' => $this->type,
                    'id' => $id, ];

            $responses = $this->elastic->client->delete($params);
        }

        //GENERALIZE FUNCTION/SPECIFIC DATA
        public function mapping(){
            $params = [
                'index' => $this->name,
                'type' => $this->type,
                'body' => [
                    'mappings' => [
                        $this->type => [
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

            return $params;
        }

        public function fetch_data(){
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
                
                
            $db =& DB();
            $query = $db->query( $sql );
            $result = $query->result();

            $params = null;
            foreach ($result as $row){
                $params['body'][] = array(
                    'index' => array(
                        '_index' => $this->name,
                        '_type' => $this->type,
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

            $responses = $this->elastic->client->bulk($params);

            $this->status = true;
        }

        public function entry($action, $id){
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
                "WHERE status = 1 AND id_veiculo=$id";
                
            $db =& DB();
            $query = $db->query( $sql );
            $result = $query->result();

            $params = null;
            foreach ($result as $row){
            $params = ['index' => $this->name,
                        'type' => $this->type,
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

            $responses = $this->elastic->client->$action($params);
        }


        //SPECIFIC FUNCTIONS
        public function search($query, $params=false){
            $result = array();
    
            $i = 0;
            if(!$params){
                $params = ['index' => 'veiculos',
                            'type' => 'veiculo',
                            'body' => [
                                'query' => $query,], ];
            }
                
            $query = $this->elastic->client->search($params);
    
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
