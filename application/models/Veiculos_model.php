<?php
    class Veiculos_model extends CI_Model{

        public function __construct(){
            $this->load->database();
            
            $this->load->model('nodes/veiculos_node', 'node');
        }

        public function get_tipos(){
            $query = $this->db->get('veiculos_tipos');
            return $query->result_array();
        }

        public function get_tipos_url(){
            $this->db->select('id_tipo');
            $this->db->select('nome_plural');
            $this->db->select('url');

            $this->db->where('id_tipo > 0');
            $query = $this->db->get('veiculos_tipos');

            return $query->result_array();
        }

        public function get_veiculos_destaque($id_tipo, $status_destaque){
            $this->db->where('id_tipo', $id_tipo);
            $this->db->where('destaque', $status_destaque);
            $query = $this->db->get('veiculos');

            return $query->result_array();
        }

        public function get_veiculos_por_pagina($id_tipo, $qtd_por_pagina, $numero_pagina){
            $offset = (($numero_pagina-1) * $qtd_por_pagina);
            $query = $this->db->query('SELECT * 
                                        FROM veiculos 
                                        WHERE id_tipo = '. $id_tipo . 'm0
                                        LIMIT '. $qtd_por_pagina .'
                                        OFFSET '. $offset);
            return $query->result_array();
        }
        
        public function get_ids_veiculo_por_marca($id_tipo, $id_marca){
            return $this->db
                ->select('id_veiculo')
                ->where('id_tipo', $id_tipo)
                ->where('id_marca', $id_marca)
                ->get('veiculos')->result_array();
        }

        public function get_tipo($id_tipo){
            $result = $this->db->where('id_tipo', $id_tipo)->get('veiculos_tipos')->result_array();
            if($result == []) return null;
            return $result[0];
        }

        public function get_tipo_por_nome($tipo){
            $result = $this->db
                ->group_start()
                    ->where('nome', $tipo)
                    ->or_where('nome_plural', $tipo)
                ->group_end()
                ->get('veiculos_tipos')->result_array();
            if($result == []) return null;
            return $result[0];
        }

        public function get_marca($id_marca){
            $result = $this->db->where('id_marca', $id_marca)->get('veiculos_marcas')->result_array();
            if($result == []) return null;
            return $result[0];
        }

        public function get_marca_por_nome($marca){
            $result = $this->db->where('nome', $marca)->get('veiculos_marcas')->result_array();
            if($result == []) return null;
            return $result[0];
        }

        public function get_modelo($id_modelo){
            $result = $this->db->where('id_modelo', $id_modelo)->get('veiculos_modelos')->result_array();
            if($result == []) return null;
            return $result[0];
        }

        public function get_modelo_por_nome($modelo){
            $result = $this->db->where('nome', $modelo)->get('veiculos_modelos')->result_array();
            if($result == []) return null;
            return $result[0];
        }

        public function get_opcionais($id_veiculo){
            return $this->db->query("SELECT O.id_opcional, O.nome
                                    FROM veiculos_opcionais AS O RIGHT JOIN
                                        relacao_veiculo_opcional AS VO ON (O.id_opcional = VO.id_opcional) JOIN
                                        veiculos AS V ON (VO.id_veiculo = V.id_veiculo)
                                    WHERE V.id_veiculo = $id_veiculo")->result_array();
        }

        public function get_combustiveis($id_veiculo){
            return $this->db->query("SELECT C.*
                                    FROM veiculos_combustiveis AS C RIGHT JOIN
                                        relacao_veiculo_combustivel AS VC ON (C.id_combustivel = VC.id_combustivel) JOIN
                                        veiculos AS V ON (VC.id_veiculo = V.id_veiculo)
                                    WHERE V.id_veiculo = $id_veiculo")->result_array();
        }

        public function get_imagens($id_veiculo){
            return $this->db->query("SELECT I.*
                                    FROM veiculos_imagens AS I RIGHT JOIN
                                        relacao_veiculo_imagem AS VI ON (I.id_imagem = VI.id_imagem) JOIN
                                        veiculos AS V ON (VI.id_veiculo = V.id_veiculo)
                                    WHERE V.id_veiculo = $id_veiculo")->result_array();
        }
        
        public function get_veiculo($id_veiculo){
            $this->db->where('id_veiculo', $id_veiculo);
            $result = $this->db->get('veiculos')->result_array();


            $result[0]['tipo'] = $this->get_tipo($result[0]['id_tipo']);
            $result[0]['marca'] = $this->get_marca($result[0]['id_marca']);
            $result[0]['modelo'] = $this->get_modelo($result[0]['id_modelo']);
            $result[0]['opcionais'] = $this->get_opcionais($id_veiculo);
            $result[0]['combustiveis'] = $this->get_combustiveis($id_veiculo);
            $result[0]['imagens'] = $this->get_imagens($id_veiculo);

            return $result[0];
        }

        public function get_veiculo_display($id_veiculo){ // só pega os dados que vao ser mostrados no card
            $this->db->where('id_veiculo', $id_veiculo);
            $result = $this->db->get('veiculos')->result_array();

            $result[0]['tipo'] = $this->get_tipo($result[0]['id_tipo']);
            $result[0]['marca'] = $this->get_marca($result[0]['id_marca']);
            $result[0]['modelo'] = $this->get_modelo($result[0]['id_modelo']);
            $result[0]['imagens'] = $this->get_imagens($id_veiculo);

            return $result[0];
        }

        public function checar_status($id_veiculo){
            $this->db->select('status');
            $this->db->where('id_veiculo', $id_veiculo);
            $this->db->where('status', 1);
            $result = $this->db->get('veiculos')->result_array();

            return sizeof($result)>0;
        }

        public function crosscheck_veiculo_filtro($id_veiculo, $filtro){
            if($filtro == false) return true;

            $this->db->select('id_veiculo');
            $this->db->where('id_veiculo', $id_veiculo);

            foreach($filtro as $field_name => $value){
                if($field_name != 'valor'){
                    $this->db->where($field_name, $value);
                }else{
                    if($value[0] == null or $value[1] == null){
                        $final_value = ($value[0] == null) ? $value[1] : $value[0];
                        $this->db->where($field_name, $final_value);  
                    }else{
                        $this->db->where('$field_name >=', $value[0]);
                        $this->db->where('$field_name <=', $value[1]);
                    }
                }
            }

            $result = $this->db->get('veiculos')->result_array();
            // echo '<pre>'; print_r($result); echo '</pre>';

            // return $result[0];
            return sizeof($result)>0;
        }

        /* ELASTIC SEARCH*/

        public function reset_node(){
            $this->node->delete();
            $this->node->create();
        }

        public function pesquisar_termo($search){
            if(!$this->node->online) return array();


            $query = ['multi_match' => [
                'query' => $search,
                'type' => 'best_fields',
                'fields' => [
                    'nome_tipo',
                    'nome_marca^3', 
                    'nome_modelo^3',
                    'opcionais^2',
                    'combustivel^3',
                    'estado^3',
                    'cor^2',
                    'ano^3',
                    'observacoes',
                ],
            ]];

            
            $result = $this->node->search($query);

            // echo '<pre>'; echo $jsoni = json_encode($result, JSON_PRETTY_PRINT); echo '</pre>';
            return $result;
        }

        // todo arrumar um jeito de retornar um tamanhho ilimitado?
        public function auto_complete($search){
            if(!$this->node->online) return array();

            $query = '{
                "suggest": {
                    "veiculo-suggest": {
                        "prefix": "'.$search.'",
                        "completion": {
                            "field": "nome_exibicao",
                            "size": 10,
                            "fuzzy":{
                                "fuzziness": 1
                            }
                        }
                    }
                }
            }';

            
            $result = $this->node->suggest($query);

            return $result;
        }
    }