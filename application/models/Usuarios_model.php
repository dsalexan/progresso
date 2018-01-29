<?php
    class Usuarios_model extends CI_Model{

        public function __construct(){
            $this->load->database();
        }


        public function validate($username, $password){
            $this->db->select('id_usuario');
            $this->db->select('nome');
            $this->db->select('email');
            $this->db->select('username');
            $this->db->select('nivel');
            $this->db->select('permissoes');

            $this->db->where('username', $username);
            $this->db->where('senha', $password);
            $this->db->where('status', 1);

            // Run the query
            $result = $this->db->get('usuarios')->result_array();

            if(count($result) == 0) return false;

            return $result;
        }
    }