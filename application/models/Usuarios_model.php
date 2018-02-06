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

        public function get_usuarios_lista($status=false){
            $this->db->select('id_usuario');
            $this->db->select('nome');
            $this->db->select('username');
            $this->db->select('nivel');

            if($status !== false) {
                $this->db->select('status');
                $this->db->where('status', $status);
            }

            return $this->db->get('usuarios')->result_array();
        }

        public function get_usuario($id_usuario){
            $this->db->select('id_usuario');
            $this->db->select('nome');
            $this->db->select('email');
            $this->db->select('username');
            $this->db->select('nivel');
            $this->db->select('permissoes');
            
            $this->db->where('id_usuario', $id_usuario);
            return $this->db->get('usuarios')->result_array()[0];
        }

        public function insert_usuario($usuario){        
            $this->db->insert('usuarios', $usuario);
        }

        public function update_usuario($usuario){
            $this->db->where('id_usuario', $usuario['id_usuario']);
            $this->db->update('usuarios', $usuario);        
        }

        public function remove_usuario($id_usuario){
            $this->db->where('id_usuario', $id_usuario);
            $this->db->update('usuarios', ['status' => 0]);
        }
    }