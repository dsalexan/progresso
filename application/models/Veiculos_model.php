<?php
    class Veiculos_model extends CI_Model{

        public function __construct(){
            $this->load->database();
            
            // $this->load->model('nodes/veiculos_node', 'node');
        }

        public function get_tipos($status=false){
            if($status !== false) {
                $this->db->where('status', $status);
            }

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

        public function insert_tipo($tipo){
            $this->db->insert('veiculos_tipos', $tipo);
            return $this->db->insert_id();
        }

        public function update_tipo($tipo){
            $this->db->where('id_tipo', $tipo['id_tipo']);
            $this->db->update('veiculos_tipos', $tipo);        
        }

        public function remove_tipo($id_tipo, $revive=false){
            $status = 0;
            if($revive) $status = 1;

            $this->db->where('id_tipo', $id_tipo);
            $this->db->update('veiculos_marcas', ['status' => $status]);

            $this->db->where('id_tipo', $id_tipo);
            $this->db->update('veiculos_modelos', ['status' => $status]);
            
            $this->db->where('id_tipo', $id_tipo);
            $this->db->update('veiculos', ['status' => $status]);

            $this->db->where('id_tipo', $id_tipo);
            $this->db->update('veiculos_tipos', ['status' => $status]);

            return true;
        }



        public function get_marcas($idle=true){
            if(!$idle){
                $this->db->select('veiculos_marcas.*');
                $this->db->join('veiculos', 'veiculos_marcas.id_marca = veiculos.id_marca');
                $this->db->group_by('veiculos_marcas.id_marca');
            }
            $query = $this->db->get('veiculos_marcas');
            return $query->result_array();
        }

        public function get_marcas_lista($status=false){
            $status_query= '';
            if($status !== false) $status_query = 'WHERE m.status = '.$status;

            $query = $this->db->query(''.
                'SELECT m.id_marca AS id_marca, t.nome AS tipo, m.nome AS nome, SUBSTRING(m.imagem, 1, 59) AS imagem, m.status AS status '.
                'FROM veiculos_marcas AS m LEFT JOIN '.
                    'veiculos_tipos AS t ON (m.id_tipo=t.id_tipo) '.
                $status_query.' '.
                'GROUP BY m.id_marca');
            return $query->result_array();            
        }

        public function get_marcas_lista_by_tipo($id_tipo, $status=false){
            $status_query= '';
            if($status !== false) $status_query = ' AND m.status = '.$status;

            $query = $this->db->query(''.
                'SELECT m.id_marca AS id_marca, t.nome AS tipo, m.nome AS nome, SUBSTRING(m.imagem, 1, 59) AS imagem, m.status AS status '.
                'FROM veiculos_marcas AS m LEFT JOIN '.
                    'veiculos_tipos AS t ON (m.id_tipo=t.id_tipo) '.
                'WHERE m.id_tipo='.$id_tipo.$status_query.' '.
                'GROUP BY m.id_marca');
            return $query->result_array();            
        }

        public function insert_marca($marca){
            $this->db->insert('veiculos_marcas', $marca);
            return $this->db->insert_id();
        }

        public function update_marca($marca){
            $this->db->where('id_marca', $marca['id_marca']);
            $this->db->update('veiculos_marcas', $marca);        
        }

        public function remove_marca($id_marca, $revive=false){
            $status = 0;
            if($revive) $status = 1;

            if($status == 1) { // reviver marca
                //verificar se tipo ta ok
                $tipo = $this->db->query(''.
                    'SELECT t.id_tipo AS id_tipo, t.status AS status '.
                    'FROM veiculos_tipos AS t RIGHT JOIN '.
                        'veiculos_marcas AS m ON (t.id_tipo = m.id_tipo) '.
                    'WHERE id_marca='.$id_marca
                )->result_array()[0];

                if($tipo['status'] == "0"){
                    return [[ 'error' => 'type_inactive',
                                'on' => $tipo['id_tipo']]];
                }
            }

            $this->db->where('id_marca', $id_marca);
            $this->db->update('veiculos_modelos', ['status' => $status]);

            $this->db->where('id_marca', $id_marca);
            $this->db->update('veiculos', ['status' => $status]);

            $this->db->where('id_marca', $id_marca);
            $this->db->update('veiculos_marcas', ['status' => $status]);

            return true;
        }



        public function get_modelos($status=false){
            if($status !== false) {
                $this->db->where('status', $status);
            }

            $query = $this->db->get('veiculos_modelos');
            return $query->result_array();
        }

        public function get_modelos_lista($status=false){
            $status_query= '';
            if($status !== false) $status_query = 'WHERE m.status = '.$status;

            $query = $this->db->query(''.
                'SELECT m.id_modelo AS id_modelo, t.nome AS tipo, b.nome AS marca, m.nome AS nome, m.status AS status '.
                'FROM veiculos_modelos AS m LEFT JOIN '.
                    'veiculos_tipos AS t ON (m.id_tipo=t.id_tipo) LEFT JOIN '.
                    'veiculos_marcas AS b ON (m.id_marca=b.id_marca) '.
                $status_query.' '.
                'GROUP BY m.id_modelo');
            return $query->result_array();            
        }

        public function get_modelos_lista_by_tipo($id_tipo, $status=false){
            $status_query= '';
            if($status !== false) $status_query = ' AND m.status = '.$status;

            $query = $this->db->query(''.
                'SELECT m.id_modelo AS id_modelo, t.nome AS tipo, b.nome AS marca, m.nome AS nome, m.status AS status '.
                'FROM veiculos_modelos AS m LEFT JOIN '.
                    'veiculos_tipos AS t ON (m.id_tipo=t.id_tipo) LEFT JOIN '.
                    'veiculos_marcas AS b ON (m.id_marca=b.id_marca) '.
                'WHERE m.id_tipo='.$id_tipo.$status_query.' '.
                'GROUP BY m.id_modelo');
            return $query->result_array();            
        }

        public function get_modelos_lista_by_marca($id_marca, $status=false){
            $status_query= '';
            if($status !== false) $status_query = ' AND m.status = '.$status;

            $query = $this->db->query(''.
                'SELECT m.id_modelo AS id_modelo, t.nome AS tipo, b.nome AS marca, m.nome AS nome, m.status AS status '.
                'FROM veiculos_modelos AS m LEFT JOIN '.
                    'veiculos_tipos AS t ON (m.id_tipo=t.id_tipo) LEFT JOIN '.
                    'veiculos_marcas AS b ON (m.id_marca=b.id_marca) '.
                'WHERE m.id_marca='.$id_marca.$status_query.' '.
                'GROUP BY m.id_modelo');
            return $query->result_array();            
        }

        public function insert_modelo($modelo){
            $this->db->insert('veiculos_modelos', $modelo);
            return $this->db->insert_id();
        }

        public function update_modelo($modelo){
            $this->db->where('id_modelo', $modelo['id_modelo']);
            $this->db->update('veiculos_modelos', $modelo);        
        }

        public function remove_modelo($id_modelo, $revive=false){
            $status = 0;
            if($revive) $status = 1;

            if($status == 1) { // reviver marca
                //verificar se tipo ta ok
                $tipo = $this->db->query(''.
                    'SELECT t.id_tipo AS id_tipo, t.status AS status_tipo, m.id_marca AS id_marca, m.status AS status_marca '.
                    'FROM veiculos_modelos AS n RIGHT JOIN '.
                        'veiculos_marcas AS m ON (m.id_marca = n.id_marca) RIGHT JOIN '.
                        'veiculos_tipos AS t ON (t.id_tipo = n.id_tipo) '.
                    'WHERE id_modelo='.$id_modelo
                )->result_array()[0];

                if($tipo['status_tipo'] == "0" || $tipo['status_marca'] == "0"){
                    $return = []; 

                    if($tipo['status_tipo'] == "0"){
                        $return[] = [ 'error' => 'type_inactive',
                                        'on' => $tipo['id_tipo']];
                    }

                    if($tipo['status_marca'] == "0"){
                        $return[] = [ 'error' => 'brand_inactive',
                                        'on' => $tipo['id_marca']];
                    }

                    return $return;
                }
            }

            $this->db->where('id_modelo', $id_modelo);
            $this->db->update('veiculos', ['status' => $status]);

            $this->db->where('id_modelo', $id_modelo);
            $this->db->update('veiculos_modelos', ['status' => $status]);
        }

        
        

        public function get_veiculos_lista($status=false){
            $this->db->select('id_veiculo');
            $this->db->select('nome_tipo');
            $this->db->select('nome_marca');
            $this->db->select('nome_modelo');
            $this->db->select('estado');
            $this->db->select('ano');
            $this->db->select('venda_valor');
            $this->db->select('destaque');
            $this->db->select('status');

            if($status !== false) {
                $this->db->where('status', $status);
            }

            return $this->db->get('visao_veiculos')->result_array();
        }

        public function get_veiculos_destaque($id_tipo, $status_destaque){
            $this->db->where('id_tipo', $id_tipo);
            $this->db->where('destaque', $status_destaque);
            $this->db->where('status', 1);
            $query = $this->db->get('veiculos');

            return $query->result_array();
        }

        public function get_destaques(){
            $this->db->select('id_veiculo');
            $this->db->where('destaque', 1);
            $this->db->where('status', 1);
            $query = $this->db->get('veiculos');

            return $query->result_array();
        }

        public function get_id_veiculo_por_pagina($id_tipo, $qtd_por_pagina, $numero_pagina, $order='venda_valor DESC', $marcas=false){
            $offset = (($numero_pagina-1) * $qtd_por_pagina);
            $query_marca = '';
            if($marcas !== false) $query_marca = 'AND id_marca IN (' .implode(',', $marcas). ')';
            $query = $this->db->query('SELECT id_veiculo
                                        FROM veiculos 
                                        WHERE status = 1 AND
                                        id_tipo = '. $id_tipo . ' ' . $query_marca . ' 
                                        ORDER BY '.$order.' 
                                        LIMIT '. $qtd_por_pagina .' 
                                        OFFSET '. $offset);
            return $query->result_array();
        }
        
        /**
         * Rotina recuperar veículos de forma paginada
         * @param type $qtd_por_pagina Qtd registros por página
         * @param type $numero_pagina Numero corrente da página
         * @param type $order Ordem de exibição
         * @param type $marcas Lista de marcas (separados por ',')
         * @return type
         */
        public function get_id_veiculo_por_pagina_sem_tipo($qtd_por_pagina, $numero_pagina, $order='venda_valor DESC', $marcas=false){
            $offset = (($numero_pagina-1) * $qtd_por_pagina);
            $query_marca = '';
            if($marcas !== false) $query_marca = 'AND id_marca IN (' .implode(',', $marcas). ')';
            $query = $this->db->query('SELECT id_veiculo
                                        FROM veiculos 
                                        WHERE 1 = 1 '.
                                        $query_marca . '
                                        AND status = 1
                                        ORDER BY '.$order.' 
                                        LIMIT '. $qtd_por_pagina . ' 
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


        public function get_opcionais($id_veiculo, $id_only=false){
            $select = "SELECT O.id_opcional, O.nome";
            if($id_only) $select = "SELECT O.id_opcional";

            $result = $this->db->query($select."
                                    FROM veiculos_opcionais AS O RIGHT JOIN
                                        relacao_veiculo_opcional AS VO ON (O.id_opcional = VO.id_opcional) JOIN
                                        veiculos AS V ON (VO.id_veiculo = V.id_veiculo)
                                    WHERE V.id_veiculo = $id_veiculo")->result_array();

            if($id_only){
                $ids = [];
                foreach($result as $row){
                    $ids[] = $row['id_opcional'];
                }
                $result = $ids;
            }

            return $result;
        }

        public function get_opcional($id_opcional){
            $result = $this->db->where('id_opcional', $id_opcional)->get('veiculos_opcionais')->result_array();
            if($result == []) return null;
            return $result[0];
        }
        

        public function get_combustiveis($id_veiculo, $id_only=false){
            $select = "SELECT C.*";
            if($id_only) $select = "SELECT C.id_combustivel";
            
            $result = $this->db->query($select."
                                    FROM veiculos_combustiveis AS C RIGHT JOIN
                                        relacao_veiculo_combustivel AS VC ON (C.id_combustivel = VC.id_combustivel) JOIN
                                        veiculos AS V ON (VC.id_veiculo = V.id_veiculo)
                                    WHERE V.id_veiculo = $id_veiculo")->result_array();

            if($id_only){
                $ids = [];
                foreach($result as $row){
                    $ids[] = $row['id_combustivel'];
                }
                $result = $ids;
            }

            return $result;
        }

        public function get_combustivel($id_combustivel){
            $result = $this->db->where('id_combustivel', $id_combustivel)->get('veiculos_combustiveis')->result_array();
            if($result == []) return null;
            return $result[0];
        }


        public function get_imagens($id_veiculo, $id_only=false){
            $select = "SELECT I.*";
            if($id_only) $select = "SELECT I.id_imagem";
            
            $result = $this->db->query($select."
                                    FROM veiculos_imagens AS I RIGHT JOIN
                                        relacao_veiculo_imagem AS VI ON (I.id_imagem = VI.id_imagem) JOIN
                                        veiculos AS V ON (VI.id_veiculo = V.id_veiculo)
                                    WHERE V.id_veiculo = $id_veiculo 
                                    ORDER BY VI.ordem ASC")->result_array();

            if($id_only){
                $ids = [];
                foreach($result as $row){
                    $ids[] = $row['id_imagem'];
                }
                $result = $ids;
            }

            return $result;
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

        public function remove_veiculo($id_veiculo, $revive=false){
            $status = 0;
            if($revive) $status = 1;

            if($status == 1) { // reviver veiculo
                //verificar se tipo ta ok
                $tipo = $this->db->query(''.
                    'SELECT t.id_tipo AS id_tipo, t.status AS status_tipo, m.id_marca AS id_marca, m.status AS status_marca, n.id_modelo AS id_modelo, n.status AS status_modelo '.
                    'FROM veiculos AS v RIGHT JOIN '.
                        'veiculos_marcas AS m ON (m.id_marca = v.id_marca) RIGHT JOIN '.
                        'veiculos_tipos AS t ON (t.id_tipo = v.id_tipo) RIGHT JOIN '.
                        'veiculos_modelos AS n ON (n.id_modelo = v.id_modelo) '.
                    'WHERE id_veiculo='.$id_veiculo
                )->result_array()[0];

                if($tipo['status_tipo'] == "0" || $tipo['status_marca'] == "0" || $tipo['status_modelo'] == "0"){
                    $return = []; 

                    if($tipo['status_tipo'] == "0"){
                        $return[] = [ 'error' => 'type_inactive',
                                        'on' => $tipo['id_tipo']];
                    }

                    if($tipo['status_marca'] == "0"){
                        $return[] = [ 'error' => 'brand_inactive',
                                        'on' => $tipo['id_marca']];
                    }

                    if($tipo['status_modelo'] == "0"){
                        $return[] = [ 'error' => 'model_inactive',
                                        'on' => $tipo['id_modelo']];
                    }

                    return $return;
                }
            }

            $this->db->where('id_veiculo', $id_veiculo);
            $this->db->update('veiculos', ['status' => $status]);
        }
        

        public function insert_veiculo($veiculo){        
            $this->db->insert('veiculos', $veiculo);
            return $this->db->insert_id();
        }

        public function update_veiculo($veiculo){
            $this->db->where('id_veiculo', $veiculo['id_veiculo']);
            $this->db->update('veiculos', $veiculo);        
        }

        /* opcionais */

        public function get_opcionais_lista(){
            $query = $this->db->get('veiculos_opcionais');
            return $query->result_array();
        }        

        public function insert_opcional($opcional){
            $this->db->insert('veiculos_opcionais', $opcional);
            return $this->db->insert_id();
        }

        public function update_opcional($opcional){
            $this->db->where('id_opcional', $opcional['id_opcional']);
            $this->db->update('veiculos_opcionais', $opcional);        
        }

        public function remove_opcional($id_opcional){
            $this->db->where('id_opcional', $id_opcional);
            $this->db->delete('relacao_veiculo_opcional');

            $this->db->where('id_opcional', $id_opcional);
            $this->db->delete('veiculos_opcionais');
        }

        public function insert_opcional_veiculo($id_veiculo, $id_opcional){
            $this->db->insert('relacao_veiculo_opcional', ['id_veiculo' => $id_veiculo, 'id_opcional' => $id_opcional]);
        }

        public function remove_opcional_veiculo($id_veiculo, $id_opcional){
            $this->db->where('id_veiculo', $id_veiculo);
            $this->db->where('id_opcional', $id_opcional);
            $this->db->delete('relacao_veiculo_opcional');
        }
        
        /* combustiveis */

        public function get_combustiveis_lista(){
            $query = $this->db->get('veiculos_combustiveis');
            return $query->result_array();
        }

        public function insert_combustivel($combustivel){
            $this->db->insert('veiculos_combustiveis', $combustivel);
            return $this->db->insert_id();
        }

        public function update_combustivel($combustivel){
            $this->db->where('id_combustivel', $combustivel['id_combustivel']);
            $this->db->update('veiculos_combustiveis', $combustivel);        
        }

        public function remove_combustivel($id_combustivel){
            $this->db->where('id_combustivel', $id_combustivel);
            $this->db->delete('relacao_veiculo_combustivel');

            $this->db->where('id_combustivel', $id_combustivel);
            $this->db->delete('veiculos_combustiveis');
        }
        
        public function insert_combustivel_veiculo($id_veiculo, $id_combustivel){
            $this->db->insert('relacao_veiculo_combustivel', ['id_veiculo' => $id_veiculo, 'id_combustivel' => $id_combustivel]);
        }
        
        public function remove_combustivel_veiculo($id_veiculo, $id_combustivel){
            $this->db->where('id_veiculo', $id_veiculo);
            $this->db->where('id_combustivel', $id_combustivel);
            $this->db->delete('relacao_veiculo_combustivel');
        }

        /* imagens */

        public function get_imagens_lista(){
            $query = $this->db->get('veiculos_imagens');
            return $query->result_array();
        }
        
        public function insert_imagem($imagem){   
            $this->db->insert('veiculos_imagens', $imagem);
            return $this->db->insert_id();
        }

        public function insert_imagem_veiculo($id_veiculo, $id_imagem, $ordem){
            $this->db->insert('relacao_veiculo_imagem', ['id_veiculo' => $id_veiculo, 'id_imagem' => $id_imagem, 'ordem' => $ordem]);
        }

        public function update_imagem_veiculo($id_veiculo, $id_imagem, $ordem){
            $this->db->where('id_veiculo', $id_veiculo);
            $this->db->where('id_imagem', $id_imagem);
            $this->db->update('relacao_veiculo_imagem', ['ordem' => $ordem]);   
        }

        public function remove_imagem_veiculo($id_veiculo, $id_imagem){
            $this->db->where('id_veiculo', $id_veiculo);
            $this->db->where('id_imagem', $id_imagem);
            $this->db->delete('relacao_veiculo_imagem');
        }

        /* SUBSTITUICAO DO ELASTICSEARCH COM MYSQL */

        public function sql_pesquisar_termo($search){
            $this->db->select('id_veiculo');
            $this->db->like('nome_marca', $search);
            $this->db->or_like('nome_modelo', $search);
            $this->db->or_like('combustivel', $search);
            $this->db->or_like('estado', $search);
            $this->db->or_like('ano', $search);
            $lvl3 = $this->db->get('visao_veiculos')->result_array();

            $this->db->select('id_veiculo');
            $this->db->like('opcionais', $search);
            $this->db->or_like('opcionais', $search);
            $lvl2 = $this->db->get('visao_veiculos')->result_array();

            $this->db->select('id_veiculo');
            $this->db->like('nome_tipo', $search);
            $this->db->or_like('observacoes', $search);
            $lvl1 = $this->db->get('visao_veiculos')->result_array();

            $lvl = array_merge($lvl3, $lvl2, $lvl1);
            $result = array();
            $result['searchfound'] = 0;
            $result['ids'] = [];
            $ids = [];
            foreach($lvl as $veiculo){
                if(!in_array($veiculo['id_veiculo'], $ids)){
                    $result['ids'][] = ['_id' => $veiculo['id_veiculo']];
                    $result['searchfound']++;
                    $ids[] = $veiculo['id_veiculo'];
                }
            }

            return $result;
        }

        public function sql_auto_complete($search){
            $this->db->select('id_veiculo');
            $this->db->select('nome_tipo');
            $this->db->select('nome_marca');
            $this->db->select('nome_modelo');
            $this->db->like('nome_tipo', $search);
            $lvl3 = $this->db->get('visao_veiculos')->result_array();

            $this->db->select('id_veiculo');
            $this->db->select('nome_tipo');
            $this->db->select('nome_marca');
            $this->db->select('nome_modelo');
            $this->db->like('nome_marca', $search);
            $this->db->or_like('nome_modelo', $search);
            $lvl2 = $this->db->get('visao_veiculos')->result_array();

            $this->db->select('id_veiculo');
            $this->db->select('nome_tipo');
            $this->db->select('nome_marca');
            $this->db->select('nome_modelo');
            $this->db->like('observacoes', $search);
            $lvl1 = $this->db->get('visao_veiculos')->result_array();

            $lvl = array_merge($lvl3, $lvl2, $lvl1);
            $result = array();
            $result['searchfound'] = 0;
            $result['results'] = [];
            $ids = [];
            foreach($lvl as $veiculo){
                if(!in_array($veiculo['id_veiculo'], $ids)){
                    $result['results'][] = [
                        '_id' => $veiculo['id_veiculo'],
                        '_source' => [
                            'nome_tipo' => $veiculo['nome_tipo'],
                            'nome_marca' => $veiculo['nome_marca'],
                            'nome_modelo' => $veiculo['nome_modelo'],
                        ]
                    ];
                    $result['searchfound']++;
                    $ids[] = $veiculo['id_veiculo'];
                }
            }

            return $result;
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