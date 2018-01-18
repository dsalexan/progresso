<?php
    class Veiculos_model extends CI_Model{

        public function __construct(){
            $this->load->database();
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

        public function get_veiculos_destaque($id_tipo){
            $this->db->where('id_tipo', $id_tipo);
            $this->db->where('destaque', 1);
            $query = $this->db->get('veiculos');

            return $query->result_array();
        }

        public function get_veiculos_por_pagina($id_tipo, $qtd_por_pagina, $numero_pagina){
            $query = $this->db->query('SELECT * FROM veiculos WHERE id_tipo = '. $id_tipo .' LIMIT '. $qtd_por_pagina .' OFFSET '. (($numero_pagina-1) * $qtd_por_pagina));
            return $query->result_array();
        }
    }