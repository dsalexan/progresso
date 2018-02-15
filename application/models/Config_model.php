<?php
    class Config_model extends CI_Model{

        public function __construct(){
            $this->load->database();
        }

        public function get_config($id_config=false){
            if($id_config == false) $id_config = $this->get_id_config();

            $this->db->where('id_config', $id_config);
            return $this->db->get('config')->result_array()[0];
        }

        public function get_email($id_config=false){
            if($id_config == false) $id_config = $this->get_id_config();

            $this->db->select('email');
            $this->db->where('id_config', $id_config);
            return $this->db->get('config')->result_array()[0]['email'];
        }

        public function get_id_config(){
            return $this->db->query('SELECT id_config FROM config ORDER BY id_config DESC')->result_array()[0]['id_config'];
        }

        public function update_config($config){
            $this->db->where('id_config', $config['id_config']);
            $this->db->update('config', $config);        
        }

    }